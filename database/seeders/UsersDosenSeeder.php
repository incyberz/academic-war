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
        $insho = User::updateOrCreate(
            ['username' => 'iin'], // cek berdasarkan username
            [
                'email' => 'iin@gmail.com',
                'name' => 'Kang Solihin',
                'role' => 'dosen',
                'password' => Hash::make('iin'),
            ]
        );

        Dosen::updateOrCreate(
            ['user_id' => $insho->id], // cek dosen berdasarkan user_id
            [
                'nama' => 'Iin Sholihin',
                'prodi' => 'KA',
            ]
        );

        // ==========================
        // 2. User + Dosen: topan
        // ==========================
        $topan = User::updateOrCreate(
            ['username' => 'topan'], // cek based on username
            [
                'email' => 'topan@gmail.com',
                'name' => 'Topan Trianto',
                'role' => 'dosen',
                'password' => Hash::make('topan'),
            ]
        );

        Dosen::updateOrCreate(
            ['user_id' => $topan->id],
            [
                'nama' => 'Topan Trianto',
                'prodi' => 'BD',
            ]
        );
    }
}
