<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = config('roles');

        foreach ($roles as $roleKey => $role) {
            DB::table('role')->updateOrInsert(
                ['id' => $role['id']], // gunakan ID dari config sebagai anchor utama
                [
                    'role_name' => $roleKey,
                    'nama'      => $role['nama'],
                    'deskripsi' => $role['deskripsi'] ?? null,
                    'color'     => $role['color'] ?? null,
                    'bg'        => $role['bg'] ?? null,
                    'gradient'  => $role['gradient'] ?? null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
