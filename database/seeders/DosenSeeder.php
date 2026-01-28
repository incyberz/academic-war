<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DosenSeeder extends Seeder
{
  public function run(): void
  {
    $role_id = config('roles')['dosen']['id'];

    $arr_dosen = [
      // ['gelar_depan', 'nama', 'gelar_belakang']
      ['', 'Ade Iskandar Nasution', 'S.H., M.H.'],
      ['', 'Aditya Kusumapriandana', 'S.Mn., M.A.B'],
      ['', 'Anggit S', 'S.T, M.M, M.Kom'],
      ['', 'Anjas Tryana', 'M.M, M.Kom'],
      ['', 'Armansyah Sarusu', 'S.Sos, M.M'],
      ['', 'Asep Abdul Halim', 'S.Sos.I, M.M'],
      ['', 'Ayi Mi`razul Mu`minin', 'S.Kom., M.M'],
      ['', 'Badriyatul Huda', 'SE, MM'],
      ['', 'Bambang Irawan', 'S.S'],
      ['Dr.', 'Ahmad Nurkamali', 'M.M'],
      ['Dr.', 'Asep Totoh', 'M.M'],
      ['Dr.', 'Marlan', 'M.Eng.Sc'],
      ['Dr.', 'Jajang Suherman', 'M.A.B'],
      ['Dr.', 'Latifah Wulandari', 'S.E., M.M.'],
      ['Dr.', 'Nano Suyatna', 'S.E, M.Kom'],
      ['Dr.', 'Yudhy', 'M.Ag'],
      ['', 'Dwi Atmoko', 'S.T., M.Kom'],
      ['', 'Encep Supriatna', 'S.E, S.Kom, M.M'],
      ['', 'Eva Meidi Kulsum', 'S.Hum., M.Pd'],
      ['', 'Faisal Rakhman', 'S.E., M.M.'],
      ['', 'Haekal Pirous', 'S.T., M.A.B.'],
      ['', 'Hasti Pramesti Kusnara', 'S.E, M.M'],
      ['', 'Ida Rapida', 'Dra., M.M.'],
      // ['', 'Iin', 'M.Kom'],
      ['Ir.', 'Raden Haerudjaman', ''],
      ['', 'Kanda M. Ishak', 'M.Kom'],
      ['', 'Muhamad Nur Rahmat Setia', 'S.E, ME.Sy'],
      ['', 'Muhamad Prakarsa', 'S.T., M.Kom'],
      ['', 'Muhamad Ryzki Wiryawan', 'S.Ip, M.T.'],
      ['', 'Miki Wijana', 'S.T., M.H., M.Kom.'],
      ['', 'Mimin Mintarsih', 'M.Ag'],
      ['', 'Muhamad Fahmi Nugraha', 'M.Kom'],
      ['', 'Muhamad Furqon', 'M.Kom'],
      ['', 'Nova Indrayana Yusman', 'M.Kom'],
      ['', 'Nuraeni', 'S.E., M.E.Sy'],
      ['Prof. Dr.', 'Sugiyanto', 'SE., M.Sc'],
      ['', 'Rahma Sakina', 'M.Pd'],
      ['', 'Revi Nur Ridwan', 'M.Pd'],
      ['', 'Ricky Rohmanto', 'M.Kom'],
      ['', 'Ridwan Zulkifli', 'S.T., M.Kom'],
      ['', 'Riyadh Ahsanul Arifin', 'M.Pd'],
      ['', 'Sofia Dewi', 'S.T., M.Kom'],
      ['', 'Tedi Budiman', 'S.Si., M.Kom'],
      ['', 'Topan Setiawan', 'M.Kom'],
      // ['', 'Topan Trianto', 'S.T, M.Kom'],
      ['', 'Ulya Rahmah', 'M.Agr'],
      ['', 'Utami Aryanti', 'M.Kom'],
      ['', 'Yanyan Suryana', 'M.E'],
      ['', 'Yasir Muharram Fauzi', 'SHI., M.E.Sy'],
      ['', 'Yelly A.M. Salam', 'Dra., M.M.'],
    ];


    $existingUsernames = DB::table('users')->pluck('username')->toArray();

    foreach ($arr_dosen as $dosen) {
      [$gelar_depan, $nama, $gelar_belakang] = $dosen;

      // Buat username dari nama depan (lowercase, tanpa spasi)
      $nama_parts = explode(' ', $nama);
      $username_base = Str::lower($nama_parts[0]);
      $username = $username_base;
      $i = 1;

      // cek duplikat
      while (in_array($username, $existingUsernames)) {
        $username = $username_base . $i;
        $i++;
      }
      $existingUsernames[] = $username;

      $email = $username . '@gmail.com';
      $password = Hash::make($username); // password sama dengan username

      // insert ke tabel users
      $user_id = DB::table('users')->insertGetId([
        'name' => $nama,
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'role_id' => $role_id,
        'created_at' => now(),
        'updated_at' => now(),
      ]);

      // insert ke tabel dosen
      DB::table('dosen')->insert([
        'nama' => $nama,
        'gelar_depan' => $gelar_depan,
        'gelar_belakang' => $gelar_belakang,
        'user_id' => $user_id,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }

    $this->command->info('Seeder Dosen berhasil dijalankan.');
  }
}
