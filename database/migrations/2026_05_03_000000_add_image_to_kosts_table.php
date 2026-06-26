<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom image sudah ada
        if (!Schema::hasColumn('kost', 'image')) {
            Schema::table('kost', function (Blueprint $table) {
                $table->string('image')->nullable()->after('price_yearly');
            });
        }
    }

    public function down(): void
    {
        Schema::table('kost', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
