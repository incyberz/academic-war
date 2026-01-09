<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\JenisBimbinganController;
use App\Http\Controllers\SesiBimbinganController;
use App\Http\Controllers\PesertaBimbinganController;
use App\Http\Controllers\TahunAjarController;
use App\Http\Controllers\WhatsappController;


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

    Route::resource('peserta-bimbingan', PesertaBimbinganController::class);
    Route::get(
        '/peserta-bimbingan/{id}/inline',
        [PesertaBimbinganController::class, 'inline']
    )->name('peserta-bimbingan.inline');


    Route::resource('sesi-bimbingan', SesiBimbinganController::class)->only('create', 'store', 'update');

    Route::get(
        '/sesi-bimbingan/{sesi}',
        [SesiBimbinganController::class, 'show']
    )->name('sesi-bimbingan.show');


    // web.php
    // Route::get(
    //     '/sesi-bimbingan/{pesertaBimbingan}/create',
    //     [SesiBimbinganController::class, 'create']
    // )->name('sesi-bimbingan.create');


    // ===================================
    // ROUTE KHUSUS PEMBIMBING AKTIF
    // ===================================
    Route::middleware('pembimbing.aktif')->group(function () {

        Route::resource('bimbingan', BimbinganController::class);


        // kalau nanti mau ditambah:
        // Route::post('/bimbingan/{id}/setujui', ...);
        // Route::post('/bimbingan/{id}/tolak', ...);
    });



    Route::post('/whatsapp/send/{sesi}', [WhatsappController::class, 'send'])
        ->name('whatsapp.send');
});


require __DIR__ . '/auth.php';
