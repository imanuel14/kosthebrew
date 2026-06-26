@extends('layouts.frontend')

@section('title', 'Beranda - KostHeBrew Testimonials')

@section('content')
<style>
    .hero-full-view {
        /* Gambar memenuhi seluruh area sampai ke bawah tombol */
        padding: 160px 0 100px 0;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.85)), 
                    url("{{ asset('assets/img/he-brew.png') }}");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        color: white;
    }
    .testimonial-card {
        /* Efek Glassmorphism agar tembus pandang ke gambar bangunan */
        background: rgba(255, 255, 255, 0.08) !important;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 15px;
        transition: transform 0.3s ease;
    }
    .testimonial-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.12) !important;
    }
    .quote-icon {
        font-size: 2rem;
        opacity: 0.2;
        color: #fff;
    }
    .star-rating {
        color: #ffc107;
        font-size: 0.9rem;
    }
    .hero-minimal {
    min-height: 70vh; /* Menyesuaikan tinggi banner agar proporsional seperti contoh Retania */
    padding: 120px 0;
    /* Menggunakan gradasi linear dari kiri (gelap) ke kanan (transparan) agar teks di sisi kiri sangat terbaca */
    background: linear-gradient(to right, rgba(0, 0, 0, 0.75) 30%, rgba(0, 0, 0, 0.2) 100%), 
                url("{{ asset('assets/img/he-brew.png') }}");
    background-size: cover;
    background-position: center;
    background-attachment: scroll; /* Menggunakan scroll agar sesuai dengan standar banner web modern */
    display: flex;
    align-items: center; /* Konten vertikal berada di tengah */
}

.hero-title {
    color: #fff;
    font-size: 3rem; /* Memperbesar ukuran font agar terlihat tegas seperti 'Retania Kost' */
    font-weight: 700;
    /* Menggunakan drop shadow halus berwarna gelap untuk teks putih */
    text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); 
}

.hero-subtitle {
    font-size: 1.15rem;
    max-width: 550px; /* Membatasi lebar teks deskripsi di sebelah kiri */
    text-shadow: 0 2px 8px rgba(180, 180, 180, 0.5);
}
</style>

{{-- HEADER SECTION --}}
<section class="hero-minimal">
    <div class="container">
        <div class="row">
            {{-- Menggunakan col-md-8 atau col-lg-6 agar teks mengelompok rapi di sebelah kiri layar --}}
            <div class="col-lg-7 text-start">
                <h1 class="hero-title mb-3">Pengalaman Menginap Terbaik</h1>
                <p class="text-light hero-subtitle opacity-90 mb-0">
                    Dengarkan langsung dari mereka yang telah menemukan kenyamanan dan standar hidup baru bersama KostHeBrew.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- GABUNGAN HERO & TESTIMONIAL SECTION --}}
<section class="hero-full-view">
    <div class="container">
        {{-- AREA TESTIMONI (Menggunakan data dari loop Anda) --}}
        <div class="row g-4">
            @forelse($testimonials as $item)
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card p-4 h-100 d-flex flex-column">
                    <div class="quote-icon mb-2">
                        <i class="fas fa-quote-left text-secondary"></i>
                    </div>
                    
                    <p class="text-light mb-4 flex-grow-1" style="line-height: 1.6; font-style: italic;">
                        "{{ $item->message }}"
                    </p>
                    
                    <div class="d-flex align-items-center mt-auto pt-3 border-top border-secondary">
                        <div class="avatar-circle bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; font-weight: bold;">
                            {{ substr($item->user_name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="mb-0 text-white fw-bold">{{ $item->user_name }}</h6>
                            <div class="star-rating text-warning small">
                                @for($i = 0; $i < ($item->stars ?? 5); $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-light opacity-50">Belum ada testimoni saat ini.</p>
            </div>
            @endforelse
        </div>
        
        {{-- CALL TO ACTION --}}
        <div class="text-center mt-5 pt-4">
            <p class="text-light opacity-75 mb-4">Siap untuk memulai pengalaman Anda sendiri?</p>
            <a href="{{ route('kamar.index') }}" class="btn btn-primary btn-pill px-5 py-3 shadow">
                Jelajahi Semua Kamar <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection