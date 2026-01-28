<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TahunAjar;

class EligibleBimbinganSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * Ambil Super Admin (assign_by)
         */
        $superAdminId = User::where(
            'role_id',
            config('roles.super_admin.id')
        )->value('id');

        if (!$superAdminId) {
            throw new \Exception('Super Admin tidak ditemukan. Jalankan RoleSeeder & UserSeeder terlebih dahulu.');
        }

        /**
         * Ambil Tahun Ajar Aktif
         */
        $tahunAjarId = TahunAjar::where('is_active', true)->value('id') ?? 20251;

        /**
         * Jenis bimbingan yang eligible
         */
        $jenisBimbinganIds = [1, 2, 3];

        /**
         * Ambil semua Mahasiswa dari tabel mhs
         */
        $mahasiswaIds = DB::table('mhs')->pluck('id');

        foreach ($jenisBimbinganIds as $jenisId) {
            foreach ($mahasiswaIds as $mhsId) {
                DB::table('eligible_bimbingan')->updateOrInsert(
                    [
                        'tahun_ajar_id'      => $tahunAjarId,
                        'jenis_bimbingan_id' => $jenisId,
                        'mhs_id'             => $mhsId,
                    ],
                    [
                        'assign_by'  => $superAdminId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
