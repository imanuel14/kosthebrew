@extends('layouts.app')

@section('title', 'Detail Pengguna - Admin Kost HeBrew')

@section('content')
<div class="container py-5">
    <!-- Header Navigasi -->
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card Detail -->
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <!-- Banner Profil Atas -->
                <div class="p-4 text-white d-flex align-items-center" style="background: linear-gradient(135deg, #4d76fd 0%, #a164ff 100%);">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-white text-primary fw-bold shadow me-4" 
                         style="width: 70px; height: 70px; font-size: 1.8rem;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="mb-0 text-white-50 small">ID Anggota: #{{ $user->id }}</p>
                    </div>
                </div>

                <!-- Informasi Akun -->
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Informasi Akun Utama</h5>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-secondary fw-semibold">Nama Lengkap</div>
                        <div class="col-sm-8 text-dark fw-bold">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-secondary fw-semibold">Alamat Email</div>
                        <div class="col-sm-8 text-dark">
                            <i class="far fa-envelope text-muted me-2"></i>{{ $user->email }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-secondary fw-semibold">Hak Akses Sistem</div>
                        <div class="col-sm-8">
                            @switch($user->role)
                                @case('admin')
                                    <span class="badge bg-danger px-2.5 py-1.5 rounded-3"><i class="fas fa-user-shield me-1"></i>Administrator</span>
                                    @break
                                @case('pemilik')
                                    <span class="badge bg-warning text-dark px-2.5 py-1.5 rounded-3"><i class="fas fa-user-tie me-1"></i>Pemilik Kost</span>
                                    @break
                                @default
                                    <span class="badge bg-info text-dark px-2.5 py-1.5 rounded-3"><i class="fas fa-user me-1"></i>Pencari Kost</span>
                            @endswitch
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-secondary fw-semibold">Tanggal Registrasi</div>
                        <div class="col-sm-8 text-secondary">
                            <i class="far fa-calendar-alt text-muted me-2"></i>{{ $user->created_at ? $user->created_at->translatedFormat('l, d F Y (H:i)') : '-' }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4 text-secondary fw-semibold">Terakhir Diperbarui</div>
                        <div class="col-sm-8 text-secondary">
                            <i class="fas fa-history text-muted me-2"></i>{{ $user->updated_at ? $user->updated_at->diffForHumans() : '-' }}
                        </div>
                    </div>

                    <!-- Tombol Navigasi Cepat -->
                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary rounded-3 px-4" style="background-color: #4d76fd; border: none;">
                            <i class="fas fa-edit me-2"></i>Ubah Profil Akun
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 mt-3">
    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Riwayat Pembayaran User</h5>
    
    @if($user->penyewa && $user->penyewa->payments->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Invoice ID</th>
                        <th>Properti Kost</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->penyewa->payments as $payment)
                    <tr>
                        <td>{{ $payment->order_id }}</td>
                        <td>{{ $payment->kamar->kost->name ?? '-' }}</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $payment->status == 'success' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>{{ $payment->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-3 text-muted">
            <i class="fas fa-receipt mb-2"></i>
            <p>Tidak ada riwayat pembayaran untuk pengguna ini.</p>
        </div>
    @endif
</div>
<div class="row mb-3">
    <div class="col-sm-4 text-secondary">Foto KTP User</div>
    <div class="col-sm-8">
        @if($user->ktp_path)
            <div class="mt-2">
                <a href="{{ asset('storage/' . $user->ktp_path) }}" target="_blank">
                    <img src="{{ asset('storage/' . $user->ktp_path) }}" 
                         alt="Foto KTP" 
                         class="img-thumbnail" 
                         style="max-width: 300px; border: 2px solid #ddd; border-radius: 8px;">
                </a>
                <p class="text-muted small mt-1">Klik gambar untuk memperbesar</p>
            </div>
        @else
            <span class="text-muted small">Belum mengunggah KTP</span>
        @endif
    </div>
</div>
            </div>
        </div>
    </div>
</div>
@endsection