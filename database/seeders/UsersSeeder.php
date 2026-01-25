<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
  public function run(): void
  {
    // Pastikan user 'insho' ada (super admin)
    $insho = User::firstOrCreate(
      ['username' => 'insho'],
      [
        'name' => 'Super Admin',
        'email' => 'insho@gmail.com',
        'role_id' => config('roles.super_admin')['id'], // super admin
        'whatsapp' => '6287729007318',
        'whatsapp_verified_at' => now(),
        'password' => Hash::make('insho'),
      ]
    );
  }
}
