@extends('layouts.app')

@section('title', 'Kelola Pembayaran')

@section('content')
<div class="container-fluid px-4">
    <div class="user-management-header mb-4"
        style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                        class="bi bi-credit-card-2-front me-2"></i>Kelola Pembayaran</h2>
                <p class="text-white-50 m-0 mt-2">Verifikasi bukti pembayaran dan manajemen tagihan kasir</p>
            </div>
        </div>
    </div>


    <div class="card-modern mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.pembayaran.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Cari Pelanggan/ID</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-start-0" 
                                placeholder="Nama atau ID Servis..." value="{{ request('search') }}" style="border-radius: 0 10px 10px 0;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">Status</label>
                        <select name="payment_status" class="form-select" style="border-radius: 10px;">
                            <option value="">Semua Status</option>
                            <option value="belum_bayar" {{ request('payment_status') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="dp_lunas" {{ request('payment_status') == 'dp_lunas' ? 'selected' : '' }}>DP Lunas</option>
                            <option value="lunas" {{ request('payment_status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">Metode</label>
                        <select name="payment_method" class="form-select" style="border-radius: 10px;">
                            <option value="">Semua Metode</option>
                            <option value="tunai" {{ request('payment_method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Tanggal</label>
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}" style="border-radius: 10px;">
                    </div>
                    <div class="col-md-2 d-flex gap-2 align-items-end">
                        <button type="submit" class="btn btn-primary fw-bold w-100" style="border-radius: 10px;"><i class="bi bi-funnel me-2"></i>Filter</button>
                        <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-light border fw-bold" style="border-radius: 10px;"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-modern">
        <div class="card-header bg-white p-0 border-bottom">
            <ul class="nav nav-tabs nav-fill border-0" id="pembayaranTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active py-3 fw-bold border-0 border-bottom" id="verifikasi-tab" data-bs-toggle="tab" data-bs-target="#verifikasi" type="button" role="tab" style="border-radius: 16px 16px 0 0;">
                        <i class="bi bi-shield-check me-2 text-primary"></i>Verifikasi Pembayaran
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-3 fw-bold border-0 border-bottom" id="tagihan-tab" data-bs-toggle="tab" data-bs-target="#tagihan" type="button" role="tab" style="border-radius: 16px 16px 0 0;">
                        <i class="bi bi-cash-stack me-2 text-success"></i>Tagihan (Kasir)
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content" id="pembayaranTabContent">
                <!-- Tab Verifikasi -->
                <div class="tab-pane fade show active" id="verifikasi" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Servis</th>
                                    <th>Pelanggan</th>
                                    <th>Info Bayar</th>
                                    <th>Jumlah</th>
                                    <th>Bukti</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembayarans as $p)
                                    @php
                                        $totalBayar = \App\Models\Pembayaran::where('servis_id', $p->servis_id)->where('status', 'diterima')->sum('jumlah');
                                        $sisaTagihan = max(0, $p->servis->estimasi_biaya - $totalBayar);
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-primary">#{{ $p->servis_id }}</div>
                                            <small class="text-muted">{{ $p->servis->booking->layanan->nama_layanan ?? 'Servis' }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $p->servis->booking->user->nama ?? '-' }}</div>
                                            <small class="text-muted">{{ $p->servis->booking->kendaraan->plat_nomor ?? '-' }}</small>
                                        </td>
                                        <td>
                                            @if($p->jenis_pembayaran === 'dp') <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2">DP</span>
                                            @elseif($p->jenis_pembayaran === 'pelunasan') <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2">Pelunasan</span>
                                            @else <span class="badge bg-success-subtle text-success border border-success-subtle px-2">Lunas</span> @endif
                                            <div class="mt-1 small">
                                                <i class="bi bi-coin me-1"></i>{{ ucfirst($p->metode_pembayaran) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</div>
                                            @if($p->diskon_member + $p->diskon_voucher + $p->diskon_manual > 0)
                                                <small class="text-success fw-bold">Disc: -Rp {{ number_format($p->diskon_member + $p->diskon_voucher + $p->diskon_manual, 0, ',', '.') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->bukti_pembayaran)
                                                <a href="{{ asset('storage/' . $p->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-light border" style="border-radius: 6px;">
                                                    <i class="bi bi-image text-primary"></i>
                                                </a>
                                            @else <span class="text-muted small">Manual</span> @endif
                                        </td>
                                        <td>
                                            @if($p->status === 'pending') <span class="badge badge-modern bg-warning">Pending</span>
                                            @elseif($p->status === 'diterima') <span class="badge badge-modern" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">Diterima</span>
                                            @else <span class="badge badge-modern bg-danger">Ditolak</span> @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-1">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $p->id }}" style="border-radius: 8px;">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @if($p->status === 'pending')
                                                    <form action="{{ route('admin.pembayaran.verify', $p->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="terima">
                                                        <button type="submit" class="btn btn-sm btn-success" style="border-radius: 8px;" onclick="return confirm('Terima pembayaran ini?')"><i class="bi bi-check-lg"></i></button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-danger" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $p->id }}"><i class="bi bi-x-lg"></i></button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada antrean verifikasi pembayaran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Tagihan -->
                <div class="tab-pane fade" id="tagihan" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Servis</th>
                                    <th>Pelanggan</th>
                                    <th>Total Biaya</th>
                                    <th>Sudah Bayar</th>
                                    <th>Sisa Tagihan</th>
                                    <th>Status Servis</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tagihanBelumLunas as $s)
                                    @php
                                        $totalBayar = \App\Models\Pembayaran::where('servis_id', $s->id)->where('status', 'diterima')->sum('jumlah');
                                        $sisaTagihan = max(0, $s->estimasi_biaya - $totalBayar);
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold">#{{ $s->id }}</div>
                                            <small class="text-muted">{{ $s->booking->tanggal_booking }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $s->booking->user->nama ?? '-' }}</div>
                                            <small class="text-muted">{{ $s->booking->kendaraan->plat_nomor ?? '-' }}</small>
                                        </td>
                                        <td><span class="text-dark fw-bold">Rp {{ number_format($s->estimasi_biaya, 0, ',', '.') }}</span></td>
                                        <td><span class="text-success fw-bold">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span></td>
                                        <td><span class="text-danger fw-bold">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</span></td>
                                        <td>
                                            <span class="badge bg-{{ $s->status == 'selesai' ? 'success' : 'primary' }}-subtle text-{{ $s->status == 'selesai' ? 'success' : 'primary' }}-emphasis border border-{{ $s->status == 'selesai' ? 'success' : 'primary' }}-subtle px-3" style="border-radius: 8px;">
                                                {{ ucfirst($s->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-1">
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailTagihanModal{{ $s->id }}" style="border-radius: 8px;">
                                                    <i class="bi bi-info-circle"></i>
                                                </button>
                                                <a href="{{ route('admin.pembayaran.create', $s->id) }}" class="btn btn-sm btn-primary fw-bold" style="border-radius: 8px;">
                                                    <i class="bi bi-cash-coin me-1"></i>Bayar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center py-5 text-muted">Tidak ada tagihan tertunggak.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALS SECTION - I'll need to make sure the modals are still functional --}}
@foreach($pembayarans as $p)
    <!-- Tolak Modal -->
    <div class="modal fade" id="tolakModal{{ $p->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                <form action="{{ route('admin.pembayaran.verify', $p->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="tolak">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold text-danger"><i class="bi bi-x-circle me-2"></i>Tolak Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Alasan Penolakan</label>
                            <textarea name="catatan" class="form-control" rows="3" required placeholder="Misal: Bukti transfer tidak jelas atau nominal tidak sesuai..." style="border-radius: 10px;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                        <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 10px;">Tolak Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-indigo"><i class="bi bi-receipt me-2"></i>Detail Pembayaran #{{ $p->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded-4 h-100">
                                <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Informasi Pelanggan</h6>
                                <p class="mb-1"><strong>Nama:</strong> {{ $p->servis->booking->user->nama ?? '-' }}</p>
                                <p class="mb-1"><strong>Telepon:</strong> {{ $p->servis->booking->user->no_hp ?? '-' }}</p>
                                <p class="mb-0"><strong>Kendaraan:</strong> {{ $p->servis->booking->kendaraan->merk ?? '' }} {{ $p->servis->booking->kendaraan->model ?? '' }} ({{ $p->servis->booking->kendaraan->plat_nomor ?? '-' }})</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded-4 h-100">
                                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Bukti Pembayaran</h6>
                                @if($p->bukti_pembayaran)
                                    <div class="text-center">
                                        <img src="{{ asset('storage/' . $p->bukti_pembayaran) }}" class="rounded shadow-sm border w-100" style="max-height: 200px; object-fit: contain;">
                                        <a href="{{ asset('storage/' . $p->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-primary mt-2 w-100" style="border-radius: 8px;">
                                            <i class="bi bi-zoom-in me-1"></i>Perbesar Gambar
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-cash fs-1"></i>
                                        <p class="mb-0 mt-2">Pembayaran Tunai / Manual</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-calculator me-2"></i>Rincian Tagihan</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Keterangan</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Estimasi Total Biaya Servis</td>
                                        <td class="text-end">Rp {{ number_format($p->servis->estimasi_biaya, 0, ',', '.') }}</td>
                                    </tr>
                                    @if($p->diskon_member > 0)
                                        <tr class="text-success">
                                            <td>Diskon Member ({{ $p->servis->booking->user->membershipTier->nama_level ?? 'Silver' }})</td>
                                            <td class="text-end">-Rp {{ number_format($p->diskon_member, 0, ',', '.') }}</td>
                                        </tr>
                                    @endif
                                    @if($p->diskon_voucher > 0)
                                        <tr class="text-info">
                                            <td>Voucher: {{ $p->kode_voucher }}</td>
                                            <td class="text-end">-Rp {{ number_format($p->diskon_voucher, 0, ',', '.') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="fw-bold">
                                    <tr class="table-primary">
                                        <td>TOTAL YANG HARUS DIBAYAR (ESTIMASI)</td>
                                        <td class="text-end">Rp {{ number_format($p->servis->estimasi_biaya, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td>JUMLAH PEMBAYARAN INI ({{ strtoupper($p->jenis_pembayaran) }})</td>
                                        <td class="text-end">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach($tagihanBelumLunas as $s)
    <!-- Modal Detail Tagihan -->
    <div class="modal fade" id="detailTagihanModal{{ $s->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-success"><i class="bi bi-info-circle me-2"></i>Detail Tagihan #{{ $s->id }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="bg-light p-3 rounded-4 mb-3">
                        <p class="mb-1"><strong>Pelanggan:</strong> {{ $s->booking->user->nama ?? '-' }}</p>
                        <p class="mb-1"><strong>Layanan:</strong> {{ $s->booking->layanan->nama_layanan ?? 'Servis' }}</p>
                        <p class="mb-0"><strong>Status Saat Ini:</strong> <span class="badge bg-primary">{{ ucfirst($s->status) }}</span></p>
                    </div>
                    
                    <h6 class="fw-bold mb-2">Ringkasan Biaya</h6>
                    <ul class="list-group list-group-flush small border rounded-3 mb-0">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total Estimasi</span>
                            <span class="fw-bold">Rp {{ number_format($s->estimasi_biaya, 0, ',', '.') }}</span>
                        </li>
                        @php
                            $totalDiterima = \App\Models\Pembayaran::where('servis_id', $s->id)->where('status', 'diterima')->sum('jumlah');
                        @endphp
                        <li class="list-group-item d-flex justify-content-between text-success">
                            <span>Sudah Dibayar</span>
                            <span class="fw-bold">Rp {{ number_format($totalDiterima, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between text-danger bg-danger bg-opacity-10 py-2 border-top">
                            <span>Sisa Tagihan</span>
                            <span class="fw-bold fs-6">Rp {{ number_format(max(0, $s->estimasi_biaya - $totalDiterima), 0, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold w-100" data-bs-dismiss="modal" style="border-radius: 10px;">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection