<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        $this->call(FakultasSeeder::class);
        $this->call(ProdiSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UsersDosenSeeder::class);
        $this->call(PembimbingSeeder::class);
        $this->call(TahunAjarSeeder::class);
        $this->call(JenisBimbinganSeeder::class);
        $this->call(PesertaBimbinganSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
