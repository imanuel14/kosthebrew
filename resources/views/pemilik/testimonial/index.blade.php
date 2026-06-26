@extends('layouts.app')

@section('title', 'Manajemen Testimoni - Admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-comment-dots me-2"></i>Daftar Testimoni</h2>
        <a href="{{ route('admin.testimonial.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Testimoni
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if($testimonials->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama</th>
                                <th>Pesan</th>
                                <th>Rating</th>
                                <th class="pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $testimonial->user_name }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($testimonial->message, 80) }}</td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-warning{{ $i <= $testimonial->stars ? '' : ' text-secondary' }}"></i>
                                        @endfor
                                    </td>
                                    <td class="pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.testimonial.show', $testimonial) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.testimonial.edit', $testimonial) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.testimonial.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus testimoni ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    {{ $testimonials->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-comment-dots fs-1 mb-3"></i>
                    <p class="mb-0">Belum ada testimoni.</p>
                    <a href="{{ route('admin.testimonial.create') }}" class="btn btn-primary mt-3">
                        Tambah Testimoni Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
