@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Kost Saya</h1>
    <a href="{{ route('pemilik.kost.create') }}" class="btn btn-primary mb-3">Tambah Kost</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($kosts as $kost)
            <div class="col-md-4">
                <div class="card mb-3">
                    @if($kost->main_image)
                        <img src="{{ Storage::url($kost->main_image) }}" class="card-img-top" alt="{{ $kost->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $kost->title }}</h5>
                        <p class="card-text">{{ $kost->address }}</p>
                        <a href="{{ route('pemilik.kost.edit', $kost->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pemilik.kost.destroy', $kost->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kost ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
