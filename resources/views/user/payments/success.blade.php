@extends('layouts.app')

@section('title', 'Pembayaran Sukses - Kost HeBrew')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <!-- Card Utama Sukses -->
            <div class="card shadow border-0 p-4 rounded-4 mb-4">
                <div class="card-body">
                    <!-- Icon Animasi Centang Hijau -->
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 75px;"></i>
                    </div>
                    
                    <h3 class="fw-bold text-dark mb-2">Pembayaran Berhasil!</h3>
                    <p class="text-secondary mb-4">Terima kasih, transaksi booking kamar Anda telah kami terima dan sukses dikonfirmasi otomatis oleh sistem.</p>
                    
                    <!-- Box Kuitansi Ringkas -->
                    <div class="bg-light p-3 rounded-3 text-start mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">No. Invoice</small>
                            <small class="fw-bold text-dark font-monospace">{{ $transaksi->invoice_number ?? 'INV-'.time() }}</small>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Nama Kost</small>
                            <small class="fw-bold text-dark">{{ $transaksi->kamar->kost->name ?? 'Nama Kost' }}</small>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Tanggal Mulai</small>
                            <small class="fw-bold text-dark">{{ \Carbon\Carbon::parse($transaksi->start_date)->translatedFormat('d F Y') }}</small>
                        </div>
                        <hr class="my-2 border-dashed text-muted">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-dark small">Total Pembayaran</span>
                            <span class="text-success fw-bold fs-5">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Tombol Aksi Navigasi Selanjutnya -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('bookings.my') }}" class="btn btn-primary shadow-sm py-2">
                            <i class="fas fa-list me-2"></i>Lihat Riwayat Sewa Saya
                        </a>
                        <a href="/" class="btn btn-outline-secondary py-2">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>

            <!-- Catatan Tambahan -->
            <p class="text-muted small">
                <i class="fas fa-info-circle me-1"></i> Memiliki pertanyaan atau kendala seputar kamar? <a href="#" class="text-decoration-none">Hubungi Admin / Pemilik Kost</a>.
            </p>
        </div>
    </div>
</div>
@endsection