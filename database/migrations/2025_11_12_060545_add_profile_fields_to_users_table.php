<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->string('whatsapp', 15)->nullable()->after('email');
            $t->enum('gender', ['L', 'P'])->nullable()->after('whatsapp');
            $t->string('image')->nullable()->after('gender');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['whatsapp', 'gender', 'image']);
        });
    }
};
