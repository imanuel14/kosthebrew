@extends('layouts.frontend')

@section('title', 'Pembayaran Berhasil - Kost HeBrew')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-check-circle me-2"></i> Pembayaran Berhasil</h4>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h3 class="mb-3">Terima Kasih!</h3>
                    <p class="text-muted">Pembayaran Anda telah berhasil diproses.</p>

                    <!-- Detail Pembayaran -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="text-muted">Order ID</td>
                                    <td class="text-end fw-bold">{{ $payment->order_id }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kost</td>
                                    <td class="text-end">{{ $payment->kamar->kost->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kamar</td>
                                    <td class="text-end">Kamar No. {{ $payment->kamar->nomor_kamar }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Metode Pembayaran</td>
                                    <td class="text-end">{{ ucfirst($payment->metode_pembayaran) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jumlah</td>
                                    <td class="text-end fw-bold text-success h4 mb-0">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tanggal Bayar</td>
                                    <td class="text-end">{{ $payment->paid_at->format('d F Y, H:i') }} WIB</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        Silakan hubungi pemilik kost untuk informasi lebih lanjut mengenai kunci kamar dan tata tertib tinggal.
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('bookings.my') }}" class="btn btn-primary">
                            <i class="fas fa-list me-2"></i> Lihat Booking Saya
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i> Kembali ke Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection