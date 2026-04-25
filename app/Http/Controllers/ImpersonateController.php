<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    # ============================================================
    # IMPERSONATE
    # ============================================================
    public function impersonate($id)
    {
        $target = User::findOrFail($id);

        $user = Auth::user();

        // siapa boleh impersonate
        if (!(isDosen() || isRole('akademik'))) {
            abort(403);
        }

        // target harus mahasiswa
        if ($target->role_id != config('roles.mhs.id')) {
            abort(403);
        }

        $user->impersonate($target);

        return redirect('/dashboard');
    }

    public function leave()
    {
        // kalau pakai lab404/laravel-impersonate
        Auth::user()->leaveImpersonation();

        return redirect()->route('dashboard');
    }
}
