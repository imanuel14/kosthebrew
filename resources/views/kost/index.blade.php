@extends('layouts.frontend')

@section('title', 'Cari Kost - Sistem Informasi Kost')

@section('content')
{{-- HERO SECTION --}}
<section class="hero-kamar">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-flex justify-content-center mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white opacity-75 text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Cari Kost</li>
            </ol>
        </nav>
        
        <h1 class="display-5 fw-bold text-white mb-2">Cari Kost</h1>
        <p class="text-light opacity-75">Temukan hunian terbaik di KostHeBrew</p>
    </div>
</section>

{{-- MAIN CONTENT --}}
<div class="bg-dark-deep min-vh-100 py-5">
    <div class="container">
        <!-- Header Info & Sorting -->
        <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <h4 class="text-white fw-bold mb-0">Daftar Kost</h4>
                <span class="text-light opacity-50 small">{{ $kosts->total() }} properti tersedia</span>
            </div>
            
           <div class="d-flex align-items-center bg-dark-card px-3 py-2 rounded-3 border border-secondary border-opacity-25">
    <!-- Label diubah menjadi Tipe Kamar -->
    <label class="me-3 text-light small opacity-75 mb-0">
        <i class="bi bi-door-open me-2"></i>Tipe Kamar:
    </label>
    
    <form action="{{ route('kosts.index') }}" method="GET" id="filterTypeForm">
        {{-- 
            Catatan: Pastikan di Controller Anda menangkap request('type') 
            untuk memfilter query database berdasarkan kategori ini. 
        --}}
        <select name="type" onchange="this.form.submit()" class="form-select form-select-sm bg-transparent text-white border-0 shadow-none cursor-pointer" style="width: auto;">
            <option value="" class="bg-dark" {{ request('type') == '' ? 'selected' : '' }}>Semua Tipe</option>
            <option value="ac" class="bg-dark" {{ request('type') == 'ac' ? 'selected' : '' }}>Kamar AC</option>
            <option value="kipas" class="bg-dark" {{ request('type') == 'kipas' ? 'selected' : '' }}>Kamar Kipas</option>
            <option value="homestay" class="bg-dark" {{ request('type') == 'homestay' ? 'selected' : '' }}>Home Stay</option>
        </select>
    </form>
</div>
        </div>

        <!-- Kost Grid (3 Kolom) -->
        @if($kosts->count() > 0)
            <div class="row g-4">
                @foreach($kosts as $kost)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <x-kost-card :kost="$kost" />
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-5 d-flex justify-content-center">
                {{ $kosts->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="bg-dark-card d-inline-block p-5 rounded-circle mb-4 border border-secondary border-opacity-25">
                    <i class="bi bi-house-x display-1 text-secondary opacity-25"></i>
                </div>
                <h4 class="text-white fw-bold">Belum ada kost tersedia</h4>
                <p class="text-light opacity-50">Silakan kembali lagi nanti untuk melihat update terbaru.</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* Global Background */
    .bg-dark-deep { background-color: #0b0c10; }
    .bg-dark-card { background-color: #1f2833; }
    
    /* Hero Style */
    .hero-kamar {
        padding: 160px 0 80px 0;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)), 
                    url("{{ asset('assets/img/he-brew.png') }}");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    /* Custom Grid & Card Fix */
    .cursor-pointer { cursor: pointer; }
    
    /* Perbaikan Pagination ke warna gelap agar konsisten */
    .pagination .page-link { 
        background-color: #1f2833; 
        border-color: rgba(69, 162, 158, 0.2); 
        color: #45a29e; 
        padding: 10px 18px;
    }
    .pagination .page-item.active .page-link { 
        background-color: #45a29e; 
        border-color: #45a29e; 
        color: white; 
    }
    .pagination .page-item.disabled .page-link {
        background-color: #161b22;
        border-color: rgba(69, 162, 158, 0.1);
        color: #444;
    }

    /* Navbar Transparent Fix */
    .navbar { position: absolute; width: 100%; z-index: 1000; background: transparent !important; }
    .navbar .nav-link { color: white !important; }
</style>
@endsection