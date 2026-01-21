<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiBimbingan;
use App\Models\Dosen;
use App\Models\PesertaBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Enums\StatusSesiBimbingan;
use App\Enums\StatusTerakhirBimbingan;
use App\Models\Pembimbing;
use App\Support\TemplatePesanBimbingan;
use Illuminate\Support\Facades\DB;


class NotifikasiBimbinganController extends Controller
{

    protected function normalizeWa(?string $number): ?string
    {
        if (!$number) return null;

        $number = preg_replace('/[^0-9]/', '', $number);

        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }

        if (str_starts_with($number, '8')) {
            return '62' . $number;
        }

        return $number;
    }

    protected function isValidWhatsApp(?string $number): bool
    {
        if (!$number) return false;

        $number = preg_replace('/[^0-9]/', '', $number);

        return strlen($number) >= 10 && strlen($number) <= 15;
    }


    public function store(Request $request)
    {
        $request->validate([
            'peserta_bimbingan_id'       => ['required', 'exists:peserta_bimbingan,id'],
            'pesan'                      => ['required', 'string'],
            'status_sesi_bimbingan'      => ['required', 'integer'],
            'status_terakhir_bimbingan'  => ['required', 'integer'],
        ]);

        $peserta = PesertaBimbingan::with([
            'mhs.user',
            'bimbingan',
        ])->findOrFail($request->peserta_bimbingan_id);

        $userMhs = $peserta->mhs->user;
        $rawWa   = $userMhs->whatsapp;
        if ($request->wa_message_template) {
            $bimbingan = $peserta->bimbingan;
            $bimbingan->update(['wa_message_template', $request->wa_message_template]);
        }

        // ✅ Validasi & normalisasi nomor
        $waValid = $this->isValidWhatsApp($rawWa);
        $waFinal = $waValid ? $this->normalizeWa($rawWa) : null;

        // Enum safety
        $statusSesi   = StatusSesiBimbingan::from((int) $request->status_sesi_bimbingan);
        $statusWaktu  = StatusTerakhirBimbingan::from((int) $request->status_terakhir_bimbingan);

        $notifikasi = NotifikasiBimbingan::where('peserta_bimbingan_id', $peserta->id)
            ->whereNull('status_pengiriman')
            ->first();

        if ($notifikasi) {
            $notifikasi->update([
                'status_sesi_bimbingan'     => $statusSesi->value,
                'status_terakhir_bimbingan' => $statusWaktu->value,
                'sent_by'                   => Auth::id(),
                'sent_at'                   => now(),
            ]);
        } else {
            $notifikasi = NotifikasiBimbingan::create([
                'peserta_bimbingan_id'      => $peserta->id,
                'status_sesi_bimbingan'     => $statusSesi->value,
                'status_terakhir_bimbingan' => $statusWaktu->value,
                'sent_by'                   => Auth::id(),
                'sent_at'                   => now(),
            ]);
        }

        // 🔗 URL WhatsApp (jika valid)
        $waUrl = null;
        if ($waValid) {
            $waUrl = 'https://api.whatsapp.com/send'
                . '?phone=' . $waFinal
                . '&text=' . urlencode($request->pesan);
        }

        return view('notifikasi-bimbingan.form-post-send-whatsapp', [
            'notifikasi' => $notifikasi,
            'peserta'    => $peserta,
            'mhs'  => $userMhs,
            'wa_valid'   => $waValid,
            'wa_number'  => $waFinal,
            'wa_url'     => $waUrl,
            'pesan'      => $request->pesan,
        ]);
    }


    public function preview_whatsapp()
    {

        $peserta_bimbingan_id = request('peserta_bimbingan_id');
        $peserta = PesertaBimbingan::findOrFail($peserta_bimbingan_id);

        // Auth
        if ($peserta->bimbingan->pembimbing->dosen->user_id != Auth::id()) {
            return back()->with('error', 'Bukan mhs bimbingan Anda');
        }

        $namaDosen = $peserta->bimbingan->pembimbing->dosen->namaGelar();
        $lastBimbingan = $peserta->lastBimbingan();


        $statusWaktu = StatusTerakhirBimbingan::BELUM;
        $statusSesi = StatusSesiBimbingan::BELUM;

        if ($lastBimbingan) {
            $statusSesi = StatusSesiBimbingan::tryFrom($lastBimbingan->status_sesi_bimbingan);
            if ($peserta->terakhir_bimbingan) {
                $diffHari = now()->diffInDays($peserta->terakhir_bimbingan);

                $statusWaktu = match (true) {
                    $diffHari <= 7  => StatusTerakhirBimbingan::ONTIME,
                    $diffHari <= 14 => StatusTerakhirBimbingan::TELAT,
                    default         => StatusTerakhirBimbingan::KRITIS,
                };
            }
        }

        $pesanSistem = TemplatePesanBimbingan::whatsapp(
            namaMahasiswa: $peserta->mhs->nama_lengkap,
            namaDosen: $namaDosen,
            statusSesi: $statusSesi,
            statusWaktu: $statusWaktu,
        );

        $pesanAuto = memoBimbingan($statusSesi, $statusWaktu);

        $pesanLink = rtrim(config('app.url'), '/')
            . '/peserta-bimbingan/'
            . $peserta->id;
        $pesanFooter = footerWhatsapp();

        // UI untuk dosen agar klik send whatsapp (sent_by dan sent_at terisi)
        return view('notifikasi-bimbingan.send-whatsapp', compact(
            'pesanSistem',
            'pesanAuto',
            'pesanFooter',
            'pesanLink',
            // 'notifikasi',
            'peserta',
            'statusSesi',
            'statusWaktu',
        ));
    }

    /**
     * Riwayat notifikasi per peserta
     */
    public function index()
    {
        if (isRole('dosen')) {
            $dosen = Dosen::where('user_id', Auth::id())->firstOrFail();

            $pembimbing = Pembimbing::where('dosen_id', $dosen->id)->firstOrFail();

            $notifs = NotifikasiBimbingan::whereHas('pesertaBimbingan.bimbingan', function ($q) use ($pembimbing) {
                $q->where('pembimbing_id', $pembimbing->id);
            })->latest()->get();
        } else {
            dd('belum ada index untuk role selain dosen');
        }

        return view('notifikasi-bimbingan.index', compact('dosen', 'pembimbing', 'notifs'));
    }


    public function verify(Request $request, NotifikasiBimbingan $notifikasi)
    {
        // ================= VALIDASI =================
        $request->validate([
            'status_pengiriman' => 'required|in:1,-1',
        ]);

        // ================= AUTHORIZATION (OPSIONAL KETAT) =================
        // Pastikan hanya dosen pengirim yang boleh memverifikasi
        if ($notifikasi->sent_by !== Auth::id()) {
            abort(403, 'Anda tidak berhak memverifikasi notifikasi ini.');
        }

        // ================= UPDATE DATA =================
        $notifikasi->update([
            'status_pengiriman'  => (int) $request->status_pengiriman,
            'verified_at'        => now(),
        ]);

        return redirect()
            ->route('notifikasi-bimbingan.index')
            ->with(
                'success',
                $request->status_pengiriman == 1
                    ? 'Status pengiriman WhatsApp berhasil dikonfirmasi.'
                    : 'Status pengiriman WhatsApp dicatat sebagai tidak terkirim.'
            );
    }
}
