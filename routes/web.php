<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\JenisBimbinganController;
use App\Http\Controllers\SesiBimbinganController;
use App\Http\Controllers\PesertaBimbinganController;
use App\Http\Controllers\TahunAjarController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\NotifikasiBimbinganController;



Route::get('/', function () {
    // return redirect('/login');
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // =========================
    // ROUTE UMUM (SEMUA USER)
    // =========================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::resource('jenis-bimbingan', JenisBimbinganController::class);

    Route::get('/tahun-ajar/set/{id}', [TahunAjarController::class, 'set'])
        ->name('tahun-ajar.set');

    Route::post('/admin/tahun-ajar/aktif', [TahunAjarController::class, 'setAktif'])
        ->name('tahun-ajar.set-aktif');




    # ============================================================
    # ROUTE KHUSUS PEMBIMBING AKTIF
    # ============================================================
    Route::middleware('pembimbing.aktif')->group(function () {

        Route::resource('bimbingan', BimbinganController::class);

        // rute ke peserta bimbingan @superCreate
        Route::get(
            '/peserta-bimbingan/{bimbingan}/jenis/{jenisBimbingan}/super-create',
            [PesertaBimbinganController::class, 'superCreate']
        )->name('peserta-bimbingan.super-create');


        // rute ke peserta bimbingan @superCreate
        Route::post(
            '/peserta-bimbingan/{bimbingan}/jenis/{jenisBimbingan}/super-store',
            [PesertaBimbinganController::class, 'superStore']
        )->name('peserta-bimbingan.super-store');

        // dosen boleh update whatsapp mhs bimbingannya
        Route::put(
            '/dosen/bimbingan/{pesertaBimbingan}/update-whatsapp',
            [PesertaBimbinganController::class, 'updateWhatsappMyBimbingan']
        )->name('dosen.bimbingan.update-whatsapp');
    });


    # ============================================================
    # RUTE UMUM BIMBINGAN
    # ============================================================
    Route::resource('peserta-bimbingan', PesertaBimbinganController::class);
    Route::resource('sesi-bimbingan', SesiBimbinganController::class); //->only('create', 'store', 'update', 'destroy');

    // Route::get(
    //     '/sesi-bimbingan/{sesi}',
    //     [SesiBimbinganController::class, 'show']
    // )->name('sesi-bimbingan.show');



    # ============================================================
    # GOD MODE 
    # ============================================================
    // dosen boleh set tahapan peserta bimbingan nya
    Route::post(
        '/peserta-bimbingan/{pesertaBimbingan}/set-tahapan',
        [PesertaBimbinganController::class, 'setTahapan']
    )->name('peserta-bimbingan.set-tahapan');




    # ============================================================
    # WHATSAPP
    # ============================================================
    Route::post('/whatsapp/send/{sesi}', [WhatsappController::class, 'send'])
        ->name('whatsapp.send');

    Route::post(
        '/notifikasi-bimbingan',
        [NotifikasiBimbinganController::class, 'store']
    )->name('notifikasi-bimbingan.store');
});


require __DIR__ . '/auth.php';
