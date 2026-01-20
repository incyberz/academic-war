<?php

namespace App\Http\Controllers;

use App\Models\Whatsapp;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class WhatsappController extends Controller
{
    /**
     * Tampilkan halaman kirim pesan WhatsApp untuk satu pengajuan.
     */
    public function show($pengajuanId)
    {
        $isCota = isRole('cota');
        $isLpa = isRole('lpa');
        if ($isCota || $isLpa) {
            return back()->with('error', 'Akun COTA atau LPA tidak berhak mengakses Fitur Whatsapp Gateway');
        }


        $pengajuan = Pengajuan::findOrFail($pengajuanId);
        $suami = $pengajuan->cota->husband_name;
        $istri = $pengajuan->cota->wife_name;
        $pasangan = pasangan($suami, $istri);

        // Ambil status pengajuan dan tentukan pesan otomatis
        $is_mandiri = $pengajuan->is_mandiri;
        if ($is_mandiri) {
            $last_login = $pengajuan->cota->user->last_login;
            $no_tujuan = $pengajuan->cota->user->phone_number;
            $alamat = $pengajuan->cota->user->address;
            $COTA = 'COTA';
        } else {
            $COTA = 'LPA';
            $last_login = $pengajuan->cota->lpa->user->last_login;
            $no_tujuan = $pengajuan->cota->lpa->user->phone_number;
            $alamat = $pengajuan->cota->lpa->user->address;
            $nama_user_lpa = $pengajuan->cota->lpa->user->name;
            $pasangan = "
                $nama_user_lpa (LPA)\n
                Perwakilan Pasangan $pasangan
            ";
        }
        $nama_status = null;
        $status_pengajuan = config('status_pengajuan');
        foreach ($status_pengajuan as $key => $value) {
            if ($value == $pengajuan->status) {
                $nama_status = $key;
                break;
            }
        }

        if (!$nama_status) dd('Invalid nama_status untuk status pengajuan: ' . $pengajuan->status);
        $status_pengajuan_show = 'Kode ' . $pengajuan->status . " - $nama_status";

        $pesan_config = config("pesan_whatsapp.$nama_status");
        $nama_prov = ucwords(strtolower($pengajuan->cota->kab->prov->provinsi));
        $timestamp = date('d M, Y, H:i:s');
        $garis = '============================';
        $pesan_header = "Yth. $pasangan ($COTA)<br>
di $alamat<br>
<br>
Saat ini Status Pengajuan Anda:<br>
[ $status_pengajuan_show ]<br>
============================<br>
";

        $pesan_footer = "
============================<br>
Pesan Dari:<br>
Sistem Permohonan Izin Pengangkatan Anak (TEMAN IPAN)<br>
Dinas Sosial $nama_prov<br>
$timestamp<br>
============================<br>
";



        return view('whatsapp.show', compact(
            'pengajuan',
            'pesan_header',
            'pesan_footer',
            'pesan_config',
            'no_tujuan',
            'is_mandiri',
            'garis'
        ));
    }

    /**
     * Proses penyimpanan riwayat dan buka WhatsApp API.
     */
    /*public function kirim(Request $request, $pengajuanId)
    {
        $request->validate([
            'pesan' => 'required|string',
            'jenis' => 'required|in:info,warning,success',
        ]);

        $pengajuan = Pengajuan::findOrFail($pengajuanId);
        $nomorWa = $pengajuan->cota->whatsapp ?? null;

        if (!$nomorWa) {
            return back()->with('error', 'Nomor WhatsApp penerima tidak ditemukan.');
        }

        // Simpan riwayat pesan di tabel whatsapp
        Whatsapp::create([
            'pengajuan_id' => $pengajuanId,
            'user_id'      => auth()->id(),
            'pesan'        => $request->pesan,
            'jenis'        => $request->jenis,
        ]);

        // Format nomor WA ke internasional (hapus 0 jadi +62)
        $nomorWa = preg_replace('/^0/', '+62', $nomorWa);

        // Encode pesan agar aman di URL
        $pesanEncode = urlencode($request->pesan);

        // Redirect ke link WA resmi (buka tab baru di browser)
        return redirect()->away("https://api.whatsapp.com/send?phone={$nomorWa}&text={$pesanEncode}");
    }
        */


    /**
     * Simpan Riwayat Kirim Whatsapp
     */
    function simpan(Request $request, $pengajuanId)
    {
        $isCota = isRole('cota');
        $isLpa = isRole('lpa');
        if ($isCota || $isLpa) {
            return back()->with('error', 'Akun COTA atau LPA tidak berhak mengakses Fitur Whatsapp Gateway');
        }
        return back()->with('error', 'Fitur is Ready.');
    }
}
