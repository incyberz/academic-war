<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TahunAjarService;
use Illuminate\Support\Facades\Session;

class ResolveTahunAjar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika session belum punya tahun ajar
        if (!Session::has('tahun_ajar_id')) {
            $tahunAjar = TahunAjarService::getAktif();

            if ($tahunAjar) {
                Session::put('tahun_ajar_id', $tahunAjar->id);
            }
        }

        return $next($request);
    }
}
