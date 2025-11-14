<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->string('username', 20)->unique()->after('name')->nullable();
            $t->timestamp('whatsapp_verified_at')->nullable()->after('whatsapp');
            $t->enum('status', [1, -1])->default(1)->after('whatsapp_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['username', 'whatsapp_verified_at', 'status']);
        });
    }
};
