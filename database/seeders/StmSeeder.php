<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Jenjang;
use App\Models\Kelas;
use App\Models\Kurikulum;
use App\Models\KurMk;
use App\Models\Mk;
use App\Models\Prodi;
use App\Models\Shift;
use App\Models\Stm;
use App\Models\StmItem;
use App\Models\TahunAjar;
use App\Models\UnitPenugasan;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use function Pest\Laravel\session;

class StmSeeder extends Seeder
{
    public function run(): void
    {

        $now = Carbon::now();

        DB::table('unit_penugasan')->upsert(
            [
                [
                    'kode'       => 'FKOM',
                    'nama'       => 'Dekan Fakultas Komputer',
                    'tipe'       => 'fakultas',
                    'parent_id'  => null,
                    'is_active'  => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'kode'       => 'FT',
                    'nama'       => 'Dekan Fakultas Teknik',
                    'tipe'       => 'fakultas',
                    'parent_id'  => null,
                    'is_active'  => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'kode'       => 'FEBS',
                    'nama'       => 'Dekan Fakultas Ekonomi dan Bisnis Syariah',
                    'tipe'       => 'fakultas',
                    'parent_id'  => null,
                    'is_active'  => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ],
            ['kode'], // kolom unique untuk cek konflik
            [
                'nama',
                'tipe',
                'parent_id',
                'is_active',
                'updated_at',
            ] // kolom yang di-update kalau sudah ada
        );


        # ============================================================
        # Seeder STM untuk username insho dan topan
        # ============================================================
        $dosens = Dosen::whereHas('user', function ($q) {
            $q->whereIn('username', ['iin', 'topan']);
        })->get();

        if ($dosens->count() !== 2) {
            throw new Exception('Seeder STM error. Dosen harus tepat 2 orang.');
        }

        // ambil tahun ajar aktif
        $tahunAjar = TahunAjar::where('is_active', true)->firstOrFail();
        $tahun_ajar_id = $tahunAjar->id;

        // unit penugasan FKOM
        $unit_penugasan_id = UnitPenugasan::where('kode', 'FKOM')
            ->value('id');

        // metadata surat
        $m = date('m');
        $Y = date('Y');

        $penandatangan_nama = 'Haekal Pirous, S.T., M.A.B';
        $penandatangan_jabatan = 'Dekan Fakultas Komputer';

        # ============================================================
        # Create STM per dosen
        # ============================================================
        foreach ($dosens as $dosen) {

            $nomor_surat = rand(100, 999) . "/STM/FKOM/$m/$Y";

            Stm::updateOrCreate(
                [
                    'tahun_ajar_id' => $tahun_ajar_id,
                    'dosen_id'      => $dosen->user_id,
                ],
                [
                    'unit_penugasan_id'    => $unit_penugasan_id,
                    'nomor_surat'          => $nomor_surat,
                    'tanggal_surat'        => Carbon::today(),
                    'penandatangan_nama'   => $penandatangan_nama,
                    'penandatangan_jabatan' => $penandatangan_jabatan,
                    'status'               => 'draft',
                ]
            );
        }







        # ============================================================
        # STM ITEM PERLU
        # ============================================================
        # 1. stm_id
        # 2. kur_mk_id: kur + mk
        # 3. kelas_id: jenjang + prodi + rombel + shift + TA
        # ============================================================


        # ============================================================
        # JENJANG
        # ============================================================
        $arr_jenjang = [
            'D3' => [
                'nama' => 'Diploma 3',
                'jumlah_semester' => 6,
            ],
            'S1' => [
                'nama' => 'Sarjana 1',
                'jumlah_semester' => 8,
            ],
        ];

        foreach ($arr_jenjang as $kode => $data) {
            // firstOrCreate agar seeder bisa dijalankan ulang tanpa duplikasi
            Jenjang::firstOrCreate(
                ['kode' => $kode],
                [
                    'nama' => $data['nama'],
                    'jumlah_semester' => $data['jumlah_semester'],
                ]
            );
        }




        # ============================================================
        # KELAS
        # ============================================================
        $tahun = 2025;
        $semester = 4;
        $prodiKode = 'SI';
        $jenjang = Jenjang::where('kode', 'S1')->firstOrFail();
        $rombel = 'A';
        $ta = 20251;
        $shift = Shift::where('kode', 'R')->firstOrFail();
        $prodi = Prodi::where('prodi', $prodiKode)->firstOrFail();
        $shiftKode = $shift->kode;



        $kodeKelas = "S1-$prodiKode-$rombel-$shiftKode-$semester-$ta";

        $kelas = Kelas::firstOrCreate(
            ['kode' => $kodeKelas],
            [
                'label' => "$prodiKode-$shiftKode$rombel",   // contoh label untuk UI
                'tahun_ajar_id' => $tahunAjar->id,
                'prodi_id' => $prodi->id,
                'shift_id' => $shift->id,
                'rombel' => $rombel,
                'semester' => $semester,
                'max_peserta' => 40,
                'min_peserta' => 5,
            ]
        );


        # ============================================================
        # Kurikulum 
        # ============================================================
        $namaProdi = ucwords(strtolower($prodi->nama));
        $namaKurikulum = "Kurikulum $namaProdi $tahun"; // unik
        $kurikulum = Kurikulum::firstOrCreate(
            ['nama' => $namaKurikulum], // kolom yang dicek dulu
            [
                'tahun' => $tahun,
                'prodi_id' => $prodi->id,
                'is_active' => true,
                'keterangan' => "Seeder Kurikulum baru $tahun"
            ]
        );

        # ============================================================
        # MK
        # ============================================================
        $arr_mk = [
            'MK0034' => [
                'singkatan' => 'PWEBM',
                'nama' => 'Pemrograman Web Mobile',
                'sks' => 3,
                'deskripsi' => 'insert by seeder',
            ],
            'MK0056' => [
                'singkatan' => 'SISOP',
                'nama' => 'Sistem Operasi',
                'sks' => 2,
                'deskripsi' => 'insert by seeder',
            ],
        ];

        foreach ($arr_mk as $kode => $data) {
            // firstOrCreate agar tidak duplikasi jika seeder dijalankan ulang
            $mk = Mk::firstOrCreate(
                ['kode' => $kode],
                [
                    'nama' => $data['nama'],
                    'singkatan' => $data['singkatan'],
                    'sks' => $data['sks'],
                    'deskripsi' => $data['deskripsi'],
                    'is_active' => true,
                ]
            );

            $kurMk = KurMk::firstOrCreate(
                [
                    'kurikulum_id' => $kurikulum->id,
                    'mk_id' => $mk->id,
                ],
                [
                    'semester' => $semester,
                ]
            );

            $stm = Stm::firstOrFail();           // ambil STM pertama

            StmItem::firstOrCreate(
                [
                    'stm_id' => $stm->id,
                    'kur_mk_id' => $kurMk->id,
                    'kelas_id' => $kelas->id,
                ],
                [
                    'sks_tugas' => $kurMk->mk->sks, // fallback ke MK.sks
                    'sks_beban' => $kurMk->mk->sks,
                    'sks_honor' => $kurMk->mk->sks,
                ]
            );
        } // end foreach arr_mk
    }
}
