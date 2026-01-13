@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Voucher</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Voucher</li>
        </ol>
        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Buat Voucher Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-ticket-perforated me-2"></i>Daftar Kode Voucher</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nilai</th>
                            <th>Min. Transaksi</th>
                            <th>Kuota</th>
                            <th>Masa Berlaku</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $v)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace fs-6">{{ $v->kode }}</span>
                            </td>
                            <td>
                                @if($v->tipe_diskon == 'nominal')
                                    Rp {{ number_format($v->nilai, 0, ',', '.') }}
                                @else
                                    {{ $v->nilai }}%
                                @endif
                            </td>
                            <td>Rp {{ number_format($v->min_transaksi, 0, ',', '.') }}</td>
                            <td>
                                @if($v->kuota > 0)
                                    <span class="badge bg-info">{{ $v->kuota }}</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td>
                                <small class="d-block text-muted">Mulai: {{ $v->tgl_mulai ? $v->tgl_mulai->format('d M Y') : '-' }}</small>
                                <small class="d-block text-muted">Sampai: {{ $v->tgl_berakhir ? $v->tgl_berakhir->format('d M Y') : '-' }}</small>
                            </td>
                            <td>
                                @if($v->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.vouchers.edit', $v->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.vouchers.destroy', $v->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-confirm" data-message="Yakin ingin menghapus voucher dengan kode '{{ $v->kode }}'?">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-ticket-detailed display-6 mb-3 d-block text-secondary opacity-50"></i>
                                Belum ada voucher yang dibuat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
