@extends('layouts.app')

@section('title', 'Riwayat Pembayaran Saya')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-file-invoice-dollar me-2 text-primary"></i>Riwayat Pembayaran</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            {{-- PENTING: Gunakan $payments, bukan $users --}}
            @if($payments && $payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Invoice ID</th>
                                <th>Nama Kost</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Ganti $users menjadi $payments --}}
                            @foreach($payments as $index => $payment)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration }}</td>
                                <td>{{ $payment->order_id }}</td>
                                <td>{{ $payment->kamar->kost->name ?? 'N/A' }}</td>
                                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $payment->status == 'success' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer bg-white py-3 d-flex justify-content-center">
                    {{-- Ganti $users menjadi $payments --}}
                    {{ $payments->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted">Belum ada riwayat pembayaran yang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection