<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewa_id')->constrained('penyewa');
            $table->foreignId('kamar_id')->constrained('kamar');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->date('tanggal_bayar');
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'e-wallet'])->default('cash');
            $table->enum('status', ['lunas', 'pending', 'gagal'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};