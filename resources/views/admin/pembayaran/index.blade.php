@extends('layouts.app')

@section('title', 'Kelola Pembayaran')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-indigo mb-0">Kelola Pembayaran</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Search Form --}}
        <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                            placeholder="Cari Nama atau ID Servis..." 
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="payment_status" class="form-select">
                        <option value="">Status Pembayaran</option>
                        <option value="belum_bayar" {{ request('payment_status') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="dp_lunas" {{ request('payment_status') == 'dp_lunas' ? 'selected' : '' }}>DP Lunas</option>
                        <option value="lunas" {{ request('payment_status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_method" class="form-select">
                        <option value="">Metode Pembayaran</option>
                        <option value="tunai" {{ request('payment_method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-calendar"></i></span>
                        <input type="date" name="date" class="form-control" 
                            value="{{ request('date') }}">
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
            </div>
        </form>

        <ul class="nav nav-tabs mb-3" id="pembayaranTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="verifikasi-tab" data-bs-toggle="tab" data-bs-target="#verifikasi" type="button" role="tab">
                    <i class="bi bi-check-circle me-2"></i>Verifikasi Pembayaran
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tagihan-tab" data-bs-toggle="tab" data-bs-target="#tagihan" type="button" role="tab">
                    <i class="bi bi-cash-coin me-2"></i>Tagihan Belum Lunas (Kasir)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pembayaranTabContent">
            <!-- Tab Verifikasi -->
            <div class="tab-pane fade show active" id="verifikasi" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Pelanggan</th>
                                        <th>Servis</th>
                                        <th>Info Pembayaran</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th class="text-end">Promo/Diskon</th>
                                        <th>Metode</th>
                                        <th>Bukti</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pembayarans as $p)
                                        @php
                                            $totalBayar = \App\Models\Pembayaran::where('servis_id', $p->servis_id)
                                                ->where('status', 'diterima')
                                                ->sum('jumlah');
                                            $estimasiBiaya = $p->servis->estimasi_biaya;
                                            $sisaTagihan = max(0, $estimasiBiaya - $totalBayar);
                                        @endphp
                                        <tr>
                                            <td>#{{ $p->id }}</td>
                                            <td>
                                                {{ $p->servis->booking->user->nama ?? '-' }}<br>
                                                <small class="text-muted">{{ $p->servis->booking->kendaraan->plat_nomor ?? '-' }}</small>
                                            </td>
                                            <td>
                                                Servis #{{ $p->servis_id }}<br>
                                                <small class="text-muted">Total: Rp {{ number_format($estimasiBiaya, 0, ',', '.') }}</small>
                                            </td>
                                            <td>
                                                @if($p->jenis_pembayaran === 'full')
                                                    <span class="badge bg-success">Lunas</span>
                                                @else
                                                    <small class="text-muted d-block">Dibayar: Rp {{ number_format($totalBayar, 0, ',', '.') }}</small>
                                                    @if($sisaTagihan > 0)
                                                        <small class="text-danger fw-bold">Kurang: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</small>
                                                    @else
                                                        <span class="badge bg-success">Lunas</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($p->jenis_pembayaran === 'dp') <span class="badge bg-warning">DP</span>
                                                @elseif($p->jenis_pembayaran === 'pelunasan') <span class="badge bg-info">Pelunasan</span>
                                                @else <span class="badge bg-success">Lunas</span> @endif
                                            </td>
                                            <td class="fw-bold">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                @if($p->kode_voucher)
                                                    <span class="badge bg-info-subtle text-info border border-info mb-1" title="Voucher: {{ $p->kode_voucher }}">
                                                        <i class="bi bi-ticket-perforated"></i> {{ $p->kode_voucher }}
                                                    </span><br>
                                                @endif
                                                @if($p->diskon_member > 0 || $p->diskon_voucher > 0 || $p->diskon_manual > 0)
                                                    <small class="text-success fw-bold">
                                                        -Rp {{ number_format($p->diskon_member + $p->diskon_voucher + $p->diskon_manual, 0, ',', '.') }}
                                                    </small>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                                            <td>
                                                @if($p->bukti_pembayaran)
                                                    <a href="{{ asset('storage/' . $p->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-image"></i> Lihat</a>
                                                @else <span class="text-muted">-</span> @endif
                                            </td>
                                            <td>
                                                @if($p->status === 'pending') <span class="badge bg-warning">Pending</span>
                                                @elseif($p->status === 'diterima') <span class="badge bg-success">Diterima</span>
                                                @else <span class="badge bg-danger">Ditolak</span> @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $p->id }}" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                @if($p->status === 'pending')
                                                    <form action="{{ route('admin.pembayaran.verify', $p->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="action" value="terima">
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Terima pembayaran ini?')"><i class="bi bi-check-circle"></i></button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $p->id }}"><i class="bi bi-x-circle"></i></button>
                                                    
                                                    <!-- Modal Tolak -->
                                                    <div class="modal fade" id="tolakModal{{ $p->id }}" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('admin.pembayaran.verify', $p->id) }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="action" value="tolak">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Tolak Pembayaran</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Alasan Penolakan</label>
                                                                            <textarea name="catatan" class="form-control" rows="3" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Modal Detail -->
                                                <div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Detail Servis #{{ $p->servis_id }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <h6>Pelanggan</h6>
                                                                        <p class="mb-1 fw-bold">{{ $p->servis->booking->user->nama ?? '-' }}</p>
                                                                        <p class="text-muted">{{ $p->servis->booking->user->no_hp ?? '-' }}</p>
                                                                    </div>
                                                                    <div class="col-md-6 text-md-end">
                                                                        <h6>Kendaraan</h6>
                                                                        <p class="mb-1 fw-bold">{{ $p->servis->booking->kendaraan->merk ?? '-' }} {{ $p->servis->booking->kendaraan->model ?? '' }}</p>
                                                                        <p class="text-muted">{{ $p->servis->booking->kendaraan->plat_nomor ?? '-' }}</p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <hr>
                                                                <h6><i class="bi bi-receipt me-2"></i>Bukti Pembayaran</h6>
                                                                @if($p->bukti_pembayaran)
                                                                    <div class="text-center mb-3">
                                                                        <img src="{{ asset('storage/' . $p->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid rounded border" style="max-height: 300px;">
                                                                        <div class="mt-2">
                                                                            <a href="{{ asset('storage/' . $p->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                                <i class="bi bi-download"></i> Unduh Bukti
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <p class="text-muted text-center py-3"><i class="bi bi-file-earmark-x"></i> Tidak ada bukti pembayaran (pembayaran manual)</p>
                                                                @endif
                                                                
                                                                <hr>
                                                                <h6><i class="bi bi-calculator me-2"></i>Rincian Biaya</h6>
                                                                <table class="table table-sm table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Item</th>
                                                                            <th class="text-center">Qty</th>
                                                                            <th class="text-end">Harga</th>
                                                                            <th class="text-end">Subtotal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- Jasa -->
                                                                        <tr>
                                                                            <td>Jasa: {{ $p->servis->booking->layanan->nama_layanan ?? 'Servis' }}</td>
                                                                            <td class="text-center">1</td>
                                                                            <td class="text-end">{{ number_format($p->servis->booking->layanan->harga ?? 0, 0, ',', '.') }}</td>
                                                                            <td class="text-end">{{ number_format($p->servis->booking->layanan->harga ?? 0, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                        <!-- Sparepart -->
                                                                        @foreach($p->servis->detailServis as $detail)
                                                                            <tr>
                                                                                <td>{{ $detail->stok->nama_barang ?? 'Sparepart' }}</td>
                                                                                <td class="text-center">{{ $detail->jumlah }}</td>
                                                                                <td class="text-end">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                                                                <td class="text-end">{{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot class="fw-bold">
                                                                        <tr>
                                                                            <td colspan="3" class="text-end">Subtotal Estimasi</td>
                                                                            <td class="text-end">Rp {{ number_format($p->servis->estimasi_biaya, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                        @if($p->diskon_member > 0)
                                                                            <tr class="text-success">
                                                                                <td colspan="3" class="text-end">
                                                                                    Diskon Member ({{ $p->servis->booking->user->membershipTier->nama_level ?? 'Silver' }})
                                                                                </td>
                                                                                <td class="text-end">- Rp {{ number_format($p->diskon_member, 0, ',', '.') }}</td>
                                                                            </tr>
                                                                        @endif
                                                                        @if($p->diskon_voucher > 0)
                                                                            <tr class="text-info">
                                                                                <td colspan="3" class="text-end">Voucher: <strong>{{ $p->kode_voucher }}</strong></td>
                                                                                <td class="text-end">- Rp {{ number_format($p->diskon_voucher, 0, ',', '.') }}</td>
                                                                            </tr>
                                                                        @endif
                                                                        @if($p->diskon_manual > 0)
                                                                            <tr class="text-warning">
                                                                                <td colspan="3" class="text-end">Potongan Manual: <em>{{ $p->alasan_diskon_manual }}</em></td>
                                                                                <td class="text-end">- Rp {{ number_format($p->diskon_manual, 0, ',', '.') }}</td>
                                                                            </tr>
                                                                        @endif
                                                                        <tr class="table-primary">
                                                                            <td colspan="3" class="text-end">Grand Total Tagihan</td>
                                                                            <td class="text-end text-primary">Rp {{ number_format($p->grand_total ?: $p->servis->estimasi_biaya, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                        <tr class="bg-light">
                                                                            <td colspan="3" class="text-end">Pembayaran Ini</td>
                                                                            <td class="text-end">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="10" class="text-center text-muted py-4">Belum ada pembayaran.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Tagihan (Kasir) -->
            <div class="tab-pane fade" id="tagihan" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID Servis</th>
                                        <th>Pelanggan</th>
                                        <th>Kendaraan</th>
                                        <th>Status Servis</th>
                                        <th>Total Biaya</th>
                                        <th>Sudah Dibayar</th>
                                        <th>Sisa Tagihan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tagihanBelumLunas as $s)
                                        @php
                                            $totalBayar = \App\Models\Pembayaran::where('servis_id', $s->id)
                                                ->where('status', 'diterima')
                                                ->sum('jumlah');
                                            $sisaTagihan = max(0, $s->estimasi_biaya - $totalBayar);
                                        @endphp
                                        <tr>
                                            <td>#{{ $s->id }}</td>
                                            <td>{{ $s->booking->user->nama ?? '-' }}</td>
                                            <td>{{ $s->booking->kendaraan->plat_nomor ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $s->status == 'selesai' ? 'success' : 'primary' }}">
                                                    {{ ucfirst($s->status) }}
                                                </span>
                                            </td>
                                            <td>Rp {{ number_format($s->estimasi_biaya, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                                            <td class="text-danger fw-bold">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#detailTagihanModal{{ $s->id }}" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <a href="{{ route('admin.pembayaran.create', $s->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-cash"></i> Bayar
                                                </a>

                                                <!-- Modal Detail -->
                                                <div class="modal fade" id="detailTagihanModal{{ $s->id }}" tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Detail Servis #{{ $s->id }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <h6>Pelanggan</h6>
                                                                        <p class="mb-1 fw-bold">{{ $s->booking->user->nama ?? '-' }}</p>
                                                                        <p class="text-muted">{{ $s->booking->user->no_hp ?? '-' }}</p>
                                                                    </div>
                                                                    <div class="col-md-6 text-md-end">
                                                                        <h6>Kendaraan</h6>
                                                                        <p class="mb-1 fw-bold">{{ $s->booking->kendaraan->merk ?? '-' }} {{ $s->booking->kendaraan->model ?? '' }}</p>
                                                                        <p class="text-muted">{{ $s->booking->kendaraan->plat_nomor ?? '-' }}</p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <hr>
                                                                <h6><i class="bi bi-receipt me-2"></i>Bukti Pembayaran Terakhir</h6>
                                                                @php
                                                                    $latestPayment = $s->pembayarans()->where('status', 'diterima')->latest()->first();
                                                                @endphp
                                                                @if($latestPayment && $latestPayment->bukti_pembayaran)
                                                                    <div class="text-center mb-3">
                                                                        <img src="{{ asset('storage/' . $latestPayment->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid rounded border" style="max-height: 300px;">
                                                                        <div class="mt-2">
                                                                            <a href="{{ asset('storage/' . $latestPayment->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-primary">
                                                                                <i class="bi bi-download"></i> Unduh Bukti
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <p class="text-muted text-center py-3"><i class="bi bi-file-earmark-x"></i> Belum ada bukti pembayaran</p>
                                                                @endif
                                                                
                                                                <hr>
                                                                <h6><i class="bi bi-calculator me-2"></i>Rincian Biaya</h6>
                                                                <table class="table table-sm table-bordered">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Item</th>
                                                                            <th class="text-center">Qty</th>
                                                                            <th class="text-end">Harga</th>
                                                                            <th class="text-end">Subtotal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <!-- Jasa -->
                                                                        <tr>
                                                                            <td>Jasa: {{ $s->booking->layanan->nama_layanan ?? 'Servis' }}</td>
                                                                            <td class="text-center">1</td>
                                                                            <td class="text-end">{{ number_format($s->booking->layanan->harga ?? 0, 0, ',', '.') }}</td>
                                                                            <td class="text-end">{{ number_format($s->booking->layanan->harga ?? 0, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                        <!-- Sparepart -->
                                                                        @foreach($s->detailServis as $detail)
                                                                            <tr>
                                                                                <td>{{ $detail->stok->nama_barang ?? 'Sparepart' }}</td>
                                                                                <td class="text-center">{{ $detail->jumlah }}</td>
                                                                                <td class="text-end">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                                                                <td class="text-end">{{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot class="fw-bold">
                                                                        <tr>
                                                                            <td colspan="3" class="text-end">Total Estimasi</td>
                                                                            <td class="text-end">Rp {{ number_format($s->estimasi_biaya, 0, ',', '.') }}</td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada tagihan belum lunas.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection