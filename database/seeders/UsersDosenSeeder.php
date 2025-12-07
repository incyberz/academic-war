<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dosen;

class UsersDosenSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================
        // 1. User + Dosen: insho
        // ==========================
        $insho = User::create([
            'username' => 'iin',
            'email' => 'iin@gmail.com',
            'name' => 'Kang Solihin',
            'password' => Hash::make('iin'), // silakan ganti
        ]);

        Dosen::create([
            'nama' => 'Iin Sholihin',
            'user_id' => $insho->id,
            'prodi_id' => 5, // KA
            'nidn' => null,
            'gelar_depan' => null,
            'gelar_belakang' => null,
            'jabatan_fungsional' => null,
        ]);

        // ==========================
        // 2. User + Dosen: topan
        // ==========================
        $topan = User::create([
            'username' => 'topan',
            'email' => 'topan@gmail.com',
            'name' => 'Topan',
            'password' => Hash::make('topan'), // silakan ganti
        ]);

        Dosen::create([
            'nama' => 'Topan Trianto',
            'user_id' => $topan->id,
            'prodi_id' => 4, // BD
            'nidn' => null,
            'gelar_depan' => null,
            'gelar_belakang' => null,
            'jabatan_fungsional' => null,
        ]);
    }
}
