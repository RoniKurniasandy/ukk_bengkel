@extends('layouts.app')

@section('title', 'Riwayat Servis Saya')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold"><i class="bi bi-tools"></i> Riwayat Servis Saya</h3>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-lg border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Kendaraan</th>
                            <th>Layanan</th>
                            <th>Waktu Booking</th>
                            <th>Status</th>
                            <th>Estimasi Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($servis as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($s->booking && $s->booking->kendaraan)
                                        {{ $s->booking->kendaraan->merk }} {{ $s->booking->kendaraan->model }}<br>
                                        <small class="text-muted">{{ $s->booking->kendaraan->plat_nomor }}</small>
                                    @else
                                        <span class="text-muted">Data kendaraan tidak tersedia</span>
                                    @endif
                                </td>
                                <td>{{ $s->booking->layanan->nama_layanan ?? 'Umum' }}</td>
                                <td>
                                    <div><i
                                            class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($s->booking->tanggal_booking)->format('d M Y') }}
                                    </div>
                                    <div class="text-primary"><i
                                            class="bi bi-clock me-1"></i>{{ $s->booking->jam_booking ?? '-' }}</div>
                                </td>
                                <td>
                                    @if($s->booking->status == 'disetujui')
                                        <div class="d-flex flex-column align-items-start">
                                            <span class="badge bg-warning text-dark mb-1">
                                                <i class="bi bi-check-circle-fill"></i> Disetujui
                                            </span>
                                            <small class="text-danger fw-bold" style="font-size: 0.75rem;">
                                                <i class="bi bi-hourglass-split"></i> Menunggu Mekanik
                                            </small>
                                        </div>
                                    @elseif($s->booking->status == 'dikerjakan')
                                        <span class="badge bg-info text-dark">
                                            <i class="bi bi-gear-fill"></i> Sedang Dikerjakan
                                        </span>
                                    @elseif($s->booking->status == 'selesai')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($s->booking->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($s->estimasi_biaya)
                                        <strong class="text-success">Rp
                                            {{ number_format($s->estimasi_biaya, 0, ',', '.') }}</strong>
                                    @else
                                        <span class="text-muted">Belum dihitung</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.booking.show', $s->booking_id) }}" class="btn btn-sm btn-primary"
                                        data-bs-toggle="tooltip" title="Lihat Detail & Nota">
                                        <i class="bi bi-file-text"></i> Detail / Nota
                                    </a>

                                    @php
                                        $totalBayar = \App\Models\Pembayaran::where('servis_id', $s->id)
                                            ->where('status', 'diterima')
                                            ->sum('jumlah');

                                        $pembayaranPending = \App\Models\Pembayaran::where('servis_id', $s->id)
                                            ->where('status', 'pending')
                                            ->sum('jumlah');

                                        $estimasiBiaya = $s->estimasi_biaya;
                                        $sisaTagihan = max(0, $estimasiBiaya - $totalBayar);
                                    @endphp

                                    @if($sisaTagihan == 0 && $pembayaranPending == 0 && $estimasiBiaya > 0)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Lunas
                                        </span>
                                    @else
                                        @if($pembayaranPending > 0)
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-hourglass-split"></i> Menunggu Konfirmasi
                                            </span>
                                        @endif

                                        @if($sisaTagihan > 0 && $pembayaranPending == 0 && in_array($s->status_pembayaran ?? '', ['belum_bayar', 'dp_lunas']))
                                            <a href="{{ route('user.pembayaran.create', $s->id) }}" class="btn btn-sm btn-success mt-1">
                                                <i class="bi bi-credit-card"></i> 
                                                {{ ($s->status_pembayaran == 'dp_lunas' || $totalBayar > 0) ? 'Pelunasan' : 'Bayar' }}
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center py-4" colspan="7">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Belum ada riwayat servis.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Info Box --}}
        @if($servis->count() > 0)
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle"></i> <strong>Tips:</strong> Klik tombol "Detail / Nota" untuk melihat rincian
                servis dan mencetak nota pembayaran.
            </div>
        @endif

    </div>
@endsection