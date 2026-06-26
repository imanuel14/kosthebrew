@extends('layouts.app')

@section('title', 'Tambah Kost Baru - Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Alert Error Global --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                    <div class="d-flex">
                        <i class="fas fa-exclamation-circle mt-1 me-2"></i>
                        <div>
                            <strong>Penyimpanan Gagal!</strong> Mohon periksa kembali inputan Anda:
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
                <div class="card-header bg-success text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Kost Baru</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.kost.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-3">
                            {{-- Nama Kost --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Nama Kost <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Contoh: Kost Mahasiswa Berkah">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    <option value="ac" {{ old('category') == 'ac' ? 'selected' : '' }}>Kamar AC</option>
                                    <option value="kipas" {{ old('category') == 'kipas' ? 'selected' : '' }}>Kamar Kipas</option>
                                    <option value="homestay" {{ old('category') == 'homestay' ? 'selected' : '' }}>Homestay</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Harga Bulanan --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Harga Bulanan (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="price_monthly" class="form-control @error('price_monthly') is-invalid @enderror" value="{{ old('price_monthly') }}" min="0" required placeholder="Contoh: 850000">
                                @error('price_monthly')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kota --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kota <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required placeholder="Contoh: Jakarta Selatan">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kecamatan --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}" required placeholder="Contoh: Tebet">
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- No HP Kontak (Sudah sinkron menggunakan contact_phone) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="contact_whatsapp" class="form-control @error('contact_whatsapp') is-invalid @enderror" value="{{ old('contact_whatsapp') }}" required placeholder="Contoh: 62812345678">
                                @error('contact_whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Total Kamar --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Total Kamar <span class="text-danger">*</span></label>
                                <input type="number" name="room_total" class="form-control @error('room_total') is-invalid @enderror" value="{{ old('room_total') }}" min="1" required placeholder="0">
                                @error('room_total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kamar Tersedia --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Kamar Tersedia <span class="text-danger">*</span></label>
                                <input type="number" name="room_available" class="form-control @error('room_available') is-invalid @enderror" value="{{ old('room_available') }}" min="0" required placeholder="0">
                                @error('room_available')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required placeholder="Nama jalan, nomor rumah, RT/RW...">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Deskripsi Kost</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Jelaskan detail fasilitas kos, jam malam, peraturan, dll.">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Foto Utama Kost --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Foto Utama Kost <span class="text-danger">*</span></label>
                                <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                                <div class="form-text">File utama wajib diunggah untuk tampilan kartu index. Maksimal 2MB.</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Live Preview Foto Utama --}}
                                <div id="mainPreviewContainer" class="mt-3 text-center d-none p-3 bg-light rounded-3 border">
                                    <span class="d-block small text-success fw-bold mb-2">Preview Foto Utama:</span>
                                    <img id="imgPreview" src="#" alt="Preview Foto Utama" class="img-fluid rounded-3 shadow-sm" style="max-height: 180px; object-fit: cover; border: 2px dashed #198754; padding: 3px;">
                                </div>
                            </div>

                            {{-- Foto Galeri Kost (Slider Multi-File) --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Foto Galeri Tambahan (Slider Detail)</label>
                                <input type="file" name="gallery_images[]" id="galleryInput" multiple class="form-control @error('gallery_images.*') is-invalid @enderror" accept="image/*">
                                <div class="form-text">Bisa memilih lebih dari satu foto sekaligus untuk galeri slider detail kos. Maksimal 2MB per foto.</div>
                                @error('gallery_images.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                {{-- Live Preview Multi-File Galeri --}}
                                <div id="galleryPreviewWrapper" class="mt-3 p-3 bg-light rounded-3 border d-none">
                                    <span class="d-block small text-primary fw-bold mb-2"><i class="fas fa-images me-1"></i> Preview Galeri Slider:</span>
                                    <div id="galleryPreviewContainer" class="d-flex flex-wrap gap-2"></div>
                                </div>
                            </div>

                            {{-- Checkbox Status & Unggulan --}}
                            <div class="col-md-6 mt-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="is_active">Langsung Aktifkan Kost</label>
                                </div>
                            </div>

                            <div class="col-md-6 mt-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="is_featured">Jadikan Kost Unggulan (Featured)</label>
                                </div>
                            </div>
                        </div>

                        {{-- Checkbox Status Penghuni --}}
<div class="col-md-6 mt-4">
    <div class="form-check form-switch">
        <input type="checkbox" name="is_occupied" class="form-check-input" id="is_occupied" value="1" {{ old('is_occupied') ? 'checked' : '' }}>
        <label class="form-check-label fw-bold" for="is_occupied">
            Tandai sebagai sudah berpenghuni
        </label>
    </div>
</div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between mt-5 border-top pt-4">
                            <a href="{{ route('admin.kost.index') }}" class="btn btn-light px-4 text-secondary border">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i>Simpan Kost
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview Real-time Foto Utama
    document.getElementById('imageInput').addEventListener('change', function() {
        const file = this.files[0];
        const container = document.getElementById('mainPreviewContainer');
        const preview = document.getElementById('imgPreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            container.classList.add('d-none');
        }
    });

    // Preview Multi-File Galeri Slider
    document.getElementById('galleryInput').addEventListener('change', function() {
        const wrapper = document.getElementById('galleryPreviewWrapper');
        const container = document.getElementById('galleryPreviewContainer');
        container.innerHTML = ''; // Reset preview sebelumnya
        
        if (this.files && this.files.length > 0) {
            wrapper.classList.remove('d-none');
            Array.from(this.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'position-relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail border-primary shadow-sm" style="width: 100px; height: 75px; object-fit: cover; border-radius: 8px;">
                        <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-primary small" style="font-size: 9px; z-index: 2;">#${index + 1}</span>
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            wrapper.classList.add('d-none');
        }
    });
</script>
@endpush