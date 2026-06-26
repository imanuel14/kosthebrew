@extends('layouts.app')

@section('title', 'Edit Kost - Admin')

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
                            <strong>Update Gagal!</strong> Mohon periksa kembali inputan Anda:
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
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Kost: {{ $kost->name }}</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.kost.update', ['id' => $kost->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            {{-- Nama Kost --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Nama Kost <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $kost->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                    <option value="ac" {{ old('category', $kost->category) == 'ac' ? 'selected' : '' }}>Kamar AC</option>
                                    <option value="kipas" {{ old('category', $kost->category) == 'kipas' ? 'selected' : '' }}>Kamar Kipas</option>
                                    <option value="homestay" {{ old('category', $kost->category) == 'homestay' ? 'selected' : '' }}>Homestay</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Harga Bulanan --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Harga Bulanan (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="price_monthly" class="form-control @error('price_monthly') is-invalid @enderror" value="{{ old('price_monthly', $kost->price_monthly) }}" min="0" required>
                                @error('price_monthly')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kota --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kota <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $kost->city) }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kecamatan --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district', $kost->district) }}" required placeholder="Contoh: Tebet">
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- No HP Kontak (Sudah disinkronkan menjadi contact_phone) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="contact_whatsapp" class="form-control @error('contact_whatsapp') is-invalid @enderror" value="{{ old('contact_whatsapp', $kost->contact_whatsapp) }}" required placeholder="Contoh: 62812345678">
                                @error('contact_whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Total Kamar --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Total Kamar <span class="text-danger">*</span></label>
                                <input type="number" name="room_total" class="form-control @error('room_total') is-invalid @enderror" value="{{ old('room_total', $kost->room_total) }}" min="1" required>
                                @error('room_total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kamar Tersedia --}}
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Kamar Tersedia <span class="text-danger">*</span></label>
                                <input type="number" name="room_available" class="form-control @error('room_available') is-invalid @enderror" value="{{ old('room_available', $kost->room_available) }}" min="0" required>
                                @error('room_available')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required placeholder="Nama jalan, nomor rumah, RT/RW...">{{ old('address', $kost->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Deskripsi Kost</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Jelaskan detail kos, jam malam, peraturan, dll.">{{ old('description', $kost->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Foto Utama Kost --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Foto Utama Kost (Muncul di List/Index)</label>
                                <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                <div class="form-text text-warning">*Kosongkan jika tidak ingin mengubah foto utama yang sudah ada. Maksimal 2MB.</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Menampilkan Foto Utama Saat Ini & Preview --}}
                                <div class="mt-3 row align-items-center justify-content-center bg-light p-3 rounded-3 mx-0 border">
                                    <div class="col-sm-5 text-center">
                                        <span class="d-block small text-muted mb-2">Foto Saat Ini:</span>
                                        @if($kost->image)
                                            <img src="{{ Storage::url($kost->image) }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 150px; object-fit: cover; border: 1px solid #dee2e6;">
                                        @else
                                            <span class="badge bg-secondary p-2">Tidak ada foto</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-2 text-center d-none" id="arrowPreview">
                                        <i class="fas fa-arrow-right fa-2x text-primary my-2"></i>
                                    </div>
                                    <div class="col-sm-5 text-center">
                                        <span class="d-block small text-success mb-2 d-none" id="textPreview">Preview Foto Baru:</span>
                                        <img id="imgPreview" src="#" alt="Preview" class="img-fluid rounded-3 shadow-sm d-none" style="max-height: 150px; object-fit: cover; border: 2px dashed #198754; padding: 3px;">
                                    </div>
                                </div>
                            </div>

                            {{-- Foto Galeri Kost (Slider) --}}
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Tambah Foto ke Galeri Slider</label>
                                <input type="file" name="gallery_images[]" id="galleryInput" multiple class="form-control @error('gallery_images.*') is-invalid @enderror" accept="image/*">
                                <div class="form-text">Pilih file baru jika ingin menambahkan foto ke slider halaman detail. Maksimal 2MB per foto.</div>
                                @error('gallery_images.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                {{-- Live Preview File Baru --}}
                                <div id="galleryPreviewContainer" class="d-flex flex-wrap gap-2 mt-3"></div>

                                {{-- List Foto Galeri yang Sudah Ada di Database --}}
                                @if($kost->images && $kost->images->count() > 0)
                                    <div class="mt-4 p-3 bg-light rounded-3 border">
                                        <span class="d-block small fw-bold text-muted mb-2"><i class="fas fa-images me-1"></i> Isi Galeri Slider Saat Ini (Total: {{ $kost->images->count() }}):</span>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($kost->images as $img)
                                                <div class="position-relative">
                                                    <img src="{{ Storage::url($img->image_path) }}" class="img-thumbnail shadow-sm" style="width: 100px; height: 75px; object-fit: cover; border-radius: 8px;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-text text-muted mt-2 small"><i class="fas fa-info-circle me-1"></i>Catatan: Pengaturan hapus foto galeri satu per satu bisa dikelola via menu managemen galeri terpisah jika diperlukan.</div>
                                    </div>
                                @endif
                            </div>

                            {{-- Checkbox Status & Unggulan --}}
                            <div class="col-md-6 mt-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $kost->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="is_active">Status Kost Aktif</label>
                                </div>
                            </div>

                            <div class="col-md-6 mt-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured', $kost->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="is_featured">Jadikan Kost Unggulan (Featured)</label>
                                </div>
                            </div>
                        </div>
                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between mt-5 border-top pt-4">
                            <a href="{{ route('admin.kost.index') }}" class="btn btn-light px-4 text-secondary border">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i>Update Kost
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
    // Preview Real-time Foto Utama Baru
    document.getElementById('imageInput').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = document.getElementById('imgPreview');
            const arrow = document.getElementById('arrowPreview');
            const text = document.getElementById('textPreview');
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if(arrow) arrow.classList.remove('d-none');
                if(text) text.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // Preview Multi-File Galeri Baru
    document.getElementById('galleryInput').addEventListener('change', function() {
        const container = document.getElementById('galleryPreviewContainer');
        container.innerHTML = ''; // Reset container
        
        if (this.files) {
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'position-relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail border-success shadow-sm" style="width: 100px; height: 75px; object-fit: cover; border-radius: 8px;">
                        <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-success small" style="font-size: 10px; z-index: 2;">Baru</span>
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    });
</script>
@endpush