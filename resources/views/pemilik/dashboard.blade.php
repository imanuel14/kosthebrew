@extends('layouts.app')

@section('title', 'Dashboard Pemilik - Kost HeBrew')

@section('content')
<style>
    /* ==========================================================================
       DESAIN PANEL KARTU DASHBOARD (MURNI HANYA UNTUK KONTEN)
       ========================================================================== */
    .profile-greeting h2 { font-weight: 700; color: #1e293b; margin-bottom: 0.2rem; }
    .card-dark-modern {
        background-color: #2b3044 !important;
        border: none;
        border-radius: 20px;
        padding: 1.8rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(43, 48, 68, 0.15);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card-dark-modern .stat-label { color: #94a3b8; font-size: 0.85rem; font-weight: 600; text-uppercase: uppercase; letter-spacing: 0.5px; }
    .card-dark-modern .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-top: 0.5rem;
        background: linear-gradient(45deg, #ffffff, #cbd5e1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .card-decor-line { height: 4px; width: 100%; border-radius: 2px; margin-top: 1.5rem; }
    .card-white-modern { background-color: #ffffff !important; border: none; border-radius: 20px; padding: 1.8rem; box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03); }
    .table-modern thead th { background-color: #f8fafc !important; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; padding: 1rem; }
    .table-modern tbody td { padding: 1.2rem 1rem; border-bottom: 1px solid #f1f5f9; color: #334155; }
    
    .btn-modern-primary {
        background: linear-gradient(135deg, #4d76fd 0%, #3b62e3 100%);
        color: white !important;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(77, 118, 253, 0.2);
        display: block;
    }
    .btn-modern-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(77, 118, 253, 0.3); }
    .btn-modern-outline { background: transparent; border: 2px solid #e2e8f0; color: #475569 !important; padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; transition: all 0.3s; display: block; }
    .btn-modern-outline:hover { background-color: #f8fafc; border-color: #cbd5e1; text-decoration: none; }
</style>

<div class="mb-5">
    <div class="profile-greeting">
        <h2>Hi, Pemilik <span style="font-weight: 400; color: #94a3b8;">›</span></h2>
        <p class="text-muted mb-0">Mari pantau statistik performa bisnis hunian Anda hari ini.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-xl-6 col-md-6">
        <div class="card-dark-modern">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="stat-label">Total Properti Kost</span>
                    <i class="fas fa-building text-primary"></i>
                </div>
                <div class="stat-value">{{ $totalKost }}</div>
            </div>
            <div>
                <div class="card-decor-line" style="background: linear-gradient(to right, #4d76fd, #2cd3e1);"></div>
                <div class="mt-3">
                    <a href="{{ route('pemilik.kost.index') }}" class="text-white-50 text-decoration-none small">Lihat unit properti →</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card-dark-modern">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="stat-label">Transaksi Berhasil</span>
                    <i class="fas fa-receipt text-warning"></i>
                </div>
                <div class="stat-value">{{ $totalTransaksi }}</div>
            </div>
            <div>
                <div class="card-decor-line" style="background: linear-gradient(to right, #f59e0b, #fef08a);"></div>
                <div class="mt-3">
                    <a href="{{ route('pemilik.transaksi.index') }}" class="text-white-50 text-decoration-none small">Rekap arus kas masuk →</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="card-white-modern h-100 d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold text-dark mb-4"><i class="fas fa-sliders-h me-2 text-primary"></i>Kontrol Navigasi</h5>
                <div class="d-grid gap-3">
                    <a href="{{ route('pemilik.kost.create') }}" class="btn btn-modern-primary text-center text-decoration-none">
                        <i class="fas fa-plus me-2"></i> Tambah Kost Baru
                    </a>
                    {{-- <a href="{{ route('pemilik.transaksi.index') }}" class="btn btn-modern-outline text-center text-decoration-none">
                        <i class="fas fa-receipt me-2"></i> Riwayat Keuangan
                    </a> --}}
                </div>
            </div>
            <div class="pt-4 border-top mt-4 text-center text-muted small">
                Kost HeBrew Dashboard
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card-white-modern h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-hotel me-2" style="color: #a164ff;"></i>Inventaris Kost Terbaru</h5>
                <a href="{{ route('pemilik.kost.index') }}" class="btn btn-sm btn-light text-primary fw-bold text-decoration-none px-3">Lihat Semua</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama Properti</th>
                            <th>Lokasi Kota</th>
                            <th>Harga Bulanan</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentKosts as $kost)
                        <tr>
                            <td><span class="fw-bold text-dark">{{ $kost->name }}</span></td>
                            <td><i class="fas fa-map-marker-alt text-muted me-1"></i> {{ $kost->city }}</td>
                            <td><span class="fw-semibold text-primary">Rp {{ number_format($kost->price_monthly, 0, ',', '.') }}</span></td>
                            <td class="text-center">
                                <span class="badge px-3 py-2 rounded-pill {{ $kost->is_active ? 'bg-light text-success border border-success' : 'bg-light text-secondary' }}">
                                    {{ $kost->is_active ? '● Aktif' : '○ Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                                Belum ada data unit kost yang didaftarkan.
                            </td>
                        </tr>
                        @endempty
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection