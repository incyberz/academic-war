<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\JenisBimbinganController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // route resorces untuk model akun
    Route::resource('bimbingan', BimbinganController::class);
    Route::resource('jenis-bimbingan', JenisBimbinganController::class);

    // Route::get('/set-tahun-ajar/{id}', function ($id) {
    //     session(['tahun_ajar_id' => $id]);
    //     return back();
    // })->name('tahun-ajar.set');

    Route::get(
        '/tahun-ajar/set/{id}',
        [TahunAjarController::class, 'set']
    )->name('tahun-ajar.set');

    // admin only
    Route::post(
        '/admin/tahun-ajar/aktif',
        [TahunAjarController::class, 'setAktif']
    )->name('tahun-ajar.set-aktif');
});

require __DIR__ . '/auth.php';
