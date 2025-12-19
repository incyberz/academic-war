<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\TahunAjar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('listTahunAjar', TahunAjar::orderBy('id', 'desc')->get());
        });

        View::share('tahunAjarAktif', session('tahun_ajar_id'));

        View::share(
            'semesterAktif',
            session('tahun_ajar_id') ? substr(session('tahun_ajar_id'), -1) : null
        );

        View::share(
            'role_name',
            auth()->check() ? auth()->user()->role->role_name : null
        );
    }
}
