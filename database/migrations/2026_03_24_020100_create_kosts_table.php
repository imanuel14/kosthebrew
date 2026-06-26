<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kost', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Sesuaikan dengan Seeder
            $table->text('description')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('district');
            $table->decimal('price_monthly', 12, 2);
            $table->decimal('price_yearly', 12, 2)->nullable();
            $table->string('image')->nullable(); // Tambahkan kolom image
            $table->integer('room_total')->default(0);
            $table->integer('room_available')->default(0);
            $table->enum('category', ['ac', 'kipas', 'homestay']);
            $table->boolean('is_featured')->default(false);
            $table->string('contact_phone');
            $table->string('contact_whatsapp')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade'); // Gunakan owner_id
            $table->boolean('is_active')->default(true);
            $table->json('nearby_places')->nullable();
            $table->json('bathroom_facilities')->nullable();
            $table->json('general_facilities')->nullable();
            $table->json('parking_facilities')->nullable();
            $table->json('room_rules')->nullable();
            $table->json('special_rules')->nullable();
            $table->string('rental_period')->nullable();
            $table->boolean('is_occupied')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kost');
    }
};