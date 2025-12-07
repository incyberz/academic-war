<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mhs;
use App\Models\PesertaBimbingan;

class PesertaBimbinganSeeder extends Seeder
{
    public function run(): void
    {
        // User yang menunjuk
        $insho = User::where('username', 'insho')->firstOrFail();

        $data = [
            [
                'username' => 'ahmad',
                'nama' => 'Ahmad Firdaus',
                'email' => 'ahmad@gmail.com',
                'angkatan' => 2022,
            ],
            [
                'username' => 'salwa',
                'nama' => 'Salwa Fatimah',
                'email' => 'salwa@gmail.com',
                'angkatan' => 2022,
            ],
            [
                'username' => 'yusuf',
                'nama' => 'Yusuf Ammar',
                'email' => 'yusuf@gmail.com',
                'angkatan' => 2022,
            ],
            [
                'username' => 'khalid',
                'nama' => 'Khalid Ibrahim',
                'email' => 'khalid@gmail.com',
                'angkatan' => 2022,
            ],
        ];

        foreach ($data as $m) {

            // 1. Insert user
            $user = User::firstOrCreate(
                ['username' => $m['username']],
                [
                    'name' => $m['nama'],
                    'email' => $m['email'],
                    'password' => Hash::make($m['username']),
                ]
            );

            // 2. Insert mahasiswa
            $mhs = Mhs::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => strtoupper($m['username']) . '001', // contoh NIM sementara
                    'nama' => $m['nama'],
                    'angkatan' => $m['angkatan'],
                    'prodi_id' => null,
                ]
            );

            // 3. Insert peserta bimbingan
            PesertaBimbingan::firstOrCreate(
                ['mhs_id' => $mhs->id],
                [
                    'ditunjuk_oleh' => $insho->id,
                    'jenis_bimbingan' => 'pkl', // placeholder (boleh disesuaikan)
                ]
            );
        }
    }
}
