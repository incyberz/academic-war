<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $dosen = isDosen() ? $user->dosen->where('user_id', $user->id)->first() : null;
        $mhs = isMhs() ? $user->mhs->where('user_id', $user->id)->first() : null;
        $akademik = isAkademik() ? $user->admin->where('user_id', $user->id)->first() : null;

        $bimbingans = null;
        if ($dosen) {
            $bimbingans = $dosen->pembimbing->bimbingan()->with('pesertaBimbingan.mhs')->get();
        }


        return view('dashboard', compact(
            'user',
            'dosen',
            'mhs',
            'akademik',
            'bimbingans',
        ));
    }
}
