@extends('layouts.frontend')

@section('title', 'Kontak Kami - KostHeBrew')

@section('content')
<style>
    /* 1. Wrapper Utama dengan Background Gambar Penuh */
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
    .hero-contact {
        height: 60vh; /* Sedikit lebih pendek dari Tentang Kami */
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    /* 3. Glassmorphism Card untuk Form & Info */
    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.5rem;
        color: white;
    }

    /* 4. Penyesuaian Input Form agar cocok dengan tema Dark */
    .form-control, .form-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
    }

    .form-control:focus, .form-select:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: #0d6efd;
        color: white;
        box-shadow: none;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    /* 5. Icon Container */
    .icon-box {
        width: 50px; 
        height: 50px;
        background: rgba(13, 110, 253, 0.2);
        color: #0d6efd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text-muted-custom {
        color: rgba(255, 255, 255, 0.7) !important;
    }
</style>

<div class="main-wrapper">
    
    <!-- Hero Section -->
    <header class="hero-contact">
        <div class="container">
            <h1 class="display-2 fw-bold mb-3">Hubungi Kami</h1>
            <p class="lead fs-3 opacity-90 mx-auto" style="max-width: 700px;">
                Punya pertanyaan? Kami siap membantu mencarikan solusi hunian terbaik untuk Anda.
            </p>
        </div>
    </header>

    <!-- Contact Content Section -->
    <section class="pb-5">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Info Column -->
                <div class="col-lg-4">
                    <div class="card glass-card h-100 p-4">
                        <h4 class="fw-bold mb-4">Informasi Kontak</h4>
                        
                        <div class="d-flex mb-4">
                            <div class="icon-box flex-shrink-0">
                                <i class="bi bi-geo-alt-fill fs-5"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-1 text-primary">Alamat</h6>
                                <p class="text-muted-custom mb-0 small">Jl. Perumnas, Condongcatur<br>Sleman, Yogyakarta</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-4">
                            <div class="icon-box flex-shrink-0">
                                <i class="bi bi-telephone-fill fs-5"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-1 text-primary">Telepon</h6>
                                <p class="text-muted-custom mb-0 small">0812-3456-7890<br>0274-123456</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-4">
                            <div class="icon-box flex-shrink-0">
                                <i class="bi bi-envelope-fill fs-5"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-1 text-primary">Email</h6>
                                <p class="text-muted-custom mb-0 small">info@kosthebrew.com<br>support@kosthebrew.com</p>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <div class="icon-box flex-shrink-0">
                                <i class="bi bi-clock-fill fs-5"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-1 text-primary">Jam Operasional</h6>
                                <p class="text-muted-custom mb-0 small">Senin - Sabtu: 09:00 - 17:00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Column -->
                <div class="col-lg-8">
                    <div class="card glass-card p-4">
                        <h4 class="fw-bold mb-4">Kirim Pesan</h4>

                        {{-- Alert Toast Sukses --}}
                        @if(session('success'))
                            <div class="alert alert-success border-0 bg-success bg-opacity-20 text-white alert-dismissible fade show mb-4" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Menampilkan Error Validasi Form --}}
                        @if($errors->any())
                            <div class="alert alert-danger border-0 bg-danger bg-opacity-20 text-white mb-4">
                                <ul class="mb-0 px-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        {{-- Form Mengarah ke Route Pengiriman Pesan --}}
                        <form action="{{ route('contact.send') }}" method="POST">
    @csrf
    <div class="row g-3">
        <!-- Input Nama Lengkap -->
        <div class="col-md-6">
            <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama Anda" required>
        </div>
        
        <!-- Input WhatsApp (Wajib) -->
        <div class="col-md-6">
            <label class="form-label small fw-bold">Nomor WhatsApp <span class="text-danger">*</span></label>
            <input type="tel" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}" placeholder="Contoh: 081234567890" required>
        </div>

        <!-- Input Email (Opsional - Hapus atribut required) -->
        <div class="col-md-12">
            <label class="form-label small fw-bold">Email (Opsional)</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email Anda (jika ada)">
        </div>

        <!-- Input Subjek -->
        <div class="col-md-12">
            <label class="form-label small fw-bold">Subjek <span class="text-danger">*</span></label>
            <select name="subject" class="form-select" required>
                <option value="" class="text-dark">Pilih subjek</option>
                <option value="Pertanyaan Umum" class="text-dark" {{ old('subject') == 'Pertanyaan Umum' ? 'selected' : '' }}>Pertanyaan Umum</option>
                <option value="Kerjasama" class="text-dark" {{ old('subject') == 'Kerjasama' ? 'selected' : '' }}>Kerjasama</option>
                <option value="Keluhan & Saran" class="text-dark" {{ old('subject') == 'Keluhan & Saran' ? 'selected' : '' }}>Keluhan & Saran</option>
            </select>
        </div>

        <!-- Input Pesan -->
        <div class="col-12">
            <label class="form-label small fw-bold">Pesan <span class="text-danger">*</span></label>
            <textarea name="message" class="form-control" rows="5" placeholder="Tulis pesan Anda di sini..." required>{{ old('message') }}</textarea>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill mt-3">
                <i class="bi bi-send me-2"></i>Kirim Pesan Sekarang
            </button>
        </div>
    </div>
</form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5">
        <div class="container">
            <div class="card glass-card overflow-hidden" style="border: none;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1074.482164459716!2d110.42883683381594!3d-7.782941678856981!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5b002e742ea3%3A0xc10539c0bf51d768!2sHe%20Brew%20kost%20%26%20kafe!5e1!3m2!1sid!2sid!4v1774423631500!5m2!1sid!2sid"
                        width="100%" height="450" style="border:0; filter: invert(90%) hue-rotate(180deg) brightness(95%);" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
</div>
@endsection