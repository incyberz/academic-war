<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            // tambahkan field role setelah username
            $t->string('role', 20)
                ->nullable()
                ->after('username');

            // buat foreign key ke tabel role (PK = role)
            $t->foreign('role')
                ->references('role')->on('role')
                ->nullOnDelete(); // jika role dihapus → set null
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropForeign(['role']);
            $t->dropColumn('role');
        });
    }
};
