@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container-fluid px-4">
    <div class="user-management-header mb-4"
        style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                        class="bi bi-file-earmark-text me-2"></i>Laporan Transaksi</h2>
                <p class="text-white-50 m-0 mt-2">Rekapitulasi pemasukan dan pengeluaran bengkel</p>
            </div>
            <div class="d-flex gap-3 mt-3 mt-md-0">
                <div class="bg-white bg-opacity-10 p-3 rounded-4 border border-white border-opacity-10 d-none d-lg-block">
                    <small class="text-white-50 d-block mb-1">Total Pemasukan</small>
                    <span class="text-white fw-bold fs-5">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                </div>
                <div class="bg-white bg-opacity-10 p-3 rounded-4 border border-white border-opacity-10 d-none d-lg-block">
                    <small class="text-white-50 d-block mb-1">Total Pengeluaran</small>
                    <span class="text-white fw-bold fs-5">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards for Mobile --}}
    <div class="row g-3 mb-4 d-lg-none">
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4" style="background: rgba(67, 233, 123, 0.1);">
                <div class="card-body p-3">
                    <small class="text-secondary d-block">Pemasukan</small>
                    <span class="fw-bold text-success small">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-0 shadow-sm rounded-4" style="background: rgba(255, 117, 143, 0.1);">
                <div class="card-body p-3">
                    <small class="text-secondary d-block">Pengeluaran</small>
                    <span class="fw-bold text-danger small">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card-modern">
        <div class="card-body p-0">
            {{-- Filter Section --}}
            <div class="px-4 py-4 border-bottom bg-light bg-opacity-50">
                <form action="{{ route('admin.transaksi') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label small fw-bold text-secondary">Cari Transaksi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" 
                                    placeholder="Keterangan, User, No Polisi..." value="{{ request('search') }}" style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small fw-bold text-secondary">Dari Tanggal</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" style="border-radius: 10px;">
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small fw-bold text-secondary">Sampai Tanggal</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" style="border-radius: 10px;">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label small fw-bold text-secondary">Jenis</label>
                            <select name="jenis_transaksi" class="form-select" style="border-radius: 10px;">
                                <option value="">Semua Jenis</option>
                                <option value="pemasukan" {{ request('jenis_transaksi') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="pengeluaran" {{ request('jenis_transaksi') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex gap-2 mt-md-0">
                            <button type="submit" class="btn btn-primary px-4 fw-bold flex-grow-1" style="border-radius: 10px;">
                                <i class="bi bi-filter me-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.transaksi') }}" class="btn btn-light px-4 fw-bold border" style="border-radius: 10px;">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Waktu</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>User</th>
                            <th class="text-end">Diskon</th>
                            <th class="text-end">Total</th>
                            <th class="text-center pe-4">Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $t)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold text-dark">{{ $t->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $t->created_at->format('H:i') }} WIB</small>
                                </td>
                                <td>
                                    @if($t->jenis_transaksi == 'pemasukan')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3" style="border-radius: 8px;">
                                            <i class="bi bi-arrow-down-left me-1"></i>Pemasukan
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3" style="border-radius: 8px;">
                                            <i class="bi bi-arrow-up-right me-1"></i>Pengeluaran
                                        </span>
                                    @endif
                                    <div class="mt-1">
                                        @if($t->sumber == 'servis')
                                            <small class="badge bg-primary-subtle text-primary border border-primary-subtle py-0">Servis</small>
                                        @elseif($t->sumber == 'belanja_stok')
                                            <small class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle py-0">Belanja Stok</small>
                                        @else
                                            <small class="badge bg-secondary-subtle text-secondary border border-secondary-subtle py-0">{{ ucfirst($t->sumber) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $t->keterangan }}</span>
                                    @if($t->stok)
                                        <div class="small text-muted mt-1"><i class="bi bi-box-seam me-1"></i>{{ $t->stok->nama_barang }} ({{ $t->jumlah }} {{ $t->stok->satuan }})</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                            <i class="bi bi-person text-secondary"></i>
                                        </div>
                                        <span class="small fw-semibold">{{ $t->user->nama ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    @if($t->kode_voucher)
                                        <span class="badge bg-info-subtle text-info border border-info-subtle small mb-1">
                                            <i class="bi bi-ticket-perforated me-1"></i>{{ $t->kode_voucher }}
                                        </span>
                                    @endif
                                    @php $totalDisc = $t->diskon_member + $t->diskon_voucher + $t->diskon_manual; @endphp
                                    @if($totalDisc > 0)
                                        <div class="text-success small fw-bold">-Rp {{ number_format($totalDisc, 0, ',', '.') }}</div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold {{ $t->jenis_transaksi == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                        {{ $t->jenis_transaksi == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($t->total, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}"
                                        class="btn btn-sm btn-outline-primary" style="border-radius: 8px;" data-bs-toggle="tooltip" title="Lihat Detail Transaksi">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-cash-stack fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Tidak ada data transaksi ditemukan sesuai kriteria.</p>
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