<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mhs;
use App\Models\PesertaBimbingan;
use Illuminate\Support\Facades\DB;

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
                'role_id' => 100, // super admin
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

        // Ambil role_id untuk mahasiswa
        $roleId = DB::table('role')->where('role_name', 'mhs')->first()->id;

        foreach ($mahasiswaData as $m) {

            // 1. Buat user jika belum ada
            $user = User::firstOrCreate(
                ['username' => $m['username']],
                [
                    'name' => $m['nama'],
                    'email' => $m['email'],
                    'password' => Hash::make($m['username']),
                    'role_id' => $roleId,
                    'avatar' => 'img/mhs/mhs' . rand(1, 6) . '.jpg',
                ]
            );


            // updateOrInsert status_mhs 
            DB::table('status_mhs')->updateOrInsert(
                ['kode' => 'aktif'],
                [
                    'nama' => 'Aktif',
                    'keterangan' => 'Belum dinyatakan cuti atau DO',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );



            // get status_mhs_id aktif
            $statusMhsId = DB::table('status_mhs')->where('kode', 'aktif')->first()->id;

            // 2. Buat record mahasiswa
            $mhs = Mhs::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_lengkap' => $m['nama'],
                    'nim' => strtoupper($m['username']) . '001',
                    'angkatan' => $m['angkatan'],
                    'status_mhs_id' => $statusMhsId, // default aktif
                ]
            );

            // 3. Buat peserta bimbingan jika belum ada
            PesertaBimbingan::firstOrCreate(
                [
                    'mhs_id' => $mhs->id,
                ],
                [
                    'bimbingan_id' => rand(1, 4), // asumsikan ada 4 bimbingan
                    'ditunjuk_oleh' => $insho->id,
                ]
            );
        }
    }
}
