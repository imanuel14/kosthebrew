@extends('layouts.app')

@section('title', 'Detail Kost - ' . $kost->name)

@section('content')
<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.kost.index') }}">Data Kost</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Kost</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-building me-2"></i>Informasi Kost</h4>
                    @if($kost->is_featured)
                        <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i>Unggulan</span>
                    @endif
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Nama Kost</label>
                            <p class="fs-5 fw-bold text-primary">{{ $kost->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Kategori</label>
                            <p>
                                @php
                                    $badges = ['ac' => 'bg-info', 'kipas' => 'bg-success', 'homestay' => 'bg-purple'];
                                    $labels = ['ac' => 'Kamar AC', 'kipas' => 'Kamar Kipas', 'homestay' => 'Homestay'];
                                @endphp
                                <span class="badge {{ $badges[$kost->category] ?? 'bg-secondary' }}">
                                    {{ $labels[$kost->category] ?? ucfirst($kost->category) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Kota</label>
                            <p class="fs-6"><i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $kost->city }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Harga Bulanan</label>
                            <p class="fs-5 fw-bold text-success">Rp {{ number_format($kost->price_monthly, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">Alamat</label>
                            <p class="fs-6">{{ $kost->address }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted">Deskripsi</label>
                            <p class="fs-6">{{ $kost->description ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg border-0 mt-4">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-images me-2"></i>Galeri Foto Kost</h4>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row g-3 mb-4">
                        @forelse($kost->images as $image)
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm">
                                    <img src="{{ Storage::url($image->image_path) }}" class="card-img-top" alt="Foto Kost">
                                    <div class="card-footer bg-white border-0 text-center">
                                        <form action="{{ route('admin.kost.images.destroy', ['kost' => $kost->id, 'image' => $image->id]) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger w-100">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada foto galeri.</p>
                        @endforelse
                    </div>

                    <form action="{{ route('admin.kost.images.store', $kost->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="form-label fw-bold">Tambah Foto Galeri</label>
                        <input type="file" name="gallery_images[]" multiple class="form-control" accept="image/*">
                        <small class="form-text text-muted">Maksimal 2MB per foto.</small>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Foto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white py-3"><h4 class="mb-0"><i class="fas fa-address-book me-2"></i>Kontak</h4></div>
                <div class="card-body p-4">
                    <label class="form-label fw-bold text-muted">No. HP</label>
                    <p><i class="fas fa-phone me-2 text-primary"></i>{{ $kost->contact_phone ?? '-' }}</p>
                    <label class="form-label fw-bold text-muted">WhatsApp</label>
                    <p><i class="fab fa-whatsapp me-2 text-success"></i>{{ $kost->contact_whatsapp ?? '-' }}</p>
                </div>
            </div>

            <div class="card shadow-lg border-0 mt-4">
                <div class="card-header bg-info text-white py-3"><h4 class="mb-0"><i class="fas fa-bed me-2"></i>Kamar</h4></div>
                <div class="card-body p-4">
                    <div class="row text-center g-2">
                        <div class="col-6"><div class="p-2 bg-light rounded"><h4 class="mb-0">{{ $kost->kamar->count() }}</h4><small>Total</small></div></div>
                        <div class="col-6"><div class="p-2 bg-success-light rounded"><h4 class="mb-0 text-success">{{ $kost->kamar->where('status', 'tersedia')->count() }}</h4><small>Tersedia</small></div></div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg border-0 mt-4">
                <div class="card-body p-4 d-grid gap-2">
                    <a href="{{ route('admin.kost.edit', $kost->id) }}" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Edit Kost</a>
                    <a href="{{ route('kamar.index', $kost->id) }}" class="btn btn-info"><i class="fas fa-bed me-2"></i>Kelola Kamar</a>
                    <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash me-2"></i>Hapus Kost</button>
                    </form>
                    <a href="{{ route('admin.kost.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-success-light { background-color: #d4edda; }
    .bg-purple { background-color: #6f42c1; color: white; }
</style>
@endpush
@endsection