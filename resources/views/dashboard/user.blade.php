@extends('layouts.app')
@section('title', 'Dashboard Pelanggan')

@section('content')
  <div class="container-fluid py-4">
    <h2 class="fw-bold text-indigo mb-4">Dashboard Pelanggan</h2>

    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="ti ti-calendar me-2"></i>Riwayat Booking Servis</h5>
        <a href="{{ route('user.booking.create') }}" class="btn btn-light btn-sm">Booking Baru</a>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Jenis Servis</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Pembayaran</th>
            </tr>
          </thead>
          <tbody>
            @forelse($bookings ?? [] as $i => $b)
              @php
                $sisaTagihan = 0;
                $totalBayar = 0;
                $estimasiBiaya = 0;

                if ($b->servis) {
                  $totalBayar = \App\Models\Pembayaran::where('servis_id', $b->servis->id)
                    ->where('status', 'diterima')
                    ->sum('jumlah');
                  $estimasiBiaya = $b->servis->estimasi_biaya;
                  $sisaTagihan = max(0, $estimasiBiaya - $totalBayar);
                }
              @endphp

              @if(!$b->servis || $sisaTagihan > 0)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>{{ data_get($b, 'layanan.nama_layanan', '-') }}</td>
                  <td>{{ data_get($b, 'tanggal_booking', '-') }}</td>
                  <td>
                    @php $status = data_get($b, 'status', 'menunggu'); @endphp
                    <span
                      class="badge bg-{{ $status == 'selesai' ? 'success' : ($status == 'dikerjakan' ? 'primary' : ($status == 'disetujui' ? 'info' : 'warning')) }}">
                      {{ ucfirst($status) }}
                    </span>
                  </td>
                  <td>
                    @if($b->servis)
                      @if($sisaTagihan > 0)
                        @if($totalBayar > 0)
                          <small class="text-muted d-block">Sudah dibayar: Rp {{ number_format($totalBayar, 0, ',', '.') }}</small>
                        @endif
                        <small class="text-danger fw-bold d-block">
                          Kurang: Rp {{ number_format($sisaTagihan, 0, ',', '.') }} dari Rp
                          {{ number_format($estimasiBiaya, 0, ',', '.') }}
                        </small>

                        @if(in_array($b->servis->status_pembayaran ?? '', ['belum_bayar', 'dp_lunas']))
                          <a href="{{ route('user.pembayaran.create', $b->servis->id) }}" class="btn btn-sm btn-success mt-2">
                            <i class="bi bi-credit-card"></i> Bayar Sekarang
                          </a>
                        @endif
                      @endif
                    @else
                      @if($status == 'disetujui')
                        <small class="text-info"><i class="bi bi-clock-history"></i> Menunggu mekanik memulai servis</small>
                      @else
                        <small class="text-muted">Menunggu persetujuan admin</small>
                      @endif
                    @endif
                  </td>
                </tr>
              @endif
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Belum ada booking servis.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection