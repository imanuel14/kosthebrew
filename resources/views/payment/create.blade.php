@extends('layouts.frontend')

@section('title', 'Pembayaran - Kost HeBrew')

@section('content')
<div class="container py-5 mt-5"> <!-- Tambahkan mt-5 di sini -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 d-flex align-items-center">
                    <a href="{{ url()->previous() }}" class="text-white me-3"><i class="fas fa-arrow-left"></i></a>
                    <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i> Pembayaran Booking</h4>
                </div>
                
                <div class="card-body p-4">
                    <!-- Info Kamar/Kost -->
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        <h5 class="alert-heading fw-bold"><i class="fas fa-home me-2"></i> Detail Kamar</h5>
                        <hr>
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <p class="mb-1"><strong>Kost:</strong> {{ $kamar ? $kamar->kost->name : $kost->name }}</p>
                                @if($kamar)
                                    <p class="mb-1"><strong>Nomor Kamar:</strong> <span class="badge bg-primary">{{ $kamar->nomor_kamar }}</span></p>
                                    <p class="mb-0"><strong>Tipe:</strong> {{ ucfirst($kamar->tipe_kamar) }}</p>
                                @endif
                            </div>
                            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                <p class="text-muted small mb-0">Harga per Bulan</p>
                                <h3 class="fw-bold text-primary mb-0">Rp {{ number_format($kamar ? $kamar->harga : $kost->price_monthly, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pembayaran -->
                    <form action="{{ route('payment.store') }}" method="POST" id="paymentForm">
                        @csrf
                        <input type="hidden" name="kamar_id" value="{{ $kamar->id ?? '' }}">
                        <input type="hidden" name="kost_id" value="{{ $kost->id ?? '' }}">

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block mb-3">Pilih Bank Transfer</label>
                            <div class="row g-3">
                                <!-- Bank BCA -->
                                <div class="col-md-4">
                                    <input type="radio" name="payment_method" id="bca" value="bca" class="btn-check" required>
                                    <label class="btn btn-outline-primary w-100 p-3 rounded-4 h-100 d-flex flex-column align-items-center justify-content-center payment-option" for="bca">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" height="20" class="mb-2">
                                        <span class="small fw-bold text-dark">Transfer BCA</span>
                                    </label>
                                </div>

                                <!-- Bank Mandiri -->
                                <div class="col-md-4">
                                    <input type="radio" name="payment_method" id="mandiri" value="mandiri" class="btn-check">
                                    <label class="btn btn-outline-primary w-100 p-3 rounded-4 h-100 d-flex flex-column align-items-center justify-content-center payment-option" for="mandiri">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" height="20" class="mb-2">
                                        <span class="small fw-bold text-dark">Transfer Mandiri</span>
                                    </label>
                                </div>

                                <!-- Bank BRI -->
                                <div class="col-md-4">
                                    <input type="radio" name="payment_method" id="bri" value="bri" class="btn-check">
                                    <label class="btn btn-outline-primary w-100 p-3 rounded-4 h-100 d-flex flex-column align-items-center justify-content-center payment-option" for="bri">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2e/BRI_Logo.svg" alt="BRI" height="20" class="mb-2">
                                        <span class="small fw-bold text-dark">Transfer BRI</span>
                                    </label>
                                </div>
                            </div>
                            @error('payment_method')
                                <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ringkasan Pembayaran -->
                        <div class="card bg-light border-0 rounded-4 mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-3 text-dark text-uppercase small" style="letter-spacing: 1px;">Ringkasan Pembayaran</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Harga Kamar</span>
                                    <span class="fw-medium text-dark">Rp {{ number_format($kamar ? $kamar->harga : $kost->price_monthly, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Biaya Admin</span>
                                    <span class="text-success">Gratis</span>
                                </div>
                                <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                                    <span class="fw-bold h5 mb-0">Total</span>
                                    <span class="fw-bold h4 mb-0 text-primary">Rp {{ number_format($kamar ? $kamar->harga : $kost->price_monthly, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-3 rounded-3 fw-bold" id="payButton" disabled>
                                <i class="fas fa-lock me-2"></i> Bayar Sekarang
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-link text-muted">Batal dan Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .payment-option {
        border: 2px solid #eee;
        transition: all 0.2s ease-in-out;
    }
    .payment-option:hover {
        background-color: #f8fbff;
        border-color: #0d6efd;
    }
    .btn-check:checked + .payment-option {
        border-color: #0d6efd;
        background-color: #eef6ff;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const payButton = document.getElementById('payButton');

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                payButton.disabled = false;
                payButton.innerHTML = `<i class="fas fa-shield-alt me-2"></i> Bayar dengan Transfer ${this.value.toUpperCase()}`;
            }
        });
    });
});
</script>
@endpush