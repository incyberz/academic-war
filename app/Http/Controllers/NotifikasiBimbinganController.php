<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiBimbingan;
use App\Models\PesertaBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Enums\StatusSesiBimbingan;
use App\Enums\StatusTerakhirBimbingan;
use App\Support\TemplatePesanBimbingan;


class NotifikasiBimbinganController extends Controller
{
    /**
     * Kirim notifikasi bimbingan (default: WhatsApp)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peserta_bimbingan_id' => ['required', 'exists:peserta_bimbingan,id'],
        ]);


        $peserta = PesertaBimbingan::findOrFail($request['peserta_bimbingan_id']);

        // Auth
        if ($peserta->bimbingan->pembimbing->dosen->user_id != Auth::id()) {
            return back()->with('error', 'Bukan mhs bimbingan Anda');
        }

        $namaDosen = $peserta->bimbingan->pembimbing->dosen->namaGelar();
        $lastBimbingan = $peserta->lastBimbingan();

        $statusSesi = $lastBimbingan
            ? StatusSesiBimbingan::tryFrom($lastBimbingan->status_sesi_bimbingan)
            : StatusSesiBimbingan::BELUM;

        if ($peserta->terakhir_bimbingan) {
            $diffHari = now()->diffInDays($peserta->terakhir_bimbingan);

            $statusWaktu = match (true) {
                $diffHari <= 7  => StatusTerakhirBimbingan::ONTIME,
                $diffHari <= 14 => StatusTerakhirBimbingan::TELAT,
                default         => StatusTerakhirBimbingan::KRITIS,
            };
        } else {
            $statusWaktu = StatusTerakhirBimbingan::BELUM;
        }


        $pesanSistem = TemplatePesanBimbingan::whatsapp(
            namaMahasiswa: $peserta->mhs->nama_lengkap,
            namaDosen: $namaDosen,
            statusSesi: $statusSesi,
            statusWaktu: $statusWaktu,
        );

        $pesanDosen = memoBimbingan($statusSesi, $statusWaktu);

        $pesanLink = rtrim(config('app.url'), '/')
            . '/peserta-bimbingan/'
            . $peserta->id;
        $pesanFooter = footerWhatsapp();

        // Save to DB
        $notifikasi = NotifikasiBimbingan::create([
            'peserta_bimbingan_id'      => $peserta->id,
            'status_sesi_bimbingan'     => $statusSesi->value,
            'status_terakhir_bimbingan' => $statusWaktu->value,
        ]);

        // UI untuk dosen agar klik send whatsapp (sent_by dan sent_at terisi)
        return view('notifikasi-bimbingan.send-whatsapp', compact(
            'pesanSistem',
            'pesanDosen',
            'pesanFooter',
            'pesanLink',
            'notifikasi',
            'peserta',
        ));
    }

    /**
     * Riwayat notifikasi per peserta
     */
    public function index($pesertaBimbinganId)
    {
        $peserta = PesertaBimbingan::findOrFail($pesertaBimbinganId);

        $notifikasi = NotifikasiBimbingan::where('peserta_bimbingan_id', $pesertaBimbinganId)
            ->latest('sent_at')
            ->get();

        return view('bimbingan.notifikasi.index', compact('peserta', 'notifikasi'));
    }
}
