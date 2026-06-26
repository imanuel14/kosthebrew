@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    
    <div class="mb-3">
        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-light border rounded-3 text-secondary px-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesan
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="text-muted small d-block">Subjek Pesan</span>
                    <h4 class="fw-bold text-dark mb-0">{{ $message->subject ?? 'Tanpa Subjek' }}</h4>
                </div>
                <div class="text-end">
                    <span class="text-muted small d-block">Waktu Masuk</span>
                    <span class="badge bg-light text-dark border rounded-2 fw-normal px-2 py-1">
                        {{ $message->created_at->format('d M Y, H:i') }} ({{ $message->created_at->diffForHumans() }})
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            
            <div class="row g-3 mb-4 p-3 rounded-3" style="background-color: #f1f3f5; border: 1px solid #dee2e6;">
                <div class="col-md-4">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Nama Lengkap</small>
                    <span class="fw-semibold text-dark fs-5">{{ $message->name }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Nomor WhatsApp</small>
                    @php
                        // Menangani normalisasi nomor dari format 08 menjadi 62 demi API WA
                        $nomorWa = $message->whatsapp;
                        if (str_starts_with($nomorWa, '0')) {
                            $nomorWa = '62' . substr($nomorWa, 1);
                        }
                    @endphp
                    <a href="https://wa.me/{{ $nomorWa }}" target="_blank" class="fw-semibold text-success fs-5 text-decoration-none d-inline-flex align-items-center">
                        <i class="fab fa-whatsapp me-2 fs-4"></i> {{ $message->whatsapp }}
                    </a>
                </div>
                <div class="col-md-4">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Alamat Email</small>
                    @if($message->email)
                        <span class="fw-semibold text-dark fs-5">{{ $message->email }}</span>
                    @else
                        <span class="text-muted italic small fs-5">Tidak mencantumkan email</span>
                    @endif
                </div>
            </div>

            <div class="mb-2">
                <small class="text-muted fw-bold text-uppercase d-block mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Isi Pesan</small>
                <div class="p-3 bg-white border rounded-3 text-secondary" style="white-space: pre-line; line-height: 1.6; min-height: 150px; font-size: 1.05rem;">
                    {{ $message->message }}
                </div>
            </div>
        </div>

        <div class="card-footer bg-light border-top p-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            
            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger px-4 rounded-3">
                    <i class="fas fa-trash-alt me-2"></i> Hapus Pesan
                </button>
            </form>

            <div class="d-flex gap-2">
                @if($message->email)
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="btn btn-outline-secondary px-4 rounded-3">
                        <i class="far fa-envelope me-2"></i>Balas via Email
                    </a>
                @endif
                
                @php
                    $teksBalas = "Halo " . $message->name . ",\n\nKami dari *KostHeBrew* ingin menanggapi pesan Anda di website terkait '" . $message->subject . "'.\n\n...";
                @endphp
                <a href="https://api.whatsapp.com/send?phone={{ $nomorWa }}&text={{ urlencode($teksBalas) }}" target="_blank" class="btn btn-success px-4 rounded-3 fw-medium">
                    <i class="fab fa-whatsapp me-2"></i>Balas via WhatsApp
                </a>
            </div>
            
        </div>
    </div>
</div>
@endsection