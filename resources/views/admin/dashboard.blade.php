@extends('layouts.app')

@section('title', 'Dashboard Admin - Kost HeBrew')

@section('content')
<style>
    /* Menghilangkan elemen footer/navigasi bawah jika ada di layout utama */
    footer, .footer-section, .bottom-nav {
        display: none !important;
    }

    .card { 
        border: none; 
        border-radius: 15px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.05); 
    }

    .stat-card-primary { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
    .stat-card-success { background: linear-gradient(135deg, #198754 0%, #146c43 100%); }
    .stat-card-info { background: linear-gradient(135deg, #0dcaf0 0%, #0bacbe 100%); }

    .btn-action {
        border-radius: 10px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }

    /* Warna kustom badge untuk Log Aktivitas */
    .bg-log-login { background-color: #e0f2fe; color: #0369a1; }
    .bg-log-logout { background-color: #fef2f2; color: #b91c1c; }
    .bg-log-default { background-color: #f3f4f6; color: #374151; }
</style>

<div class="container-fluid p-0">
    <div class="mb-5">
        <h1 class="fw-bold text-dark">Dashboard Admin</h1>
        <p class="text-muted">Selamat datang kembali, Administrator Sistem Kost HeBrew.</p>
    </div>
    
    <div class="row g-4 mb-5">
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-primary text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small fw-bold text-uppercase">Total Kost</div>
                        <div class="display-5 fw-bold mt-1">{{ $totalKost }}</div>
                    </div>
                    <i class="fas fa-building fa-3x opacity-25"></i>
                </div>
                <a href="{{ route('admin.kost.index') }}" class="text-white text-decoration-none mt-4 small d-flex align-items-center gap-1">
                    Lihat Detail <i class="fas fa-arrow-right sm-1"></i>
                </a>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-success text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small fw-bold text-uppercase">Total Penyewa</div>
                        <div class="display-5 fw-bold mt-1">{{ $totalPenyewa }}</div>
                    </div>
                    <i class="fas fa-users fa-3x opacity-25"></i>
                </div>
                <a href="#" class="text-white text-decoration-none mt-4 small d-flex align-items-center gap-1">
                    Lihat Detail <i class="fas fa-arrow-right sm-1"></i>
                </a>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-info text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-50 small fw-bold text-uppercase">Total Transaksi</div>
                        <div class="display-5 fw-bold mt-1">{{ $totalTransaksi }}</div>
                    </div>
                    <i class="fas fa-receipt fa-3x opacity-25"></i>
                </div>
                <a href="{{ route('admin.transaksi.index') }}" class="text-white text-decoration-none mt-4 small d-flex align-items-center gap-1">
                    Lihat Detail <i class="fas fa-arrow-right sm-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header bg-white border-0 py-3 mt-2">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body d-grid gap-3 pt-0">
                    <a href="{{ route('admin.kost.create') }}" class="btn btn-primary btn-action shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Kost Baru
                    </a>
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary btn-action">
                        <i class="fas fa-list-alt me-2"></i> Kelola Transaksi
                    </a>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-info btn-action">
                        <i class="fas fa-envelope me-2"></i> Lihat Pesan Masuk
                    </a>
                    <a href="{{ route('admin.testimonial.index') }}" class="btn btn-outline-success btn-action">
                        <i class="fas fa-comment-dots me-2"></i> Kelola Testimonial
                    </a>
                    <a href="{{ route('admin.kost.index') }}" class="btn btn-outline-secondary btn-action">
                        <i class="fas fa-building me-2"></i> Kelola Kost
                    </a>
    
                    <button type="button" class="btn btn-outline-danger btn-action" onclick="confirmLogout(event)">
                        <i class="fas fa-sign-out-alt me-2"></i> Keluar Aplikasi
                    </button>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header bg-white border-0 py-3 mt-2">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-history me-2 text-primary"></i>Kost Terbaru</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Kost</th>
                                    <th>Kota</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentKosts as $kost)
                                <tr>
                                    <td><span class="fw-bold text-dark">{{ $kost->name }}</span></td>
                                    <td>{{ $kost->city }}</td>
                                    <td>Rp {{ number_format($kost->price_monthly, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $kost->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $kost->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada data kost.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0 py-3 mt-2">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-shield-alt me-2 text-info"></i>Log Aktivitas Sistem Terkini</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Pengguna</th>
                                    <th>Aktivitas</th>
                                    <th>Detail Keterangan</th>
                                    <th>IP Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activityLogs ?? [] as $log)
                                <tr>
                                    <td class="text-muted small">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $log->user ? $log->user->name : 'Sistem/Guest' }}</span>
                                        <span class="badge bg-light text-muted border ms-1" style="font-size: 0.75rem;">{{ $log->user ? ucfirst($log->user->role) : 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge px-2 py-1.5 fw-semibold {{ $log->activity === 'Login' ? 'bg-log-login' : ($log->activity === 'Logout' ? 'bg-log-logout' : 'bg-log-default') }}">
                                            {{ $log->activity }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $log->description }}</td>
                                    <td><code class="text-secondary small">{{ $log->ip_address ?? '127.0.0.1' }}</code></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat aktivitas sistem yang tercatat hari ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection