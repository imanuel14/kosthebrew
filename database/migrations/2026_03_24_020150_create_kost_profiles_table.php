<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('kost_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kost_id')->constrained('kost')->onDelete('cascade');
        $table->text('rules')->nullable(); // Kolom yang tadinya hilang
        $table->time('check_in_time')->default('14:00:00');
        $table->time('check_out_time')->default('12:00:00');
        $table->integer('minimum_stay')->default(1);
        $table->boolean('electricity_included')->default(false);
        $table->boolean('water_included')->default(false);
        $table->boolean('wifi_included')->default(false);
        $table->boolean('parking_available')->default(false);
        $table->boolean('kitchen_available')->default(false);
        $table->boolean('laundry_available')->default(false);
        $table->boolean('cleaning_service')->default(false);
        $table->time('curfew_time')->nullable(); // Jam malam
        $table->boolean('pet_allowed')->default(false);
        $table->boolean('visitor_allowed')->default(true);
        $table->text('additional_info')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('kost_profiles');
    }
};