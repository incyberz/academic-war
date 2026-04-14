<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BootcampSkillMissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // =========================
            // BOOTCAMP
            // =========================
            $bootcampId = DB::table('bootcamp')->insertGetId([
                'nama' => 'Bootcamp Laravel',
                'deskripsi' => 'Bootcamp intensif Laravel dari basic hingga CRUD',
                'status' => 'aktif',
                'xp_total' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // =========================
            // SKILL 1: Setup Laravel
            // =========================
            $skill1 = DB::table('skill')->insertGetId([
                'bootcamp_id' => $bootcampId,
                'nama' => 'Setup Laravel',
                'deskripsi' => 'Menyiapkan environment Laravel',
                'urutan' => 1,
                'xp' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('mission')->insert([
                [
                    'skill_id' => $skill1,
                    'nama' => 'Install PHP 8.2+',
                    'deskripsi' => 'Pastikan PHP versi 8.2 atau lebih',
                    'tipe' => 'upload',
                    'xp' => 20,
                    'urutan' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'skill_id' => $skill1,
                    'nama' => 'Install Composer',
                    'deskripsi' => 'Install dependency manager PHP',
                    'tipe' => 'upload',
                    'xp' => 20,
                    'urutan' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'skill_id' => $skill1,
                    'nama' => 'Create Project Laravel',
                    'deskripsi' => 'Buat project Laravel baru',
                    'tipe' => 'upload',
                    'xp' => 30,
                    'urutan' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'skill_id' => $skill1,
                    'nama' => 'Jalankan Laravel',
                    'deskripsi' => 'php artisan serve',
                    'tipe' => 'upload',
                    'xp' => 30,
                    'urutan' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            // =========================
            // SKILL 2: Migration Hero
            // =========================
            $skill2 = DB::table('skill')->insertGetId([
                'bootcamp_id' => $bootcampId,
                'nama' => 'Migration Hero',
                'deskripsi' => 'Membuat struktur database',
                'urutan' => 2,
                'xp' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('mission')->insert([
                [
                    'skill_id' => $skill2,
                    'nama' => 'Setup Database .env',
                    'deskripsi' => 'Konfigurasi database',
                    'tipe' => 'upload',
                    'xp' => 30,
                    'urutan' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'skill_id' => $skill2,
                    'nama' => 'Buat Migration',
                    'deskripsi' => 'Membuat file migration',
                    'tipe' => 'upload',
                    'xp' => 40,
                    'urutan' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'skill_id' => $skill2,
                    'nama' => 'Jalankan Migration',
                    'deskripsi' => 'php artisan migrate',
                    'tipe' => 'upload',
                    'xp' => 40,
                    'urutan' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'skill_id' => $skill2,
                    'nama' => 'Cek Database',
                    'deskripsi' => 'Pastikan tabel ada',
                    'tipe' => 'upload',
                    'xp' => 40,
                    'urutan' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            // =========================
            // SKILL 3: Tampil Data
            // =========================
            $skill3 = DB::table('skill')->insertGetId([
                'bootcamp_id' => $bootcampId,
                'nama' => 'Tampil Data',
                'deskripsi' => 'Menampilkan data ke view',
                'urutan' => 3,
                'xp' => 200,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('mission')->insert([
                [
                    'skill_id' => $skill3,
                    'nama' => 'Buat Model',
                    'deskripsi' => 'Model dari tabel',
                    'tipe' => 'upload',
                    'xp' => 50,
                    'urutan' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'skill_id' => $skill3,
                    'nama' => 'Buat Controller',
                    'deskripsi' => 'Controller untuk data',
                    'tipe' => 'upload',
                    'xp' => 50,
                    'urutan' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'skill_id' => $skill3,
                    'nama' => 'Kirim ke View',
                    'deskripsi' => 'Passing data ke blade',
                    'tipe' => 'upload',
                    'xp' => 50,
                    'urutan' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'skill_id' => $skill3,
                    'nama' => 'Tampilkan Data',
                    'deskripsi' => 'Render di blade',
                    'tipe' => 'upload',
                    'xp' => 50,
                    'urutan' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        });
    }
}
