@extends('layouts.frontend')

@section('title', 'Riwayat Pembayaran - Kost HeBrew')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4"><i class="fas fa-history me-2"></i> Riwayat Pembayaran</h2>
            
            @if(isset($warning))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $warning }}
                </div>
            @endif

            @if(isset($payments) && $payments->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Kost</th>
                                        <th>Kamar</th>
                                        <th>Jumlah</th>
                                        <th>Metode</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td class="fw-bold">{{ $payment->order_id }}</td>
                                        <td>{{ $payment->kamar->kost->name ?? '-' }}</td>
                                        <td>Kamar No. {{ $payment->kamar->nomor_kamar ?? '-' }}</td>
                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td>{{ ucfirst($payment->metode_pembayaran) }}</td>
                                        <td>
                                            @switch($payment->status)
                                                @case('success')
                                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Lunas</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Menunggu</span>
                                                    @break
                                                @case('failed')
                                                    <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Gagal</span>
                                                    @break
                                                @case('expired')
                                                    <span class="badge bg-secondary"><i class="fas fa-hourglass me-1"></i>Kedaluwarsa</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-info">{{ $payment->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $payment->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('payment.status', $payment->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Anda belum memiliki riwayat pembayaran.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection