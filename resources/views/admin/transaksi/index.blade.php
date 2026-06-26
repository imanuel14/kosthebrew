@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Transaksi</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pembayaran Kost</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penyewa</th>
                            <th>Kamar</th>
                            <th>Periode</th>
                            <th>Jumlah</th>
                            <th>Tanggal Bayar</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $transaksi)
                            <tr>
                                <td>{{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $transaksi->penyewa->user->name ?? 'N/A' }}</strong>
                                </td>
                                <td>
                                    {{ $transaksi->kamar->nomor_kamar ?? 'Kamar #' . $transaksi->kamar_id }}
                                </td>
                                <td>{{ date('F', mktime(0, 0, 0, $transaksi->bulan, 10)) }} {{ $transaksi->tahun }}</td>
                                <td>Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</td>
                                <td>{{ $transaksi->tanggal_bayar }}</td>
                                <td><span class="badge badge-info">{{ strtoupper($transaksi->metode_pembayaran) }}</span></td>
                                <td>
                                    @if($transaksi->status == 'lunas')
                                        <span class="badge badge-success">Lunas</span>
                                    @else
                                        <span class="badge badge-warning">{{ ucfirst($transaksi->status) }}</span>
                                    @endif
                                </td>
                                <td><small>{{ $transaksi->keterangan }}</small></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data transaksi yang tercatat.</td>
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
