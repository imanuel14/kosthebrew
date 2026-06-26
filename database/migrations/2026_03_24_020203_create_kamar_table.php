<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_id')->constrained('kost')->onDelete('cascade');
            $table->string('nomor_kamar');
            $table->enum('tipe_kamar', ['standar', 'vip', 'eksekutif'])->default('standar');
            $table->decimal('harga', 12, 2);
            $table->text('fasilitas')->nullable();
            $table->string('luas_kamar', 50)->nullable();
            $table->enum('status', ['tersedia', 'terisi', 'perbaikan'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};