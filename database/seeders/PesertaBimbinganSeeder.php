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
        // Pastikan user 'insho' ada (super admin)
        $insho = User::firstOrCreate(
            ['username' => 'insho'],
            [
                'name' => 'Super Admin',
                'email' => 'insho@gmail.com',
                'role' => 'super_admin',
                'whatsapp' => '6287729007318',
                'whatsapp_verified_at' => now(),
                'password' => Hash::make('insho'),
            ]
        );

        $mahasiswaData = [
            ['username' => 'ahmad', 'nama' => 'Ahmad Firdaus', 'email' => 'ahmad@gmail.com', 'angkatan' => 2022],
            ['username' => 'salwa', 'nama' => 'Salwa Fatimah', 'email' => 'salwa@gmail.com', 'angkatan' => 2022],
            ['username' => 'yusuf', 'nama' => 'Yusuf Ammar', 'email' => 'yusuf@gmail.com', 'angkatan' => 2022],
            ['username' => 'khalid', 'nama' => 'Khalid Ibrahim', 'email' => 'khalid@gmail.com', 'angkatan' => 2022],
        ];

        foreach ($mahasiswaData as $m) {

            // 1. Buat user jika belum ada
            $user = User::firstOrCreate(
                ['username' => $m['username']],
                [
                    'name' => $m['nama'],
                    'email' => $m['email'],
                    'password' => Hash::make($m['username']),
                ]
            );

            // 2. Buat record mahasiswa
            $mhs = Mhs::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => $m['nama'],
                    'nim' => strtoupper($m['username']) . '001',
                    'angkatan' => $m['angkatan'],
                    'status_mhs_id' => 1, // default aktif
                ]
            );

            // 3. Buat peserta bimbingan jika belum ada
            PesertaBimbingan::firstOrCreate(
                [
                    'mhs_id' => $mhs->id,
                    'jenis_bimbingan' => 'pkl',
                ],
                [
                    'ditunjuk_oleh' => $insho->id,
                    'tanggal_penunjukan' => now(),
                    'status_peserta' => 'aktif',
                ]
            );
        }
    }
}
