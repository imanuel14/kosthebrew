@extends('layouts.frontend')

@section('title', 'Kost ' . ucfirst($type) . ' - Sistem Informasi Kost')

@section('content')
<div class="bg-light min-vh-100 py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Kost {{ ucfirst($type) }}</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold mb-3">
                @if($type == 'male')
                    <i class="bi bi-gender-male text-primary me-2"></i>Kost Putra
                @elseif($type == 'female')
                    <i class="bi bi-gender-female text-danger me-2"></i>Kost Putri
                @else
                    <i class="bi bi-people text-purple me-2" style="color: #8b5cf6;"></i>Kost Campur
                @endif
            </h1>
            <p class="lead text-muted">
                @if($type == 'male')
                    Temukan kost eksklusif untuk pria dengan fasilitas lengkap
                @elseif($type == 'female')
                    Kost aman dan nyaman khusus untuk wanita dengan keamanan 24 jam
                @else
                    Kost dengan suasana beragam cocok untuk semua kalangan
                @endif
            </p>
        </div>

        <!-- Results -->
        <div class="row g-4">
            @forelse($kosts as $kost)
                <div class="col-md-6 col-lg-4">
                    <x-kost-card :kost="$kost" />
                </div>
            @empty
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada kost dalam kategori ini</h4>
                            <a href="{{ route('kosts.index') }}" class="btn btn-primary mt-3">
                                Lihat Semua Kost
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $kosts->links() }}
        </div>
    </div>
</div>
@endsection