<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('kost_images', function (Blueprint $table) {
        $table->id();
        // Foreign key ke tabel kosts
        $table->foreignId('kost_id')->constrained('kost')->onDelete('cascade');
        // Kolom untuk menyimpan path/alamat gambar
        $table->string('image_path'); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kost_images');
    }
};
