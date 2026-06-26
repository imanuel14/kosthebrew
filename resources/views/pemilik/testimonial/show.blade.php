@extends('layouts.app')

@section('title', 'Detail Testimoni - Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-comment-dots me-2"></i>Detail Testimoni</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h5 class="fw-bold">{{ $testimonial->user_name }}</h5>
                        <div class="mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-warning{{ $i <= $testimonial->stars ? '' : ' text-secondary' }}"></i>
                            @endfor
                        </div>
                        <p class="mb-0">{{ $testimonial->message }}</p>
                        <p class="text-muted small mt-3">Dibuat pada {{ $testimonial->created_at->translatedFormat('d F Y H:i') }}</p>
                    </div>
                    <a href="{{ route('admin.testimonial.index') }}" class="btn btn-light text-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
