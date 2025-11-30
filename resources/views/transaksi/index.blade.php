@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0"><i class="bi bi-cash-coin"></i> Riwayat Transaksi</h3>
            <div>
                <span class="badge bg-success fs-6 me-2">
                    <i class="bi bi-arrow-down-circle"></i> Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </span>
                <span class="badge bg-danger fs-6">
                    <i class="bi bi-arrow-up-circle"></i> Pengeluaran: Rp
                    {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Sumber</th>
                                <th>Keterangan</th>
                                <th>User</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $t)
                                <tr>
                                    <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        @if($t->jenis_transaksi == 'pemasukan')
                                            <span class="badge bg-success-subtle text-success border border-success">
                                                <i class="bi bi-arrow-down"></i> Pemasukan
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger">
                                                <i class="bi bi-arrow-up"></i> Pengeluaran
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($t->sumber == 'servis')
                                            <span class="badge bg-primary">Servis</span>
                                        @elseif($t->sumber == 'belanja_stok')
                                            <span class="badge bg-warning text-dark">Belanja Stok</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $t->sumber }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $t->keterangan }}
                                        @if($t->stok)
                                            <br><small class="text-muted">Item: {{ $t->stok->nama_barang }} ({{ $t->jumlah }}
                                                {{ $t->stok->satuan }})</small>
                                        @endif
                                    </td>
                                    <td>{{ $t->user->nama ?? '-' }}</td>
                                    <td
                                        class="text-end fw-bold {{ $t->jenis_transaksi == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                        {{ $t->jenis_transaksi == 'pemasukan' ? '+' : '-' }} Rp
                                        {{ number_format($t->total, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}"
                                            class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Lihat Nota">
                                            <i class="bi bi-file-text"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection