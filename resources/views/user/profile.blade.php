@extends('layouts.app')

@section('title', 'Profil Saya - Kost HeBrew')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3 shadow" 
                     style="width: 60px; height: 60px; font-size: 1.5rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div>
                    <h4 class="fw-bold mb-0">{{ auth()->user()->name }}</h4>
                    <p class="text-muted mb-0">Kelola informasi pribadi dan verifikasi akun Anda</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Informasi Akun</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Alamat Email</label>
                                <input type="email" class="form-control rounded-3" value="{{ auth()->user()->email }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor WhatsApp</label>
                            <input type="text" name="phone" class="form-control rounded-3" value="{{ auth()->user()->phone ?? '' }}" placeholder="Contoh: 0812xxxxxx">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea name="address" class="form-control rounded-3" rows="3">{{ auth()->user()->address ?? '' }}</textarea>
                        </div>

                        <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Verifikasi Dokumen</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Unggah Foto KTP</label>
                            <input type="file" name="ktp_image" class="form-control rounded-3">
                            <small class="text-muted">Format: JPG, PNG, atau PDF (Max 2MB)</small>
                            
                            @if(auth()->user()->ktp_path)
                                <div class="mt-2">
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i> KTP sudah terunggah</span>
                                    <a href="{{ asset('storage/' . auth()->user()->ktp_path) }}" target="_blank" class="text-primary ms-2 small">Lihat KTP Lama</a>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection