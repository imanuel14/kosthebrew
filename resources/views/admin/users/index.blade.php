@extends('layouts.app')

@section('title', 'Kelola Pengguna - Admin Kost HeBrew')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1"><i class="fas fa-users-cog me-2 text-primary"></i>Manajemen Pengguna</h2>
            <p class="text-muted mb-0">Kelola hak akses dan data pengguna yang terdaftar di sistem KostHeBrew.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Nama Pengguna</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Bergabung</th>
                            <th class="pe-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                        <tr>
                            <td class="ps-4 text-muted fw-semibold">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3 shadow-sm" 
                                         style="width: 38px; height: 38px; background: linear-gradient(135deg, #a164ff 0%, #4d76fd 100%); font-size: 0.9rem;">
                                         {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block">{{ $u->name }}</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">ID: #{{ $u->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-secondary"><i class="far fa-envelope me-2"></i>{{ $u->email }}</span></td>
                            <td>
                                @switch($u->role)
                                    @case('admin') <span class="badge bg-danger rounded-3"><i class="fas fa-user-shield me-1"></i>Admin</span> @break
                                    @case('pemilik') <span class="badge bg-warning text-dark rounded-3"><i class="fas fa-user-tie me-1"></i>Pemilik</span> @break
                                    @default <span class="badge bg-info text-dark rounded-3"><i class="fas fa-user me-1"></i>User</span>
                                @endswitch
                            </td>
                            <td class="text-muted small">{{ $u->created_at->format('d M Y') }}</td>
                            <td class="pe-4 text-center">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.users.show', $u->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteUser('{{ $u->id }}', '{{ $u->name }}')" 
                                            {{ auth()->id() == $u->id ? 'disabled' : '' }}>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $u->id }}" action="{{ route('admin.users.destroy', $u->id) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteUser(id, name) {
        Swal.fire({
            title: 'Hapus ' + name + '?',
            text: "Data akan dihapus permanen dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection