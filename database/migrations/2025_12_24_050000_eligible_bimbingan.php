<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil Super Admin (role_id = 1)
        |--------------------------------------------------------------------------
        */
        $superAdmin = User::where('role_id', 1)->first();

        if (! $superAdmin) {
            throw new Exception('Super Admin (role_id = 1) tidak ditemukan.');
        }

        $super_admin_id = $superAdmin->id;
        $tahun_ajar_id = 20251;

        /*
        |--------------------------------------------------------------------------
        | Create table eligible_bimbingan
        |--------------------------------------------------------------------------
        */
        Schema::create('eligible_bimbingan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tahun_ajar_id');
            $table->unsignedBigInteger('jenis_bimbingan_id');
            $table->unsignedBigInteger('mhs_id');
            $table->unsignedBigInteger('assign_by');

            $table->timestamps();

            $table->unique(
                ['tahun_ajar_id', 'jenis_bimbingan_id', 'mhs_id'],
                'eligible_unique'
            );

            $table->foreign('tahun_ajar_id')->references('id')->on('tahun_ajar');
            $table->foreign('jenis_bimbingan_id')->references('id')->on('jenis_bimbingan');
            $table->foreign('mhs_id')->references('id')->on('mhs');
            $table->foreign('assign_by')->references('id')->on('users');
        });

        /*
        |--------------------------------------------------------------------------
        | Dummy Maba
        |--------------------------------------------------------------------------
        */
        $maba = [
            'abdul',
            'budi',
            'charlie',
            'deni',
            'erwin',
            'fajar',
            'gilang',
            'heri',
            'indah',
            'jajang'
        ];

        foreach ($maba as $nama) {

            // users
            $userId = DB::table('users')->insertGetId([
                'name' => ucfirst($nama) . ' Dummy',
                'username' => $nama,
                'role' => 6, // mhs
                'email' => $nama . '@gmail.com',
                'password' => Hash::make($nama),
                'role_id' => 2, // asumsi: mahasiswa
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // mhs
            $mhsId = DB::table('mhs')->insertGetId([
                'user_id' => $userId,
                'nama' => ucfirst($nama) . ' Dummy',
                'angkatan' => 2024,
                'nim' => '24' . rand(1000000, 9999999),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // eligible_bimbingan
            DB::table('eligible_bimbingan')->insert([
                'tahun_ajar_id' => $tahun_ajar_id,
                'jenis_bimbingan_id' => 1,
                'mhs_id' => $mhsId,
                'assign_by' => $super_admin_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('eligible_bimbingan');

        DB::table('mhs')->where('angkatan', 2024)->delete();

        DB::table('users')->whereIn('username', [
            'abdul',
            'budi',
            'charlie',
            'deni',
            'erwin',
            'fajar',
            'gilang',
            'heri',
            'indah',
            'jajang'
        ])->delete();
    }
};
