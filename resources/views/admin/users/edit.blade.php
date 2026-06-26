@extends('layouts.app')

@section('title', 'Ubah Pengguna - Admin Kost HeBrew')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fas fa-user-edit me-2 text-primary"></i>Ubah Profil & Hak Akses
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nama Lengkap</label>
                            <input type="text" class="form-control rounded-3" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Alamat Email</label>
                            <input type="email" class="form-control rounded-3" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Peran / Hak Akses</label>
                            <select class="form-select rounded-3" name="role" required {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Pencari Kost</option>
                                <option value="pemilik" {{ $user->role === 'pemilik' ? 'selected' : '' }}>Pemilik Kost</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                        </div>

                        <div class="card border-warning mb-4 shadow-sm">
                            <div class="card-body bg-light">
                                <h6 class="text-warning fw-bold mb-3"><i class="fas fa-key me-2"></i>Reset Password</h6>
                                <div class="input-group mb-2">
                                    <input type="text" id="password_input" name="new_password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                    <button type="button" class="btn btn-outline-secondary" onclick="generatePassword()">
                                        <i class="fas fa-magic"></i> Generate
                                    </button>
                                </div>
                                <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Admin dapat membuat password baru untuk pengguna.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-3 px-4">Batal</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4 shadow-sm" style="background: linear-gradient(135deg, #4d76fd 0%, #a164ff 100%); border: none;">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generatePassword() {
        const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*";
        let password = "";
        for (let i = 0; i < 10; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('password_input').value = password;
    }
</script>
@endsection