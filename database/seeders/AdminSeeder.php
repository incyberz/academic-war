<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Fakultas;
use App\Models\Prodi;

class AdminSeeder extends Seeder
{
    public function run(): void
    {

        // Ambil ID fakultas FKOM
        $fakultasId = Fakultas::where('kode', 'FKOM')->value('id');
        $fakultasId2 = Fakultas::where('kode', 'FTEK')->value('id');

        $admins = [
            [
                'username' => 'yulis',
                'password' => Hash::make('yulis'),
                'email' => 'yulis@gmail.com',
                'name' => 'Yulistiani',
                'gender' => 'P',
                'fakultas_id' => $fakultasId,
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
                'fakultas_id' => $fakultasId,
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
                'fakultas_id' => $fakultasId2,
                'prodi' => null,
                'whatsapp' => '6287729007318',
                'whatsapp_verified_at' => now(),
                'jabatan' => 'Sekprodi FTEK',
            ],
        ];

        foreach ($admins as $a) {
            $prodi_id = null;
            if ($a['prodi']) {
                $prodi_id = Prodi::where('prodi', $a['prodi'])->value('id');
            }

            Admin::firstOrCreate(
                ['username' => $a['username']],  // Cegah duplikasi
                [
                    'password' => $a['password'],
                    'email' => $a['email'],
                    'name' => $a['name'],
                    'gender' => $a['gender'],
                    'fakultas_id' => $a['fakultas_id'],
                    'prodi_id' => $prodi_id,
                    'whatsapp' => $a['whatsapp'],
                    'whatsapp_verified_at' => $a['whatsapp_verified_at'],
                    'jabatan' => $a['jabatan'],
                ]
            );
        }
    }
}
