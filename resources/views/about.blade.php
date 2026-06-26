@extends('layouts.frontend')

@section('title', 'Tentang Kami - KostHeBrew')

@section('content')
<style>
    /* 1. Reset Spacing untuk Layout Utama agar bisa Full Width */
    .main-wrapper {
        width: 100%;
        overflow-x: hidden;
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                    url("{{ asset('assets/img/he-brew.png') }}");
        background-size: cover;
        background-position: center;
        background-attachment: fixed; /* Efek Parallax */
        color: white;
    }

    /* 2. Hero Section */
    .hero-about {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    /* 3. Section Styling */
    .section-padding {
        padding: 100px 0;
    }

    /* 4. Glassmorphism Card agar teks terbaca di atas gambar */
    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.5rem;
        padding: 2rem;
        transition: transform 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.15);
    }

    .section-title-custom {
        position: relative;
        padding-bottom: 15px;
        display: inline-block;
        color: white;
    }

    .section-title-custom::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 4px;
        background-color: #0d6efd;
    }

    .feature-box {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 15px;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        color: white;
    }

    .team-img {
        width: 100px;
        height: 100px;
        border: 3px solid #0d6efd;
        padding: 3px;
    }

    /* Style ikon lokasi terdekat */
    .location-icon-wrapper {
        width: 50px;
        height: 50px;
        background: rgba(13, 110, 253, 0.2);
        border: 1px solid rgba(13, 110, 253, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
</style>

<div class="main-wrapper">
    
    <!-- Hero Section -->
    <header class="hero-about">
        <div class="container">
            <h1 class="display-1 fw-bold mb-3">Tentang KostHeBrew</h1>
            <p class="lead fs-3 opacity-90 mx-auto" style="max-width: 800px;">
                Platform pencarian kost terpercaya dan ternyaman di Indonesia.
            </p>
            <div class="mt-5">
                <a href="#misi" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg">Pelajari Misi Kami</a>
            </div>
        </div>
    </header>

    <!-- Misi Kami Section -->
    <section id="misi" class="section-padding">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('assets/img/he-brew.png') }}" class="img-fluid rounded-4 shadow-lg border border-secondary" alt="Gedung KostHeBrew">
                </div>
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4 section-title-custom">Misi Kami</h2>
                    <p class="fs-5 mb-4 opacity-90">
                        KostHeBrew hadir untuk memberikan standar baru dalam mencari tempat tinggal. Kami mengutamakan kenyamanan, keamanan, dan transparansi bagi setiap penyewa melalui sistem terintegrasi.
                    </p>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="bi bi-patch-check-fill text-primary fs-4 me-3"></i> Kost Terverifikasi
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="bi bi-tag-fill text-primary fs-4 me-3"></i> Harga Transparan
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="bi bi-lightning-charge-fill text-primary fs-4 me-3"></i> Proses Cepat
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="feature-box">
                                <i class="bi bi-headset text-primary fs-4 me-3"></i> Support 24/7
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lokasi Terdekat Section -->
    <section class="section-padding border-top border-secondary border-opacity-25">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold section-title-custom text-center">Akses Lokasi & Transportasi Terdekat</h2>
                <p class="fs-5 opacity-75 mt-3">Sangat strategis, dekat dengan fasilitas transportasi, kampus, tempat ibadah, kuliner, dan hiburan</p>
            </div>

            <div class="row g-4">
                @php
                    $locations = [
                        ['title' => 'Pasar Sambilegi', 'distance' => '5 Menit', 'desc' => 'Kemudahan belanja kebutuhan pokok harian.', 'icon' => 'fa-store'],
                        ['title' => 'Transjogja', 'distance' => '3 Menit', 'desc' => 'Akses halte transportasi umum terdekat.', 'icon' => 'fa-bus'],
                        ['title' => 'Bandar Udara Adisutjipto', 'distance' => '3 Menit', 'desc' => 'Akses bandara udara yang sangat dekat.', 'icon' => 'fa-plane'],
                        ['title' => 'Stasiun Maguwo', 'distance' => '12 Menit', 'desc' => 'Akses cepat menuju stasiun kereta api.', 'icon' => 'fa-train'],
                        ['title' => 'Gudeg Yu Djum Pusat Maguwo', 'distance' => '2 Menit', 'desc' => 'Destinasi kuliner legendaris khas Yogyakarta.', 'icon' => 'fa-utensils'],
                        ['title' => 'Alfamart Kalongan Sleman', 'distance' => '3 Menit', 'desc' => 'Belanja kebutuhan minimarket harian.', 'icon' => 'fa-shopping-basket'],
                        ['title' => 'Manna Kampus', 'distance' => '4 Menit Motor', 'desc' => 'Supermarket andalan untuk stok bulanan.', 'icon' => 'fa-shopping-cart'],
                        ['title' => 'Universitas Atma Jaya Yogyakarta', 'distance' => '5 Menit Motor', 'desc' => 'Sangat dekat menuju kawasan kampus UAJY.', 'icon' => 'fa-graduation-cap'],
                        ['title' => 'Institut Teknologi Nasional Yogyakarta (ITNY)', 'distance' => '5 Menit Motor', 'desc' => 'Akses kilat menuju kampus ITNY.', 'icon' => 'fa-university'],
                        ['title' => 'Hermina Hospital Yogya', 'distance' => '6 Menit Motor', 'desc' => 'Fasilitas kesehatan untuk kebutuhan darurat.', 'icon' => 'fa-hospital-user'],
                        ['title' => 'Museum Pusat TNI AU', 'distance' => '4 Menit Motor', 'desc' => 'Destinasi wisata edukasi kedirgantaraan.', 'icon' => 'fa-monument'],
                        ['title' => 'Bakpia Pathok 25 Bandara Jaya', 'distance' => '3 Menit', 'desc' => 'Pusat oleh-oleh khas Jogja terdekat.', 'icon' => 'fa-cookie-bite'],
                        ['title' => 'Mustika Yogyakarta Resort', 'distance' => '1 Menit', 'desc' => 'Akomodasi resort penginapan premium terdekat.', 'icon' => 'fa-hotel'],
                        ['title' => 'University Hotel', 'distance' => '3 Menit', 'desc' => 'Penginapan hotel dan fasilitas pertemuan terdekat.', 'icon' => 'fa-building-hars'],
                        ['title' => 'Masjid Ar-Rahman Nanggulan', 'distance' => '1 Menit', 'desc' => 'Sarana ibadah bagi umat Muslim.', 'icon' => 'fa-mosque'],
                        ['title' => 'GKJ Maguwoharjo', 'distance' => '2 Menit', 'desc' => 'Sarana ibadah bagi umat Kristiani.', 'icon' => 'fa-church'],
                        ['title' => 'Kafe BROOKLYN - Garden & Eatery', 'distance' => '1 Menit', 'desc' => 'Tempat bersantai, makan, dan nugas yang nyaman.', 'icon' => 'fa-coffee'],
                        ['title' => 'Transmart Carrefour Maguwoharjo', 'distance' => '15 Menit', 'desc' => 'Pusat hiburan, bioskop, dan perbelanjaan modern.', 'icon' => 'fa-shopping-bag'],
                    ];
                @endphp

                @foreach($locations as $loc)
                <div class="col-lg-4 col-md-6">
                    <div class="glass-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="location-icon-wrapper me-3">
                                    <i class="fas {{ $loc['icon'] }} text-primary fs-4"></i>
                                </div>
                                <span class="badge bg-primary px-3 py-2 rounded-pill fw-bold">{{ $loc['distance'] }}</span>
                            </div>
                            <h4 class="fw-bold mb-2 fs-5 text-white">{{ $loc['title'] }}</h4>
                            <p class="opacity-75 small mb-0">{{ $loc['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Tim Kami Section -->
    {{-- <section class="section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Tim Kami</h2>
                <div class="mx-auto bg-primary mb-3" style="width: 60px; height: 4px;"></div>
                <p class="fs-5 opacity-75">Orang-orang hebat di balik layanan KostHeBrew</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                @php
                    $teams = [
                        ['name' => 'Dwi Irianto', 'role' => 'Founder & CEO', 'color' => '4f46e5'],
                        ['name' => 'Jane Smith', 'role' => 'Head of Operations', 'color' => 'ec4899'],
                        ['name' => 'Mike Johnson', 'role' => 'Lead Developer', 'color' => '10b981']
                    ];
                @endphp

                @foreach($teams as $member)
                <div class="col-md-4">
                    <div class="glass-card text-center h-100">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($member['name']) }}&size=128&background={{ $member['color'] }}&color=fff" 
                             class="rounded-circle team-img mb-4 shadow-sm" alt="{{ $member['name'] }}">
                        <h4 class="fw-bold mb-1">{{ $member['name'] }}</h4>
                        <p class="text-primary fw-bold mb-3 small uppercase tracking-wider">{{ $member['role'] }}</p>
                        <p class="opacity-75 small">Berdedikasi penuh untuk memastikan pengalaman hunian Anda menjadi yang terbaik.</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section> --}}

</div>
@endsection