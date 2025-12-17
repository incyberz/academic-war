<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;

class UsersDosenSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================
        // 1. User + Dosen: iin
        // ==========================
        $iinUser = User::updateOrCreate(
            ['username' => 'iin'], // cek berdasarkan username
            [
                'email' => 'iin@gmail.com',
                'name' => 'Kang Solihin',
                'role' => 'dosen',
                'password' => Hash::make('iin'),
            ]
        );

        Dosen::updateOrCreate(
            ['user_id' => $iinUser->id], // cek dosen berdasarkan user_id
            [
                'nama' => 'Iin Sholihin',
                'prodi' => DB::table('prodi')->where('prodi', 'KA')->value('id'), // FK ke prodi by id
            ]
        );

        // ==========================
        // 2. User + Dosen: topan
        // ==========================
        $topanUser = User::updateOrCreate(
            ['username' => 'topan'],
            [
                'email' => 'topan@gmail.com',
                'name' => 'Topan Trianto',
                'role' => 'dosen',
                'password' => Hash::make('topan'),
            ]
        );

        Dosen::updateOrCreate(
            ['user_id' => $topanUser->id],
            [
                'nama' => 'Topan Trianto',
                'prodi' => DB::table('prodi')->where('prodi', 'BD')->value('id'), // FK ke prodi by id
            ]
        );
    }
}
