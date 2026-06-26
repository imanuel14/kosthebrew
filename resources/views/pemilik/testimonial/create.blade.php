@extends('layouts.app')

@section('title', 'Tambah Testimoni - Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                    <div class="d-flex">
                        <i class="fas fa-exclamation-circle mt-1 me-2"></i>
                        <div>
                            <strong>Validasi gagal!</strong> Perbaiki inputan berikut:
                            <ul class="mb-0 small mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-comment-dots me-2"></i>Tambah Testimoni</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.testimonial.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pengguna <span class="text-danger">*</span></label>
                            <input type="text" name="user_name" value="{{ old('user_name') }}" class="form-control @error('user_name') is-invalid @enderror" required>
                            @error('user_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pesan Testimoni <span class="text-danger">*</span></label>
                            <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating (1-5) <span class="text-danger">*</span></label>
                            <select name="stars" class="form-select @error('stars') is-invalid @enderror" required>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('stars') == $i ? 'selected' : '' }}>{{ $i }} bintang</option>
                                @endfor
                            </select>
                            @error('stars')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.testimonial.index') }}" class="btn btn-light text-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button class="btn btn-primary px-4" type="submit">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
