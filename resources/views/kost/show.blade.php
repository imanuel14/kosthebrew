@extends('layouts.frontend')

@section('title', $kost->name . ' - Detail Kost')

@push('styles')
{{-- Load Bootstrap CDN di paling atas styles --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(rgba(11, 12, 16, 0.8), rgba(11, 12, 16, 0.8)), 
                    url("{{ asset('assets/img/he-brew.png') }}"); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        min-height: 100vh;
        color: #ffffff;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(15px) saturate(150%);
        -webkit-backdrop-filter: blur(15px) saturate(150%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    }

    .glass-card h1, .glass-card h2, .glass-card h3, .glass-card h4, .glass-card h5, 
    .glass-card p, .glass-card span, .glass-card div, .glass-card i {
        color: #ffffff !important;
    }

    .text-muted-custom {
        color: rgba(255, 255, 255, 0.6) !important;
    }

    /* ========================================================
       GRID GALERI MURNI HORIZONTAL (FIXED LURUS KE SAMPING)
       ======================================================== */
    .gallery-grid-wrapper {
        width: 100%;
        margin-bottom: 25px;
        display: block;
    }

    .gallery-grid-container {
        display: grid !important;
        grid-template-columns: 2fr 1fr !important; /* Membagi kolom horizontal secara mutlak */
        grid-template-rows: repeat(2, 210px) !important; /* Total tinggi panel 420px */
        gap: 12px !important;
        width: 100% !important;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }

    /* Sisi Kiri (Gambar Utama) */
    .grid-main-item {
        grid-column: 1 / 2 !important;
        grid-row: 1 / 3 !important;
        width: 100% !important;
        height: 100% !important;
        overflow: hidden;
        cursor: pointer;
    }

    .grid-main-item img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        display: block !important;
        transition: transform 0.3s ease;
    }

    /* Sisi Kanan (Sub Gambar) */
    .grid-sub-container-right {
        grid-column: 2 / 3 !important;
        grid-row: 1 / 3 !important;
        display: flex !important;
        flex-direction: column !important; /* Menyusun 2 gambar kecil secara vertikal khusus di kolom kanan */
        gap: 12px !important;
        height: 100% !important;
    }

    .grid-sub-item {
        width: 100% !important;
        height: calc(50% - 6px) !important; /* Membagi dua tinggi grid kanan dengan potongan gap */
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }

    .grid-sub-item img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        display: block !important;
        transition: transform 0.3s ease;
    }

    .grid-main-item:hover img, .grid-sub-item:hover img {
        transform: scale(1.02);
    }

    /* Tombol Lihat Semua Foto */
    .btn-see-all-photos {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.95) !important;
        color: #111111 !important;
        border: none !important;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 10;
        transition: all 0.2s;
    }

    .btn-see-all-photos:hover {
        background: #ffffff !important;
        transform: scale(1.05);
    }

    /* Responsive Mobile Layout */
    @media (max-width: 768px) {
        .gallery-grid-container {
            grid-template-columns: 1fr !important;
            grid-template-rows: 260px !important;
        }
        .grid-sub-container-right {
            display: none !important; /* Sembunyikan panel kanan di HP agar fokus gambar utama */
        }
        .grid-main-item {
            grid-row: 1 / 2 !important;
        }
    }

    .facility-icon {
        width: 45px; height: 45px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: #3d8bfd !important;
        font-size: 1.2rem;
    }

    .sticky-booking { position: sticky; top: 100px; }
    
    .btn-booking {
        background: linear-gradient(135deg, #0d6efd, #0043a8);
        border: none;
        transition: 0.3s;
    }
    .btn-booking:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 100px; padding-bottom: 50px;">
    
    {{-- Tombol Kembali --}}
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ url()->previous() }}" class="btn btn-light glass-card px-4 border-0 text-white">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    {{-- GRID FOTO HORIZONTAL --}}
    <div class="row">
        <div class="col-12">
            <div class="gallery-grid-wrapper">
                <div class="gallery-grid-container">
                    @php
                        $hasImage = !empty($kost->image);
                        $galleryImages = $kost->images ? $kost->images->take(2) : collect();
                        $totalPhotos = ($hasImage ? 1 : 0) + ($kost->images ? $kost->images->count() : 0);
                    @endphp

                    {{-- SISI KIRI: Gambar Utama (Index slide ke-0) --}}
                    <div class="grid-main-item btn-trigger-carousel" data-slide-to="0" data-bs-toggle="modal" data-bs-target="#photoModal">
                        @if($hasImage)
                            <img src="{{ Storage::url($kost->image) }}" alt="Foto Utama {{ $kost->name }}">
                        @else
                            <img src="{{ Storage::url('defaults/no-image.jpg') }}" alt="Belum Ada Foto">
                        @endif
                    </div>

                    {{-- SISI KANAN: Kontainer Pendukung Gambar Kecil --}}
                    <div class="grid-sub-container-right">
                        {{-- Gambar Kecil Atas (Index slide ke-1 jika gambar utama ada) --}}
                        <div class="grid-sub-item btn-trigger-carousel" data-slide-to="{{ $hasImage ? 1 : 0 }}" data-bs-toggle="modal" data-bs-target="#photoModal">
                            @if($galleryImages->has(0))
                                <img src="{{ Storage::url($galleryImages[0]->image_path) }}" alt="Galeri 1">
                            @else
                                <img src="{{ Storage::url('defaults/no-image.jpg') }}" alt="Belum Ada Foto">
                            @endif
                        </div>

                        {{-- Gambar Kecil Bawah (Index slide ke-2 jika gambar utama ada) --}}
                        <div class="grid-sub-item btn-trigger-carousel" data-slide-to="{{ $hasImage ? 2 : 1 }}" data-bs-toggle="modal" data-bs-target="#photoModal">
                            @if($galleryImages->has(1))
                                <img src="{{ Storage::url($galleryImages[1]->image_path) }}" alt="Galeri 2">
                            @else
                                <img src="{{ Storage::url('defaults/no-image.jpg') }}" alt="Belum Ada Foto">
                            @endif

                            {{-- Tombol Lihat Semua Foto --}}
                            @if($totalPhotos > 1)
                                <button class="btn-see-all-photos btn-trigger-carousel" data-slide-to="0" data-bs-toggle="modal" data-bs-target="#photoModal">
                                    Lihat semua foto
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS UTAMA UNTUK DETAIL INFORMASI DAN PANEL BOOKING --}}
    <div class="row g-4">
        {{-- Sisi Kiri: Detail Deskripsi --}}
        <div class="col-lg-8">
            <div class="card glass-card border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-primary px-3 py-2 rounded-pill">
                                    {{ $kost->category == 'homestay' ? 'Home Stay' : 'Kamar ' . strtoupper($kost->category) }}
                                </span>
                                @if($kost->room_available > 0)
                                    <span class="badge bg-success text-white px-3 py-2 rounded-pill">Tersedia</span>
                                @endif
                            </div>
                            <h1 class="h2 fw-bold mb-1">{{ $kost->name }}</h1>
                            <p class="text-muted-custom">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $kost->address }}, {{ $kost->city }}
                            </p>
                        </div>
                        <div class="text-end">
                            <div class="bg-warning bg-opacity-25 px-3 py-2 rounded-3">
                                <i class="fas fa-star text-warning"></i>
                                <span class="fw-bold ms-1">{{ number_format($kost->average_rating ?? 5.0, 1) }}</span>
                                <div class="small text-muted-custom">{{ $kost->reviews ? $kost->reviews->count() : 0 }} ulasan</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">
                    
                    <h5 class="fw-bold mb-3">Deskripsi</h5>
                    <p class="text-muted-custom lh-lg">{{ $kost->description }}</p>

                    <h5 class="fw-bold mb-3 mt-4">Fasilitas Kamar</h5>
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="d-flex align-items-center p-2 border border-secondary rounded-3 bg-white bg-opacity-10">
                                <div class="facility-icon me-3">
                                    <i class="fas {{ $kost->category == 'ac' ? 'fa-snowflake' : 'fa-wind' }}"></i>
                                </div>
                                <span class="fw-medium small">{{ $kost->category == 'ac' ? 'Full AC' : 'Kipas Angin' }}</span>
                            </div>
                        </div>
                        @if($kost->facilities)
                            @foreach($kost->facilities as $facility)
                                <div class="col-6 col-md-4">
                                    <div class="d-flex align-items-center p-2 border border-secondary rounded-3 bg-white bg-opacity-10">
                                        <div class="facility-icon me-3">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <span class="fw-medium small">{{ $facility->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Panel Booking Sticky --}}
        <div class="col-lg-4">
            <div class="card glass-card border-0 sticky-booking shadow-sm">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <span class="text-muted-custom small">Harga Mulai Dari</span>
                        <div class="d-flex align-items-baseline gap-1">
                            <h2 class="fw-bold text-info mb-0">Rp {{ number_format($kost->price_monthly, 0, ',', '.') }}</h2>
                            <span class="text-muted-custom">/bulan</span>
                        </div>
                    </div>

                    <div class="alert {{ $kost->room_available > 0 ? 'alert-success bg-success bg-opacity-20 text-white' : 'alert-danger bg-danger bg-opacity-20 text-white' }} border-0 py-2">
                        <i class="fas fa-door-open me-2"></i>
                        <strong>{{ $kost->room_available }} Kamar</strong> Tersedia
                    </div>

                    <div class="d-grid gap-3 mt-4">
                        @if($kost->room_available > 0 && $kost->kamar && $kost->kamar->count() > 0)
                            <a href="{{ route('payment.create', ['kamar_id' => $kost->kamar->first()->id]) }}" 
                               class="btn btn-primary btn-booking btn-lg py-3 fw-bold shadow-sm">
                                Booking Sekarang
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg py-3 fw-bold" disabled>Kamar Penuh</button>
                        @endif

                        {{-- Link Whatsapp diselaraskan dengan contact_phone --}}
                        <a href="https://wa.me/{{ $kost->contact_phone }}?text=Halo,%20saya%20tertarik%20dengan%20{{ urlencode($kost->name) }}" 
                           target="_blank" class="btn btn-outline-success py-3 fw-bold text-white">
                            <i class="fab fa-whatsapp me-2"></i>Tanya Pemilik
                        </a>
                    </div>
                    
                    <div class="mt-4 pt-2 border-top border-secondary">
                        <div class="d-flex align-items-center text-muted-custom small">
                            <i class="fas fa-shield-alt text-success fs-5 me-2"></i>
                            <span>Pembayaran aman melalui sistem terverifikasi kami.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL POPUP SLIDER GALERI FULL --}}
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="photoModalLabel">Galeri Foto {{ $kost->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-close="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-black p-0">
                <div id="modalCarousel" class="carousel slide" data-bs-interval="false">
                    <div class="carousel-inner">
                        @php $modalActive = false; @endphp
                        @if($hasImage)
                            <div class="carousel-item active">
                                <img src="{{ Storage::url($kost->image) }}" class="d-block w-100" style="max-height: 75vh; object-fit: contain;" alt="Foto Utama">
                            </div>
                            @php $modalActive = true; @endphp
                        @endif
                        
                        @if($kost->images)
                            @foreach($kost->images as $index => $img)
                                <div class="carousel-item {{ (!$modalActive && $index === 0) ? 'active' : '' }}">
                                    <img src="{{ Storage::url($img->image_path) }}" class="d-block w-100" style="max-height: 75vh; object-fit: contain;" alt="Galeri Tambahan">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Load Bootstrap JS bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Daftarkan event click untuk semua element pemicu carousel
        const triggers = document.querySelectorAll('.btn-trigger-carousel');
        const carouselEl = document.getElementById('modalCarousel');
        
        // Inisialisasi instance Carousel Bootstrap
        const mainCarousel = new bootstrap.Carousel(carouselEl);

        triggers.forEach(trigger => {
            trigger.addEventListener('click', function () {
                // Ambil index slide dari attribute data-slide-to
                const slideTo = parseInt(this.getAttribute('data-slide-to'));
                // Paksa carousel berpindah ke slide target
                mainCarousel.to(slideTo);
            });
        });
    });
</script>
@endpush