<?php

namespace Database\Seeders;

use App\Models\BabLaporan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(FakultasSeeder::class);
        $this->call(JenjangSeeder::class);
        $this->call(ProdiSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(UsersDosenSeeder::class);
        $this->call(PembimbingSeeder::class);
        $this->call(TahunAjarSeeder::class);
        $this->call(JenisBimbinganSeeder::class);
        $this->call(EligibleBimbinganSeeder::class);
        $this->call(BimbinganSeeder::class);
        $this->call(PesertaBimbinganSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(TahapanBimbinganSeeder::class);
        $this->call(BabLaporanSeeder::class);
        $this->call(SesiBimbinganSeeder::class);
        $this->call(StatusMhsSeeder::class);
        $this->call(ShiftSeeder::class);
        $this->call(JabatanStrukturalSeeder::class);
        $this->call(StmSeeder::class);
        $this->call(MKSeeder::class);
        $this->call(DosenSeeder::class);
    }
}
