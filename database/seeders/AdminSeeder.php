<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'username' => 'yulis',
                'password' => Hash::make('yulis'),
                'email' => 'yulis@gmail.com',
                'name' => 'Yulistiani',
                'gender' => 'P',
                'fakultas' => 'FKOM',
                'prodi' => null,
                'whatsapp' => '6287729007318',
                'whatsapp_verified_at' => now(),
                'jabatan' => 'Sekprodi FKOM',
            ],
            [
                'username' => 'wulan',
                'password' => Hash::make('wulan'),
                'email' => 'wulan@gmail.com',
                'name' => 'Wulandari',
                'gender' => 'P',
                'fakultas' => 'FKOM',
                'prodi' => null,
                'whatsapp' => '6287729007318',
                'whatsapp_verified_at' => now(),
                'jabatan' => 'Sekprodi FKOM',
            ],
            [
                'username' => 'yogi',
                'password' => Hash::make('yogi'),
                'email' => 'yogi@gmail.com',
                'name' => 'Yogi',
                'gender' => 'L',
                'fakultas' => 'FTEK',
                'prodi' => null,
                'whatsapp' => '6287729007318',
                'whatsapp_verified_at' => now(),
                'jabatan' => 'Sekprodi FTEK',
            ],
        ];

        foreach ($admins as $a) {
            Admin::firstOrCreate(
                ['username' => $a['username']],  // Cegah duplikasi jika seeder dijalankan berulang
                $a
            );
        }
    }
}
