@extends('layouts.app')

@section('title', 'Checkout Pembayaran - Kost HeBrew')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <!-- Kolom Kiri: Form Detail Penyewa & Durasi -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-dark fw-bold"><i class="fas fa-wallet text-primary me-2"></i>Form Formulir Booking</h4>
                    
                    <form action="{{ route('payment.store') }}" method="POST" id="payment-form">
                        @csrf
                        <!-- Hidden Input untuk membawa ID Kost / Kamar -->
                        <input type="hidden" name="kost_id" value="{{ $kost->id }}">

                        <!-- Informasi Penyewa (Readonly) -->
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small fw-bold">Email</label>
                                <input type="email" class="form-control bg-light" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small fw-bold">Nomor WhatsApp</label>
                                <input type="text" class="form-control bg-light" value="{{ auth()->user()->no_hp ?? '-' }}" readonly>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        <!-- Pilihan Durasi Sewa -->
                        <div class="mb-4">
                            <label for="duration" class="form-label text-dark fw-bold">Durasi Sewa</label>
                            <div class="input-group">
                                <select class="form-select @error('duration') is-invalid @enderror" id="duration" name="duration" required>
                                    <option value="1" data-price="{{ $kost->price_monthly }}" selected>1 Bulan</option>
                                    <option value="3" data-price="{{ $kost->price_monthly }}">3 Bulan</option>
                                    <option value="6" data-price="{{ $kost->price_monthly }}">6 Bulan</option>
                                    <option value="12" data-price="{{ $kost->price_monthly }}">1 Tahun (12 Bulan)</option>
                                </select>
                                <span class="input-group-text bg-light"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label text-dark fw-bold">Tanggal Mulai Nge-kost</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" min="{{ date('Y-m-d') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm" id="pay-button">
                                <i class="fas fa-credit-card me-2"></i>Proses Pembayaran Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Ringkasan Tagihan Kost -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 position-sticky" style="top: 20px;">
                <img src="{{ $kost->image ? asset('storage/' . $kost->image) : asset('images/default-kost.jpg') }}" class="card-img-top object-fit-cover" alt="{{ $kost->name }}" style="height: 180px;">
                <div class="card-body p-4">
                    <span class="badge bg-soft-primary text-primary mb-2 text-uppercase font-monospace" style="font-size: 11px; background-color: #eef2ff;">
                        {{ $kost->category }}
                    </span>
                    <h5 class="fw-bold text-dark mb-1">{{ $kost->name }}</h5>
                    <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $kost->address }}, {{ $kost->city }}</p>
                    
                    <hr class="text-muted">

                    <h6 class="fw-bold text-dark mb-3">Rincian Pembayaran</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Harga Kost / Bulan</span>
                        <span class="fw-semibold text-dark">Rp {{ number_format($kost->price_monthly, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Durasi Sewa</span>
                        <span class="fw-semibold text-dark" id="summary-duration">1 Bulan</span>
                    </div>

                    <hr class="text-muted border-dashed">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-dark fw-bold fs-5">Total Bayar</span>
                        <span class="text-primary fw-bold fs-4" id="total-price">Rp {{ number_format($kost->price_monthly, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Otomatis Menghitung Total Harga Berdasarkan Durasi Sewa -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const durationSelect = document.getElementById('duration');
        const summaryDuration = document.getElementById('summary-duration');
        const totalPriceEl = document.getElementById('total-price');

        durationSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const months = parseInt(selectedOption.value);
            const pricePerMonth = parseFloat(selectedOption.getAttribute('data-price'));
            
            // Hitung Total Matematika
            const total = months * pricePerMonth;

            // Update Tampilan Ringkasan di Sebelah Kanan
            summaryDuration.textContent = months + ' Bulan';
            totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        });
    });
</script>
@endsection