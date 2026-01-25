<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MhsController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\JenisBimbinganController;
use App\Http\Controllers\SesiBimbinganController;
use App\Http\Controllers\PesertaBimbinganController;
use App\Http\Controllers\TahunAjarController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\NotifikasiBimbinganController;

use App\Http\Controllers\{
    CourseController,
    UnitController,
    QuestController,
    ChallengeController,
    ChallengeLevelController,
    ChallengeSubmissionController,
    ChallengeLevelSubmissionController,
    QuestSubmissionController,
    MkController,
    PertemuanController,
    MkTaController,
    ShiftController,
    KelasController,
    KelasMhsController,
    SoalController,
    KuisController,
    KuisSoalController,
    JawabanMhsController,
    PertemuanTaController,
    PertemuanKelasController,
    PresensiDosenController,
    PresensiMhsController,
    PresensiOfflineController,
};



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

    Route::put('/user/update-alamat', [UserController::class, 'updateAlamat'])
        ->name('user.update-alamat');

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
    Route::resource('jenis-bimbingan', JenisBimbinganController::class);
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

    Route::get(
        '/preview_whatsapp/{peserta_bimbingan_id}',
        [NotifikasiBimbinganController::class, 'preview_whatsapp']
    )->name('preview_whatsapp');

    Route::post(
        '/notifikasi-bimbingan/{notifikasi}/verify',
        [NotifikasiBimbinganController::class, 'verify']
    )->name('notifikasi-bimbingan.verify');

    Route::resource('mhs', MhsController::class);
    Route::resource('dosen', DosenController::class);
    Route::resource('notifikasi-bimbingan', NotifikasiBimbinganController::class);

    // Akademik / Course System
    Route::resource('course', CourseController::class);
    Route::resource('unit', UnitController::class);
    Route::resource('quest', QuestController::class);
    Route::resource('challenge', ChallengeController::class);
    Route::resource('challenge-level', ChallengeLevelController::class);
    Route::resource('challenge-submission', ChallengeSubmissionController::class);
    Route::resource('challenge-level-submission', ChallengeLevelSubmissionController::class);
    Route::resource('quest-submission', QuestSubmissionController::class);

    // Mata Kuliah
    Route::resource('mk', MkController::class);
    Route::resource('pertemuan', PertemuanController::class);
    Route::resource('mk-ta', MkTaController::class);

    // Kelas / Shift
    Route::resource('shift', ShiftController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('kelas-mhs', KelasMhsController::class);

    // Soal & Kuis
    Route::resource('soal', SoalController::class);
    Route::resource('kuis', KuisController::class);
    Route::resource('kuis-soal', KuisSoalController::class);
    Route::resource('jawaban-mhs', JawabanMhsController::class);

    // Pertemuan terkait TA / Kelas
    Route::resource('pertemuan-ta', PertemuanTaController::class);
    Route::resource('pertemuan-kelas', PertemuanKelasController::class);

    // Presensi
    Route::resource('presensi-dosen', PresensiDosenController::class);
    Route::resource('presensi-mhs', PresensiMhsController::class);
    Route::resource('presensi-offline', PresensiOfflineController::class);
});


require __DIR__ . '/auth.php';
