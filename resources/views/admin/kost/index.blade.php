@extends('layouts.app')

@section('title', 'Daftar Kost - Admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-building me-2"></i>Daftar Kost</h2>
        <a href="{{ route('admin.kost.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Kost
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if($kosts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Kost</th>
                                <th>Kota</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Kamar</th>
                                <th>Status</th>
                                <th class="pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kosts as $kost)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $kost->name }}</td>
                                <td>{{ $kost->city }}</td>
                                <td>
                                    @switch($kost->category)
                                        @case('ac')
                                            <span class="badge bg-info">AC</span>
                                            @break
                                        @case('kipas')
                                            <span class="badge bg-warning">Kipas</span>
                                            @break
                                        @case('homestay')
                                            <span class="badge bg-success">Homestay</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $kost->category }}</span>
                                    @endswitch
                                </td>
                                <td class="fw-bold text-primary">Rp {{ number_format($kost->price_monthly, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $kost->room_available > 0 ? 'success' : 'danger' }}">
                                        {{ $kost->room_available }}/{{ $kost->room_total }}
                                    </span>
                                </td>
                                <td>
                                    @if($kost->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.kost.show', $kost->id) }}" class="btn btn-sm btn-outline-info" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.kost.edit', $kost->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.kost.destroy', $kost->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kost ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger">
        <i class="fas fa-trash"></i> Hapus
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
                    {{ $kosts->links() }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-building fs-1 mb-3"></i>
                    <p class="mb-0">Belum ada kost yang ditambahkan.</p>
                    <a href="{{ route('admin.kost.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Tambah Kost Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection