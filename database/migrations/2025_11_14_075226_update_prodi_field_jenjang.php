<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prodi', function (Blueprint $table) {
            // 1. Tambah kolom sementara
            $table->char('jenjang_baru', 2)->nullable()->after('jenjang');
        });

        // 2. Copy data jenjang lama → jenjang_baru
        DB::table('prodi')->update([
            'jenjang_baru' => DB::raw('jenjang')
        ]);

        Schema::table('prodi', function (Blueprint $table) {
            // 3. Hapus kolom lama
            $table->dropColumn('jenjang');

            // 4. Rename jenjang_baru → jenjang
            $table->renameColumn('jenjang_baru', 'jenjang');
        });

        Schema::table('prodi', function (Blueprint $table) {
            // 5. Tambah Foreign Key
            $table
                ->foreign('jenjang')
                ->references('jenjang')
                ->on('jenjang')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('prodi', function (Blueprint $table) {
            $table->dropForeign(['jenjang']);

            // Kembalikan kolom lama
            $table->string('jenjang')->after('kode');
        });
    }
};
