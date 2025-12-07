<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->updateOrInsert(
            ['role' => 'super_admin'],
            ['nama' => 'Super Admin', 'deskripsi' => 'Akses penuh ke seluruh sistem']
        );

        DB::table('role')->updateOrInsert(
            ['role' => 'admin'],
            ['nama' => 'Admin', 'deskripsi' => 'Admin sistem dan operasional umum']
        );

        DB::table('role')->updateOrInsert(
            ['role' => 'akademik'],
            ['nama' => 'Akademik', 'deskripsi' => 'Pengelola data akademik']
        );

        DB::table('role')->updateOrInsert(
            ['role' => 'kaprodi'],
            ['nama' => 'Kaprodi', 'deskripsi' => 'Ketua Program Studi']
        );

        DB::table('role')->updateOrInsert(
            ['role' => 'dosen'],
            ['nama' => 'Dosen', 'deskripsi' => 'Tenaga pendidik dan pembimbing']
        );

        DB::table('role')->updateOrInsert(
            ['role' => 'mahasiswa'],
            ['nama' => 'Mahasiswa', 'deskripsi' => 'Peserta pendidikan']
        );
    }
}
