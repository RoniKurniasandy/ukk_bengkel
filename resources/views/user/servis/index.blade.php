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
                                    {{ $s->kendaraan->merk }} {{ $s->kendaraan->model }}<br>
                                    <small class="text-muted">{{ $s->kendaraan->plat_nomor }}</small>
                                </td>
                                <td>{{ $s->layanan->nama_layanan ?? 'Umum' }}</td>
                                <td>
                                    <div><i
                                            class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($s->tanggal_booking)->format('d M Y') }}
                                    </div>
                                    <div class="text-primary"><i class="bi bi-clock me-1"></i>{{ $s->jam_booking ?? '-' }}</div>
                                </td>
                                <td>
                                    @if($s->status == 'disetujui')
                                        <span class="badge bg-info text-dark">Sedang Dikerjakan</span>
                                    @elseif($s->status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($s->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($s->servis && $s->servis->estimasi_biaya)
                                        <strong class="text-success">Rp
                                            {{ number_format($s->servis->estimasi_biaya, 0, ',', '.') }}</strong>
                                    @else
                                        <span class="text-muted">Belum dihitung</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.booking.show', $s->booking_id) }}" class="btn btn-sm btn-primary"
                                        data-bs-toggle="tooltip" title="Lihat Detail & Nota">
                                        <i class="bi bi-file-text"></i> Detail / Nota
                                    </a>

                                    @if($s->servis)
                                        @php
                                            $totalBayar = \App\Models\Pembayaran::where('servis_id', $s->servis->id)
                                                ->where('status', 'diterima')
                                                ->sum('jumlah');
                                            $estimasiBiaya = $s->servis->estimasi_biaya;
                                            $sisaTagihan = max(0, $estimasiBiaya - $totalBayar);
                                        @endphp

                                        @if($sisaTagihan > 0 && in_array($s->servis->status_pembayaran ?? '', ['belum_bayar', 'dp_lunas']))
                                            <a href="{{ route('user.pembayaran.create', $s->servis->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="bi bi-credit-card"></i> Bayar
                                            </a>
                                        @elseif($sisaTagihan == 0)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Lunas
                                            </span>
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