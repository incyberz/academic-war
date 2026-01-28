<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\TahunAjar;
use App\Services\TahunAjarService;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {

            // 🔹 Pastikan tahun ajar ada di session
            if (!session()->has('tahun_ajar_id')) {
                $ta = TahunAjarService::getAktif();
                session(['tahun_ajar_id' => $ta->id]);
            }

            $taId = session('tahun_ajar_id');
            $tahunAktif = substr($taId, 0, 4);
            $semesterAktif = substr($taId, -1);

            $view->with([
                'listTahunAjar'   => TahunAjar::orderBy('id', 'desc')->get(),
                'tahunAktif'  => $tahunAktif,
                'semesterAktif'   => $semesterAktif,
                'taAktif'   => $tahunAktif . '/' . ($tahunAktif + 1) . ' ' . ($semesterAktif % 2 == 0 ? 'Genap' : 'Ganjil'),
                'role'       => Auth::check()
                    ? Auth::user()->role->role_name
                    : null,
            ]);
        });
    }
}
