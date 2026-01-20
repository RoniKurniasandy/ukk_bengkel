@extends('layouts.app')

@section('title', 'Riwayat Servis Saya')

@section('content')
    <div class="container-fluid px-4 py-4">
        <!-- Header -->
        <div class="user-management-header mb-4"
          style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(67, 233, 123, 0.2);">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
              <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i class="bi bi-tools me-2"></i>Riwayat Servis Saya</h2>
              <p class="text-white-50 m-0 mt-2">Daftar servis yang sudah Anda lakukan dan sedang berjalan</p>
            </div>
            <div class="text-white-50">
              <i class="bi bi-info-circle me-1"></i> Klik "Detail / Nota" untuk rincian lengkap
            </div>
          </div>
        </div>

        <div class="card-modern shadow-lg border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table-modern mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Kendaraan</th>
                                <th>Layanan</th>
                                <th>Waktu Booking</th>
                                <th>Progres</th>
                                <th>Total Biaya</th>
                                <th>Pembayaran</th>
                                <th class="pe-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($servis as $s)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>
                                        @if($s->booking && $s->booking->kendaraan)
                                            <div class="fw-semibold">{{ $s->booking->kendaraan->merk }} {{ $s->booking->kendaraan->model }}</div>
                                            <div class="badge bg-light text-dark border small mt-1">{{ $s->booking->kendaraan->plat_nomor }}</div>
                                        @else
                                            <span class="text-muted">Data tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-primary">{{ $s->booking->layanan->nama_layanan ?? 'Umum' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><i class="bi bi-calendar3 me-1 text-primary"></i> {{ \Carbon\Carbon::parse($s->booking->tanggal_booking)->format('d M Y') }}</div>
                                        <div class="small text-muted"><i class="bi bi-clock me-1"></i> {{ $s->booking->jam_booking ?? '-' }} WIB</div>
                                    </td>
                                    <td>
                                        @if($s->booking->status == 'disetujui')
                                            <span class="badge badge-modern" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">Disetujui</span>
                                            <div class="small text-muted mt-1 px-1">Menunggu mekanik</div>
                                        @elseif($s->booking->status == 'dikerjakan')
                                            <span class="badge badge-modern" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">Dikerjakan</span>
                                        @elseif($s->booking->status == 'selesai')
                                            <span class="badge badge-modern" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">Selesai</span>
                                        @else
                                            <span class="badge badge-modern bg-secondary">{{ ucfirst($s->booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($s->estimasi_biaya)
                                            <strong class="text-success">Rp {{ number_format($s->estimasi_biaya, 0, ',', '.') }}</strong>
                                        @else
                                            <span class="text-muted small">Belum dihitung</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($s->status_pembayaran == 'lunas')
                                            <span class="badge badge-modern bg-light text-success border border-success-subtle"><i class="bi bi-check-circle-fill"></i> Lunas</span>
                                        @elseif($s->status_pembayaran == 'dp_lunas')
                                            <span class="badge badge-modern bg-light text-info border border-info-subtle">DP Lunas</span>
                                        @else
                                            <span class="badge badge-modern bg-light text-danger border border-danger-subtle">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-center">
                                        <div class="d-flex flex-column gap-1">
                                            <a href="{{ route('user.booking.show', $s->booking_id) }}" class="btn btn-sm btn-info text-white fw-bold px-3 py-1" style="border-radius: 8px;">
                                                <i class="bi bi-file-text"></i> Detail
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

                                            @if($pembayaranPending > 0)
                                                <span class="badge bg-warning text-dark small" style="font-size: 0.65rem;">
                                                    <i class="bi bi-hourglass-split"></i> Verifikasi...
                                                </span>
                                            @endif

                                            @if($sisaTagihan > 0 && $pembayaranPending == 0 && in_array($s->status_pembayaran ?? '', ['belum_bayar', 'dp_lunas']))
                                                <a href="{{ route('user.pembayaran.create', $s->id) }}" class="btn btn-sm btn-success fw-bold px-3 py-1" style="border-radius: 8px;">
                                                    <i class="bi bi-credit-card"></i> {{ ($s->status_pembayaran == 'dp_lunas' || $totalBayar > 0) ? 'Pelunasan' : 'Bayar' }}
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center py-5" colspan="8">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                            <p class="mb-0">Belum ada riwayat servis tercatat.</p>
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