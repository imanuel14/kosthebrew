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
    Schema::create('testimonials', function (Blueprint $table) {
        $table->id();
        $table->string('user_name'); // Nama pemberi testimoni
        $table->text('message');     // Isi testimoni
        $table->integer('stars')->default(5); // Rating (1-5)
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
