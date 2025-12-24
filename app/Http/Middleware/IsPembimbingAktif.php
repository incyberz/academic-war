<?php

namespace App\Http\Middleware;

use App\Models\Dosen;
use App\Models\Pembimbing;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsPembimbingAktif
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Belum login
        if (!$user) {
            return $this->unauthorized(
                $request,
                'Anda belum login.'
            );
        }

        // Bukan dosen
        $dosen = Dosen::where('user_id', $user->id)->first();

        if (!$dosen) {
            return $this->unauthorized(
                $request,
                'Akun Anda tidak terdaftar sebagai dosen.'
            );
        }

        // Dosen tapi bukan pembimbing aktif
        $pembimbing = Pembimbing::where('dosen_id', $dosen->id)
            ->where('is_active', true)
            ->first();

        if (!$pembimbing) {
            return $this->unauthorized(
                $request,
                'Anda tidak terdaftar sebagai pembimbing aktif.'
            );
        }

        /**
         * Inject ke request
         * agar bisa dipakai di controller tanpa query ulang
         */
        $request->merge([
            'dosen'      => $dosen,
            'pembimbing' => $pembimbing,
        ]);

        return $next($request);
    }

    /**
     * Response jika tidak berhak
     */
    protected function unauthorized(Request $request, string $message): Response
    {
        // Untuk SPA / API
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
            ], 403);
        }

        // Untuk Web
        return redirect()
            ->route('jenis-bimbingan.index')
            ->with('error', $message);
    }
}
