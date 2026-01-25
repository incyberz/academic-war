<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
  public function run(): void
  {
    DB::table('shift')->updateOrInsert(
      ['kode' => 'R'],
      [
        'nama' => 'Reguler',
        'jam_awal_kuliah' => '08:00',
        'jam_akhir_kuliah' => '16:00',
        'min_persen_presensi' => 75,
        'min_pembayaran' => 50,
        'keterangan' => 'Kelas reguler (pagi–sore)',
        'created_at' => now(),
        'updated_at' => now(),
      ]
    );

    DB::table('shift')->updateOrInsert(
      ['kode' => 'NR'],
      [
        'nama' => 'Non Reguler',
        'jam_awal_kuliah' => '18:30',
        'jam_akhir_kuliah' => '22:00',
        'min_persen_presensi' => 60,
        'min_pembayaran' => 70,
        'keterangan' => 'Kelas non reguler (malam / karyawan)',
        'created_at' => now(),
        'updated_at' => now(),
      ]
    );
  }
}
