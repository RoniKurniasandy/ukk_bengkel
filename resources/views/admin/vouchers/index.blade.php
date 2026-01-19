@extends('layouts.app')

@section('title', 'Manajemen Voucher')

@section('content')
<div class="container-fluid px-4">
    <div class="user-management-header mb-4"
        style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                        class="bi bi-ticket-perforated me-2"></i>Manajemen Voucher</h2>
                <p class="text-white-50 m-0 mt-2">Daftar kode promo dan diskon bengkel</p>
            </div>
            <a href="{{ route('admin.vouchers.create') }}"
                class="btn btn-light text-primary fw-bold mt-3 mt-md-0 shadow-sm" style="border-radius: 10px;">
                <i class="bi bi-plus-circle me-2"></i>Buat Voucher Baru
            </a>
        </div>
    </div>


    <div class="card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Kode</th>
                            <th>Nilai</th>
                            <th>Min. Transaksi</th>
                            <th>Kuota</th>
                            <th>Masa Berlaku</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $v)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge badge-modern font-monospace fs-6" style="background: rgba(102, 126, 234, 0.1); color: #667eea; border: 1px dashed #667eea;">
                                        {{ $v->kode }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">
                                        @if($v->tipe_diskon == 'nominal')
                                            Rp {{ number_format($v->nilai, 0, ',', '.') }}
                                        @else
                                            {{ $v->nilai }}%
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">Rp {{ number_format($v->min_transaksi, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    @if($v->kuota > 0)
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-3" style="border-radius: 8px;">
                                            <i class="bi bi-people me-1"></i>{{ $v->kuota }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3" style="border-radius: 8px;">
                                            Habis
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="text-muted"><i class="bi bi-calendar-event me-1"></i>{{ $v->tgl_mulai ? $v->tgl_mulai->format('d M Y') : '-' }}</div>
                                        <div class="text-muted"><i class="bi bi-calendar-x me-1"></i>{{ $v->tgl_berakhir ? $v->tgl_berakhir->format('d M Y') : '-' }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($v->is_active)
                                        <span class="badge badge-modern" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">Aktif</span>
                                    @else
                                        <span class="badge badge-modern bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.vouchers.edit', $v->id) }}"
                                        class="btn btn-sm btn-outline-warning me-1" style="border-radius: 8px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.vouchers.destroy', $v->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-confirm"
                                            style="border-radius: 8px;" data-message="Yakin ingin menghapus voucher '{{ $v->kode }}'?">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-ticket-detailed fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada data voucher.</p>
                                    </div>
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
