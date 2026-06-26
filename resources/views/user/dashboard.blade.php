@extends('layouts.app')

@section('title', 'Dashboard - Kost HeBrew')

@section('content')
<style>
    .card-dashboard { transition: transform 0.2s, box-shadow 0.2s; border: none; }
    .card-dashboard:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .bg-gradient-primary { background: linear-gradient(135deg, #4d76fd 0%, #a164ff 100%); }
    .motivation-box { border-left: 5px solid #a164ff; background: #f8f9fa; }
</style>

<div class="container py-5">
    <div class="row align-items-center mb-4">
        <div class="col-lg-8">
            <h2 class="fw-bold text-dark display-6">Halo, {{ $user->name }}! 👋</h2>
            <p class="text-secondary lead fs-6">Selamat datang kembali di pusat kendali Kost HeBrew.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <span class="badge bg-white text-primary border border-primary px-3 py-2 rounded-pill shadow-sm">
                <i class="fas fa-user-circle me-1"></i> {{ strtoupper($user->role) }}
            </span>
        </div>
    </div>

    <div class="card motivation-box shadow-sm border-0 rounded-4 mb-5">
        <div class="card-body p-4 d-flex align-items-center">
            <i class="fas fa-quote-left text-primary fa-2x me-3 opacity-50"></i>
            <div>
                <h6 class="text-primary fw-bold mb-1">Motivasi Hari {{ $hari }}</h6>
                <p class="text-dark mb-0 fst-italic">"{{ $kataMotivasi }}"</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        @php
            $stats = [
                ['title' => 'Status Kamar', 'value' => 'Aktif', 'icon' => 'fa-key', 'color' => 'primary'],
                ['title' => 'Transaksi Selesai', 'value' => 'Lunas', 'icon' => 'fa-wallet', 'color' => 'success'],
                ['title' => 'Tagihan Berikutnya', 'value' => 'Aman', 'icon' => 'fa-history', 'color' => 'warning']
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="col-md-4">
            <div class="card card-dashboard h-100 shadow-sm rounded-4">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle p-3 me-4" style="background-color: rgba(var(--bs-{{ $stat['color'] }}-rgb), 0.1);">
                        <i class="fas {{ $stat['icon'] }} fa-lg text-{{ $stat['color'] }}"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-bold small mb-1">{{ $stat['title'] }}</h6>
                        <h4 class="fw-bold text-dark mb-0">{{ $stat['value'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- <div class="card border-0 rounded-4 shadow-sm overflow-hidden text-white bg-gradient-primary">
        <div class="card-body p-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-2">Ingin Kelola Pembayaran Anda?</h3>
                    <p class="opacity-75 mb-0">Pantau semua histori pembayaran dan status sewa kost Anda secara transparan.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <a href="{{ route('payments.my') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-bold text-primary shadow">
                        <i class="fas fa-receipt me-2"></i> Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection