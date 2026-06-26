@extends('layouts.app')

@section('title', 'Transaksi Pemilik - Kost HeBrew')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Daftar Transaksi Pemilik</h1>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kost</th>
                            <th>Kamar</th>
                            <th>Penyewa</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($transaksi->penyewa->kost)->name }}</td>
                            <td>{{ optional($transaksi->kamar)->nomor_kamar }}</td>
                            <td>{{ optional($transaksi->penyewa->user)->name ?? 'Tidak dikenal' }}</td>
                            <td>Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($transaksi->status) }}</td>
                            <td>{{ optional($transaksi->tanggal_bayar)->format('d M Y') ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
