<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\JenisBimbinganController;
use App\Http\Controllers\PesertaBimbinganController;
use App\Http\Controllers\TahunAjarController;

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

    // ===================================
    // ROUTE KHUSUS PEMBIMBING AKTIF
    // ===================================
    Route::middleware('pembimbing.aktif')->group(function () {

        Route::resource('bimbingan', BimbinganController::class);

        Route::resource('peserta-bimbingan', PesertaBimbinganController::class)
            ->only(['create', 'edit', 'store', 'update']);

        Route::delete(
            '/peserta-bimbingan/{peserta_bimbingan_id}',
            [PesertaBimbinganController::class, 'destroy']
        )->name('peserta-bimbingan.destroy');


        // kalau nanti mau ditambah:
        // Route::post('/bimbingan/{id}/setujui', ...);
        // Route::post('/bimbingan/{id}/tolak', ...);
    });
});


require __DIR__ . '/auth.php';
