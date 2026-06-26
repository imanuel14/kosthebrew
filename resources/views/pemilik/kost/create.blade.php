@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Kost</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pemilik.kost.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Utama</label>
            <input type="file" name="main_image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Gallery Images</label>
            <input type="file" name="gallery_images[]" class="form-control" multiple>
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
