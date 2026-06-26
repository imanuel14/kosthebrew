<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Kost HeBrew</title>

    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Latar belakang sama dengan halaman kontak/tentang kami */
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url("{{ asset('assets/img/he-brew.png') }}") no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
        }

        /* Efek Glassmorphism pada kartu login */
        .glass-card {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 1.5rem !important;
        }

        .text-white-shadow {
            color: white;
            text-shadow: 0px 2px 4px rgba(0,0,0,0.5);
        }

        /* Penyesuaian Input agar serasi dengan tema gelap */
        .form-control-user {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: white !important;
        }

        .form-control-user:focus {
            background: rgba(255, 255, 255, 0.2) !important;
            box-shadow: none;
        }

        .form-control-user::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .custom-control-label {
            color: white;
        }

        hr {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        a.small {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        a.small:hover {
            color: #4e73df !important;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-5 glass-card">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-white-shadow fw-bold mb-4">Selamat Datang Kembali!</h1>
                            </div>

                            {{-- Pesan Error Global --}}
                            @if($errors->any())
                                <div class="alert alert-danger bg-danger text-white border-0 small">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="user" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user"
                                        placeholder="Masukkan Alamat Email..." value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user"
                                        placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="remember" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block shadow-sm">
                                    <strong>Login</strong>
                                </button>
                            </form>
                            
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('register') }}">Belum punya akun? Daftar Sekarang!</a>
                            </div>
                            <div class="text-center mt-2">
                                <a class="small fw-bold" href="/">
                                    <i class="fas fa-arrow-left fa-sm"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
</body>
</html>