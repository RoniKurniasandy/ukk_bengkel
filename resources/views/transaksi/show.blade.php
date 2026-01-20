@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                                <p class="text-muted mb-0">Jl. Raya Bengkel No. 123</p>
                                <p class="text-muted">Telp: 0812-3456-7890</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h5 class="fw-bold">INVOICE</h5>
                                <p class="mb-0">Tanggal: {{ $transaksi->created_at->format('d M Y H:i') }}</p>
                                <p class="mb-0">Kasir: {{ $transaksi->user->nama ?? 'Sistem' }}</p>
                                <span
                                    class="badge bg-{{ $transaksi->jenis_transaksi == 'pemasukan' ? 'success' : 'danger' }} fs-6 mt-2">
                                    {{ ucfirst($transaksi->jenis_transaksi) }}
                                </span>
                            </div>
                        </div>

                                <!-- Info Pelanggan (Jika Servis) -->
                        @if($transaksi->servis)
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-uppercase text-muted">Pelanggan</h6>
                                    <p class="fw-bold mb-0">{{ $transaksi->servis->booking?->user?->nama ?? $transaksi->user->nama ?? '-' }}</p>
                                    <p class="mb-0">{{ $transaksi->servis->booking?->user?->no_hp ?? $transaksi->user->no_hp ?? '-' }}</p>
                                    <p class="mb-0">{{ $transaksi->servis->booking?->user?->alamat ?? $transaksi->user->alamat ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h6 class="fw-bold text-uppercase text-muted">Kendaraan</h6>
                                    <p class="fw-bold mb-0">{{ $transaksi->servis->booking?->kendaraan?->merk ?? '-' }}
                                        {{ $transaksi->servis->booking?->kendaraan?->model ?? '' }}</p>
                                    <p class="mb-0">{{ $transaksi->servis->booking?->kendaraan?->plat_nomor ?? '-' }}</p>
                                </div>
                            </div>
                            
                            <!-- Info Mekanik -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="alert alert-info d-flex align-items-center">
                                        <i class="bi bi-wrench fs-4 me-3"></i>
                                        <div>
                                            <strong>Mekanik yang Mengerjakan:</strong>
                                            {{ $transaksi->servis->mekanik?->nama ?? 'Belum ditugaskan' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Tabel Rincian -->
                        <div class="table-responsive mb-4">
                            <table class="table table-striped">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($transaksi->servis)
                                        <!-- Biaya Jasa -->
                                        <tr>
                                            <td>Jasa Servis
                                                ({{ $transaksi->servis->booking?->layanan?->nama_layanan ?? 'Servis Umum' }})</td>
                                            <td class="text-center">1</td>
                                            <td class="text-end">Rp
                                                {{ number_format($transaksi->servis->booking?->layanan?->harga ?? $transaksi->servis->estimasi_biaya ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">Rp
                                                {{ number_format($transaksi->servis->booking?->layanan?->harga ?? $transaksi->servis->estimasi_biaya ?? 0, 0, ',', '.') }}
                                            </td>
                                        </tr>

                                        <!-- Sparepart -->
                                        @foreach($transaksi->servis->detailServis as $detail)
                                            <tr>
                                                <td>{{ $detail->stok->nama_barang ?? 'Sparepart' }}</td>
                                                <td class="text-center">{{ $detail->jumlah }}</td>
                                                <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                                <td class="text-end">Rp
                                                    {{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    @elseif($transaksi->stok)
                                        <!-- Pembelian Stok (Pengeluaran) -->
                                        <tr>
                                            <td>Pembelian Stok: {{ $transaksi->stok->nama_barang }}</td>
                                            <td class="text-center">{{ $transaksi->jumlah ?? '-' }}</td>
                                            <td class="text-end">
                                                @if($transaksi->jumlah > 0)
                                                    Rp {{ number_format($transaksi->total / $transaksi->jumlah, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-end">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                        </tr>
                                    @else
                                        <!-- Transaksi Lain -->
                                        <tr>
                                            <td>{{ $transaksi->keterangan }}</td>
                                            <td class="text-center">-</td>
                                            <td class="text-end">-</td>
                                            <td class="text-end">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="bg-light">
                                    @if($transaksi->subtotal > 0 && ($transaksi->diskon_member > 0 || $transaksi->diskon_voucher > 0 || $transaksi->diskon_manual > 0))
                                        <tr>
                                            <td colspan="3" class="text-end">Subtotal</td>
                                            <td class="text-end">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                        @if($transaksi->diskon_member > 0)
                                            <tr class="text-success">
                                                <td colspan="3" class="text-end">Diskon Member ({{ $transaksi->servis->booking?->user?->membershipTier?->nama_level ?? 'Silver' }})</td>
                                                <td class="text-end">- Rp {{ number_format($transaksi->diskon_member, 0, ',', '.') }}</td>
                                            </tr>
                                        @endif
                                        @if($transaksi->diskon_voucher > 0)
                                            <tr class="text-info">
                                                <td colspan="3" class="text-end">Voucher: <strong>{{ $transaksi->kode_voucher }}</strong></td>
                                                <td class="text-end">- Rp {{ number_format($transaksi->diskon_voucher, 0, ',', '.') }}</td>
                                            </tr>
                                        @endif
                                        @if($transaksi->diskon_manual > 0)
                                            <tr class="text-warning">
                                                <td colspan="3" class="text-end">Potongan Manual: <em>{{ $transaksi->alasan_diskon_manual }}</em></td>
                                                <td class="text-end">- Rp {{ number_format($transaksi->diskon_manual, 0, ',', '.') }}</td>
                                            </tr>
                                        @endif
                                    @endif
                                    <tr class="fw-bold">
                                        <td colspan="3" class="text-end">TOTAL @if($transaksi->diskon_manual > 0 || $transaksi->diskon_voucher > 0 || $transaksi->diskon_member > 0) AKHIR @endif</td>
                                        <td class="text-end fs-5 text-primary">Rp
                                            {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Footer -->
                        <div class="text-center mt-5">
                            <p class="text-muted mb-1">Terima kasih atas kepercayaan Anda!</p>
                            <small class="text-muted">Simpan bukti transaksi ini sebagai referensi.</small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 no-print">
                            <a href="{{ route('admin.transaksi') }}" class="btn btn-secondary px-4 me-md-2 shadow-sm">
                                <i class="bi bi-arrow-left"></i> KEMBALI 
                            </a>
                            <button onclick="window.print()" class="btn btn-outline-dark px-4">
                                <i class="bi bi-printer"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background-color: white !important;
            }

            .container {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
@endsection