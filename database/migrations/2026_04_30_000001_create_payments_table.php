<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewa_id')->constrained('penyewa')->onDelete('cascade');
            $table->foreignId('kamar_id')->constrained('kamar')->onDelete('cascade');
            $table->string('order_id')->unique(); // ID pesanan unik untuk payment
            $table->decimal('amount', 15, 2); // Jumlah pembayaran
            $table->string('metode_pembayaran')->nullable(); // transfer, e-wallet, dll
            $table->string('provider')->nullable(); // midtrans, xendit, dll
            $table->string('status')->default('pending'); // pending, processing, success, failed, expired
            $table->string('snap_token')->nullable(); // Token dari payment gateway
            $table->string('transaction_id')->nullable(); // ID transaksi dari gateway
            $table->text('metadata')->nullable(); // Data tambahan dalam format JSON
            $table->timestamp('paid_at')->nullable(); // Waktu pembayaran berhasil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};