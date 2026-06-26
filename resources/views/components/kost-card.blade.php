@props(['kost'])

<style>
    .kost-card-glass {
        background: rgba(30, 30, 30, 0.7) !important; 
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 20px;
        transition: all 0.4s ease;
        overflow: hidden;
    }

    .kost-card-glass:hover {
        transform: translateY(-10px);
        background: rgba(45, 45, 45, 0.8) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    }

    .kost-card-glass .text-dark-custom { color: #ffffff !important; }
    .kost-card-glass .text-muted-custom { color: rgba(255, 255, 255, 0.6) !important; }

    .image-wrapper {
        height: 180px;
        position: relative;
        background: transparent !important; 
    }
</style>

<div class="card h-100 kost-card-glass border-0 shadow-lg">
    {{-- BAGIAN ATAS: Kontainer Gambar --}}
    <div class="image-wrapper">
        {{-- Badge Status --}}
        @if($kost->is_occupied)
            <span class="position-absolute top-0 start-0 m-3 badge bg-danger shadow-sm" style="z-index: 5;">
                <i class="bi bi-person-fill-x me-1"></i> Penuh
            </span>
        @else
            <span class="position-absolute top-0 start-0 m-3 badge {{ $kost->category == 'ac' ? 'bg-primary' : ($kost->category == 'homestay' ? 'bg-success' : 'bg-info') }} text-uppercase shadow-sm" style="z-index: 5;">
                {{ $kost->category == 'homestay' ? 'Home Stay' : 'Kamar ' . strtoupper($kost->category) }}
            </span>
        @endif
        
        @if($kost->is_featured && !$kost->is_occupied)
            <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-dark shadow-sm" style="z-index: 5;">
                <i class="bi bi-star-fill me-1"></i> Rekomendasi
            </span>
        @endif

        {{-- Overlay Jika Penuh --}}
        @if($kost->is_occupied)
            <div class="position-absolute w-100 h-100 bg-dark" style="opacity: 0.5; z-index: 2;"></div>
        @endif

        <img src="{{ $kost->image ? Storage::url($kost->image) : Storage::url('defaults/no-image.jpg') }}" 
             class="card-img-top w-100 h-100" 
             alt="{{ $kost->name }}" 
             style="object-fit: cover;">
    </div>

    {{-- BAGIAN BAWAH: Konten --}}
    <div class="card-body d-flex flex-column p-4">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h5 class="fw-bold mb-0 text-truncate text-dark-custom" style="max-width: 65%;">{{ $kost->name }}</h5>
            <span class="fw-bold" style="color: #929395;">Rp {{ number_format($kost->price_monthly, 0, ',', '.') }}</span>
        </div>
        
        <p class="text-muted-custom mb-3" style="font-size: 0.9rem;">
            <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $kost->city }}
        </p>

        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="{{ $kost->is_occupied ? 'text-danger fw-bold' : 'text-muted-custom' }}">
                    <i class="bi bi-door-open-fill me-1"></i> 
                    {{ $kost->is_occupied ? 'Kamar Terisi Penuh' : 'Sisa ' . $kost->room_available . ' Kamar' }}
                </small>
                <div class="text-warning small">
                    <i class="bi bi-star-fill"></i> <span class="text-white ms-1">{{ number_format($kost->average_rating ?? 5.0, 1) }}</span>
                </div>
            </div>
            <a href="{{ $kost->is_occupied ? '#' : route('kosts.show', $kost->id) }}" 
               class="btn {{ $kost->is_occupied ? 'btn-secondary disabled' : 'btn-primary' }} w-100 fw-bold rounded-pill shadow-sm" 
               style="{{ !$kost->is_occupied ? 'background: linear-gradient(45deg, #f2f2f2 0%, #000000 100%); border: none; color: white !important;' : '' }}">
                {{ $kost->is_occupied ? 'Sudah Terisi' : 'Lihat Detail' }}
            </a>
        </div>
    </div>
</div>