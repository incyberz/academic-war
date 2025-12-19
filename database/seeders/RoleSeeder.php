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
            ['role' => 'super_admin', 'nama' => 'Super Admin', 'deskripsi' => 'Akses penuh ke seluruh sistem'],
            ['role' => 'admin',       'nama' => 'Admin', 'deskripsi' => 'Admin sistem dan operasional umum'],
            ['role' => 'akademik',    'nama' => 'Akademik', 'deskripsi' => 'Pengelola data akademik'],
            ['role' => 'kaprodi',     'nama' => 'Kaprodi', 'deskripsi' => 'Ketua Program Studi'],
            ['role' => 'dosen',       'nama' => 'Dosen', 'deskripsi' => 'Tenaga pendidik dan pembimbing'],
            ['role' => 'mahasiswa',   'nama' => 'Mahasiswa', 'deskripsi' => 'Peserta pendidikan'],
        ];

        foreach ($roles as $role) {
            DB::table('role')->updateOrInsert(
                ['role' => $role['role']], // gunakan role sebagai key unik
                [
                    'nama' => $role['nama'],
                    'deskripsi' => $role['deskripsi'],
                ]
            );
        }
    }
}
