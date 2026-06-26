@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-semibold text-dark mb-0">
            <i class="fas fa-envelope-open-text me-2 text-secondary"></i> Daftar Pesan Masuk
        </h2>
        <div class="btn btn-primary disabled rounded-3 px-3 py-2 text-white border-0" style="background-color: #0d6efd;">
            <i class="fas fa-inbox me-1"></i> Total: {{ $messages->total() }} Pesan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr class="text-dark border-bottom">
                            <th class="px-4 py-3 fw-bold" style="width: 25%;">Pengirim</th>
                            <th class="py-3 fw-bold" style="width: 40%;">Pesan</th>
                            <th class="py-3 fw-bold" style="width: 15%;">Tanggal</th>
                            <th class="py-3 fw-bold" style="width: 10%;">Status</th>
                            <th class="px-4 py-3 fw-bold text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $msg)
                        <tr class="border-bottom">
                            <td class="px-4 py-3">
                                <div class="fw-bold text-dark mb-1">{{ $msg->name }}</div>
                                <div class="d-flex flex-column gap-1 small">
                                    <span class="text-success fw-medium">
                                        <i class="fab fa-whatsapp me-1"></i>{{ $msg->whatsapp }}
                                    </span>
                                    @if($msg->email)
                                        <span class="text-muted">
                                            <i class="far fa-envelope me-1"></i>{{ $msg->email }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="py-3 text-secondary text-truncate" style="max-width: 320px;">
                                <strong class="text-dark d-block mb-1">{{ $msg->subject ?? 'Tanpa Subjek' }}</strong>
                                {{ Str::limit($msg->message, 85) }}
                            </td>
                            
                            <td class="py-3 text-muted small">
                                {{ $msg->created_at->diffForHumans() }}
                            </td>

                            <td class="py-3">
                                @if($msg->is_read)
                                    <span class="badge bg-light text-secondary border px-2 py-1 rounded-2 fw-normal">Dibaca</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-2 fw-normal">Baru</span>
                                @endif
                            </td>
                            
                            <td class="px-4 py-3 text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.messages.show', $msg->id) }}" class="btn btn-sm btn-outline-info p-2 rounded-3 d-flex align-items-center justify-content-center" title="Buka Pesan" style="width: 32px; height: 32px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @php
                                        $formatWa = $msg->whatsapp;
                                        if (str_starts_with($formatWa, '0')) {
                                            $formatWa = '62' . substr($formatWa, 1);
                                        }
                                        $quickText = "Halo " . $msg->name . ", terima kasih telah menghubungi KostHeBrew. Kami telah menerima pesan Anda mengenai '" . $msg->subject . "'.";
                                    @endphp
                                    <a href="https://api.whatsapp.com/send?phone={{ $formatWa }}&text={{ urlencode($quickText) }}" target="_blank" class="btn btn-sm btn-outline-success p-2 rounded-3 d-flex align-items-center justify-content-center" title="Chat WhatsApp" style="width: 32px; height: 32px;">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>

                                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan dari {{ $msg->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger p-2 rounded-3 d-flex align-items-center justify-content-center" title="Hapus Pesan" style="width: 32px; height: 32px;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fs-2 mb-3 d-block text-secondary opacity-50"></i> Kotak masuk pesan masih kosong.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-end mt-4">
        {{ $messages->links() }}
    </div>
</div>
@endsection