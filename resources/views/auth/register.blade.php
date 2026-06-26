<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Daftar Akun - Kost HeBrew</title>

    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Latar belakang disamakan persis dengan halaman login */
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url("{{ asset('assets/img/he-brew.png') }}") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 40px 0; /* Memberikan ruang napas saat form memanjang di mobile */
        }

        /* Efek Glassmorphism pada kartu register */
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

        /* Penyesuaian Input serasi dengan tema gelap */
        .form-control-user {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: white !important;
        }

        .form-control-user:focus {
            background: rgba(255, 255, 255, 0.2) !important;
            box-shadow: none;
            color: white !important;
        }

        .form-control-user::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        /* Label untuk Select Option bawaan */
        .form-select-user {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: rgba(255, 255, 255, 0.8) !important;
            border-radius: 10rem;
            padding: 0.5rem 1rem;
            height: calc(1.5em + .75rem + 2px);
        }
        
        .form-select-user option {
            background: #222 !important; /* Agar teks pilihan select tetap terbaca */
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
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-4 glass-card">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-white-shadow fw-bold mb-4">Buat Akun Baru!</h1>
                            </div>

                            {{-- Pesan Error Global --}}
                            @if($errors->any())
                                <div class="alert alert-danger bg-danger text-white border-0 small rounded-3">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="user" action="{{ route('register') }}" method="POST">
                                @csrf
                                
                                {{-- Nama Lengkap --}}
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control form-control-user"
                                        placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                </div>

                                {{-- Alamat Email --}}
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user"
                                        placeholder="Alamat Email" value="{{ old('email') }}" required>
                                </div>

                                {{-- Nomor Handphone (Solusi Error Default Value) --}}
                                <div class="form-group">
                                    <input type="text" name="no_hp" class="form-control form-control-user"
                                        placeholder="Nomor HP / WhatsApp (Contoh: 08123456789)" value="{{ old('no_hp') }}" required>
                                </div>

                                {{-- Pilihan Role Pendaftar --}}
                                <div class="form-group">
                                    <select name="role" class="form-control form-select-user" required>
                                        <option value="" disabled selected hidden>Daftar Sebagai...</option>
                                        <option value="pencari" {{ old('role') == 'pencari' ? 'selected' : '' }}>Pencari Kost</option>
                                        <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>Pemilik Kost</option>
                                    </select>
                                </div>

                                {{-- Password & Konfirmasi Password --}}
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" class="form-control form-control-user"
                                            placeholder="Ulangi Password" required>
                                    </div>
                                </div>

                                {{-- Button Submit --}}
                                <button type="submit" class="btn btn-primary btn-user btn-block shadow-sm">
                                    <strong>Daftar Akun</strong>
                                </button>
                            </form>
                            
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Sudah punya akun? Login Di Sini!</a>
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

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
</body>
</html>