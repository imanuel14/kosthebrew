<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Kost HeBrew')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-bg: #4e73df;
            --sidebar-dark: #212529;
        }
        body { background-color: #f8f9fc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        #wrapper { display: flex; width: 100%; align-items: stretch; position: relative; min-height: 100vh; }
        
        /* ==========================================================================
           1. SIDEBAR STANDAR (USER BIASA) - MODERNIZED
           ========================================================================== */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #e5e8ed;
            transition: all 0.3s ease;
        }
        #wrapper.toggled #sidebar-wrapper { margin-left: -250px; }
        
        .sidebar-heading { padding: 1.5rem; color: #212529; font-weight: bold; font-size: 1.2rem; }
        
        /* ==========================================================================
           2. SIDEBAR MODERN (KHUSUS PEMILIK & ADMIN)
           ========================================================================== */
        .sidebar-modern {
            width: 240px; 
            min-width: 240px;
            background-color: #ffffff !important;
            display: flex;
            flex-direction: column;
            padding: 2rem 0;
            border-right: 1px solid #e5e8ed;
            position: fixed;
            height: 100vh;
            z-index: 9999;
            left: 0;
            top: 0;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .brand-logo {
            width: auto;
            height: 50px;
            background: linear-gradient(135deg, #4d76fd 0%, #a164ff 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white !important;
            font-size: 1.3rem;
            font-weight: bold;
            margin: 0 1.2rem 3rem 1.2rem;
            text-decoration: none;
            padding: 0 10px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem; 
            width: 100%;
            padding: 0 1rem;
        }

        .menu-item {
            color: #a0aec0 !important;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s;
            padding: 12px 16px;
            border-radius: 12px;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 12px; 
            text-decoration: none;
        }

        .menu-item i {
            font-size: 1.2rem;
            width: 25px; 
            text-align: center;
        }

        .menu-item:hover, .menu-item.active {
            color: #4d76fd !important;
            background-color: #f0f4ff;
        }

        .sidebar-toggle-btn {
            position: absolute;
            top: 50%;
            right: -15px;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            background-color: #ffffff;
            border: 1px solid #e5e8ed;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4d76fd;
            cursor: pointer;
            box-shadow: 4px 0 10px rgba(0,0,0,0.06);
            z-index: 10005;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        /* LOGIKA TOGGLE SIDEBAR MODERN */
        .sidebar-collapsed .sidebar-modern { transform: translateX(-240px); }
        .sidebar-collapsed #page-content-wrapper.owner-content { margin-left: 0 !important; width: 100%; padding-left: 1.5rem; }

        /* ==========================================================================
           3. CONTENT WRAPPER LAYOUT
           ========================================================================== */
        #page-content-wrapper { width: 100%; flex-grow: 1; transition: all 0.3s ease; }
        
        #page-content-wrapper.owner-content {
            margin-left: 240px !important; 
            padding: 3rem;
            width: calc(100% - 240px);
            min-height: 100vh;
            box-sizing: border-box;
            background-color: #f3f4f9 !important;
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }
        
        .navbar-custom { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .mt-auto { margin-top: auto !important; }
        .menu-item.logout-item:hover { color: #ef4444 !important; background-color: #fef2f2; }
        .swal-rounded-popup { border-radius: 20px !important; }
    </style>
</head>
<body>

<div id="wrapper">
    @auth
        @if(!in_array(auth()->user()->role, ['pemilik','admin']))
            <div id="sidebar-wrapper" class="d-flex flex-column justify-content-between">
                <div>
                    <div class="sidebar-heading border-0 text-dark fw-bold px-4 py-4 d-flex align-items-center">
                        <div class="rounded-3 me-2 text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: linear-gradient(135deg, #4d76fd 0%, #a164ff 100%);">
                            <i class="fas fa-home" style="font-size: 0.9rem;"></i>
                        </div>
                        <span>KostHeBrew</span>
                    </div>
                    
                    <div class="list-group list-group-flush px-2 mt-2" style="gap: 4px;">
                        <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2 px-3 border-0 rounded-3 {{ request()->routeIs('user.dashboard') ? 'text-primary' : 'text-secondary' }}" style="background-color: {{ request()->routeIs('user.dashboard') ? '#f0f4ff' : 'transparent' }}; font-weight: 500;">
                            <i class="fas fa-th-large {{ request()->routeIs('user.dashboard') ? 'text-primary' : 'text-muted' }}" style="width: 20px; text-align: center;"></i> 
                            <span>Dashboard Saya</span>
                        </a>

                        <a href="{{ route('payments.my') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2 px-3 border-0 rounded-3 {{ request()->routeIs('payments.my') || request()->is('user/payments*') ? 'text-primary' : 'text-secondary' }}" style="background-color: {{ request()->routeIs('payments.my') || request()->is('user/payments*') ? '#f0f4ff' : 'transparent' }}; font-weight: 500;">
                            <i class="fas fa-receipt {{ request()->routeIs('payments.my') || request()->is('user/payments*') ? 'text-primary' : 'text-muted' }}" style="width: 20px; text-align: center;"></i> 
                            <span>Riwayat Transaksi</span>
                        </a>
                        <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2 px-3 border-0 rounded-3 {{ request()->routeIs('user.profile') ? 'text-primary' : 'text-secondary' }}" style="background-color: {{ request()->routeIs('user.profile') ? '#f0f4ff' : 'transparent' }}; font-weight: 500;">
                            <i class="fas fa-user {{ request()->routeIs('user.profile') ? 'text-primary' : 'text-muted' }}" style="width: 20px; text-align: center;"></i> 
                            <span>Profil Saya</span>
                        </a>
                    </div>
                    <div>
        </div>
                </div>

                <div class="px-3 mb-4">
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-2 px-3 border-0 rounded-3 text-danger" style="font-weight: 500; background: none;" onclick="confirmLogout(event)">
                        <i class="fas fa-sign-out-alt" style="width: 20px; text-align: center;"></i> 
                        <span>Keluar</span>
                    </a>
                </div>
            </div>
        @else
            <div class="sidebar-modern">
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('pemilik.dashboard') }}" class="brand-logo">
                    Kost HeBrew
                </a>
                
                <div class="sidebar-menu">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.kost.index') }}" class="menu-item {{ request()->is('admin/kost*') ? 'active' : '' }}">
                            <i class="fas fa-building"></i> <span>Kelola Kost</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->is('admin/users*') ? 'active' : '' }}" title="Kelola Pengguna Sistem">
                            <i class="fas fa-users"></i> <span>Kelola User</span>
                        </a>
                        <a href="{{ route('admin.transaksi.index') }}" class="menu-item {{ request()->is('admin/transaksi*') ? 'active' : '' }}">
                            <i class="fas fa-receipt"></i> <span>Transaksi</span>
                        </a>
                        <a href="{{ route('admin.messages.index') }}" class="menu-item {{ request()->is('admin/messages*') ? 'active' : '' }}">
                            <i class="fas fa-envelope"></i> <span>Pesan Masuk</span>
                        </a>
                        <a href="{{ route('admin.testimonial.index') }}" class="menu-item {{ request()->is('admin/testimonial*') ? 'active' : '' }}">
                            <i class="fas fa-comment-dots"></i> <span>Kelola Testimonial</span>
                        </a>
                    @else
                        <a href="{{ route('pemilik.dashboard') }}" class="menu-item {{ request()->is('pemilik') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> <span>Dashboard</span>
                        </a>
                        <a href="{{ route('pemilik.kost.index') }}" class="menu-item {{ request()->is('pemilik/kost*') ? 'active' : '' }}">
                            <i class="fas fa-building"></i> <span>Kelola Kost</span>
                        </a>
                        <a href="{{ route('pemilik.transaksi.index') }}" class="menu-item {{ request()->is('pemilik/transaksi*') ? 'active' : '' }}">
                            <i class="fas fa-wallet"></i> <span>Transaksi</span>
                        </a>
                    @endif
                </div>

                <div class="sidebar-menu mt-auto mb-4">
                    <a href="#" class="menu-item logout-item" onclick="confirmLogout(event)">
                        <i class="fas fa-sign-out-alt"></i> <span>Keluar</span>
                    </a>
                </div>

                <div id="modern-sidebar-toggle" class="sidebar-toggle-btn">
                    <i class="fas fa-chevron-left"></i>
                </div>
            </div> 
        @endif
    @endauth

    <div id="page-content-wrapper" class="{{ (auth()->check() && in_array(auth()->user()->role, ['pemilik','admin'])) ? 'owner-content' : '' }}">
        
        @if(!auth()->check() || !in_array(auth()->user()->role, ['pemilik','admin']))
            <nav class="navbar navbar-expand-lg navbar-light navbar-custom py-3 px-4">
                <button class="btn btn-outline-secondary border-0 shadow-none" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </nav>
        @endif

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <div class="container-fluid p-0">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bodyWrapper = document.getElementById('wrapper');

        const menuToggle = document.getElementById('menu-toggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                bodyWrapper.classList.toggle('toggled');
            });
        }

        const modernToggleBtn = document.getElementById('modern-sidebar-toggle');
        if (modernToggleBtn) {
            modernToggleBtn.addEventListener('click', function() {
                bodyWrapper.classList.toggle('sidebar-collapsed');
                const icon = modernToggleBtn.querySelector('i');
                if (bodyWrapper.classList.contains('sidebar-collapsed')) {
                    icon.className = 'fas fa-chevron-right';
                } else {
                    icon.className = 'fas fa-chevron-left';
                }
            });
        }
    });

    function confirmLogout(event) {
        event.preventDefault();
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Sesi Anda akan berakhir dan Anda harus masuk kembali.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4d76fd',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'swal-rounded-popup' }
            }).then((result) => {
                if (result.isConfirmed) { document.getElementById('logout-form').submit(); }
            });
        } else {
            if (confirm("Apakah Anda yakin ingin keluar?")) { document.getElementById('logout-form').submit(); }
        }
    }
</script>
</body>
</html>