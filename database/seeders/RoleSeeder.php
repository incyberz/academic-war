<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Data role
        $roles = [
            ['kode' => 'super_admin', 'nama' => 'Super Admin', 'deskripsi' => 'Akses penuh ke seluruh sistem'],
            ['kode' => 'admin',       'nama' => 'Admin', 'deskripsi' => 'Admin sistem dan operasional umum'],
            ['kode' => 'akademik',    'nama' => 'Akademik', 'deskripsi' => 'Pengelola data akademik'],
            ['kode' => 'kaprodi',     'nama' => 'Kaprodi', 'deskripsi' => 'Ketua Program Studi'],
            ['kode' => 'dosen',       'nama' => 'Dosen', 'deskripsi' => 'Tenaga pendidik dan pembimbing'],
            ['kode' => 'mahasiswa',   'nama' => 'Mahasiswa', 'deskripsi' => 'Peserta pendidikan'],
        ];

        foreach ($roles as $role) {
            DB::table('role')->updateOrInsert(
                ['kode' => $role['kode']], // gunakan kode sebagai key unik
                [
                    'nama' => $role['nama'],
                    'deskripsi' => $role['deskripsi'],
                ]
            );
        }
    }
}
