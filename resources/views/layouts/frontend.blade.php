<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KostHeBrew - Temukan Kamar Impian')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Menggunakan Font yang lebih modern */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');

        :root {
            --primary-color: #4e73df;
            --secondary-color: #2e59d9;
            --dark-color: #1a1c23;
            --light-bg: #f8f9fc;
            --text-muted: #6e707e;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #ffffff; /* Mengubah default teks body menjadi putih */
            /* Menggunakan latar belakang gelap dengan gambar global seperti di index */
            background: linear-gradient(rgba(11, 12, 16, 0.85), rgba(11, 12, 16, 0.95)), 
                        url("{{ asset('assets/img/he-brew.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Navbar Premium Transparan agar menyatu dengan background gambar */
        .navbar {
            padding: 1rem 0;
            transition: all 0.3s ease;
            background: rgba(11, 12, 16, 0.6) !important; /* Latar belakang navbar agak gelap transparan */
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .navbar-brand { 
            font-size: 1.5rem;
            font-weight: 700; 
            letter-spacing: -0.5px;
            color: #ffffff !important; /* Teks brand diubah menjadi putih */
        }

        .nav-link {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8) !important; /* Warna link navbar menjadi putih transparan */
            margin: 0 5px;
            transition: color 0.2s;
            font-size: 0.95rem;
        }

        .nav-link:hover {
            color: var(--primary-color) !important; /* Hover tetap biru */
        }

        /* Button Styling */
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px 24px;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(78, 115, 223, 0.3);
        }

        .btn-outline-primary {
            border: 2px solid #ffffff; /* Mengubah border tombol login menjadi putih */
            color: #ffffff;
            font-weight: 600;
            border-radius: 10px;
            padding: 8px 24px;
        }

        .btn-outline-primary:hover {
            background-color: #ffffff;
            color: var(--dark-color) !important;
            transform: translateY(-2px);
        }

        /* Footer Elegant */
        footer { 
            background-color: rgba(26, 28, 35, 0.9); 
            color: #999; 
            padding: 60px 0 30px; 
            margin-top: 80px; 
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        footer p {
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
            color: #ffffff;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-home me-2"></i>KostHeBrew
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kosts.index') }}">Kamar</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Tentang Kami</a></li>
                    <li class="nav-item ms-lg-3">
                        @auth
                            <a class="btn btn-primary px-4" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @else
                            <a class="btn btn-outline-primary px-4" href="{{ route('login') }}">Login</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>