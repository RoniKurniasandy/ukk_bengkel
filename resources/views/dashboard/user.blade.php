@extends('layouts.app')
@section('title', 'Dashboard Pelanggan')

@section('content')
  <div class="container-fluid py-4">
    <h2 class="fw-bold text-indigo mb-4">Dashboard Pelanggan</h2>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
      <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                  <i class="bi bi-tools text-primary fs-4"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Total Servis</h6>
                <h3 class="mb-0 fw-bold">{{ $totalServis }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                  <i class="bi bi-gear-fill text-info fs-4"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Servis Aktif</h6>
                <h3 class="mb-0 fw-bold text-info">{{ $servisAktif }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                  <i class="bi bi-cash-stack text-success fs-4"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Total Pengeluaran</h6>
                <h3 class="mb-0 fw-bold text-success">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                  <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Sisa Tagihan</h6>
                <h3 class="mb-0 fw-bold text-danger">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-calendar me-2"></i>Riwayat Booking Servis</h5>
        <a href="{{ route('user.booking.create') }}" class="btn btn-light btn-sm">
          <i class="bi bi-plus-circle me-1"></i> Booking Baru
        </a>
      </div>

      <div class="card-body">
        {{-- Filter & Sort --}}
        <form action="{{ route('dashboard.user') }}" method="GET" class="mb-3">
          <div class="row g-2">
            <div class="col-md-4">
              <select name="filter" class="form-select">
                <option value="semua" {{ request('filter', 'semua') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                <option value="aktif" {{ request('filter') == 'aktif' ? 'selected' : '' }}>Servis Aktif</option>
                <option value="selesai" {{ request('filter') == 'selesai' ? 'selected' : '' }}>Selesai</option>
              </select>
            </div>
            <div class="col-md-3">
              <select name="sort" class="form-select">
                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
              </select>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-3">
              <a href="{{ route('dashboard.user') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
          </div>
        </form>

        <div class="table-responsive">
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
                  $pembayaranPending = 0;

                  if ($b->servis) {
                    $totalBayar = \App\Models\Pembayaran::where('servis_id', $b->servis->id)
                      ->where('status', 'diterima')
                      ->sum('jumlah');

                    $pembayaranPending = \App\Models\Pembayaran::where('servis_id', $b->servis->id)
                      ->where('status', 'pending')
                      ->sum('jumlah');

                    $estimasiBiaya = $b->servis->estimasi_biaya;
                    $sisaTagihan = max(0, $estimasiBiaya - $totalBayar);
                  }
                @endphp

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
                      @if($sisaTagihan == 0 && $pembayaranPending == 0)
                        <span class="badge bg-success">
                          <i class="bi bi-check-circle"></i> Lunas
                        </span>
                        <small class="text-success d-block mt-1">
                          Total: Rp {{ number_format($estimasiBiaya, 0, ',', '.') }}
                        </small>
                      @else
                        @if($pembayaranPending > 0)
                          <span class="badge bg-warning text-dark">
                            <i class="bi bi-hourglass-split"></i> Menunggu Konfirmasi
                          </span>
                          <small class="text-muted d-block mt-1">
                            Pembayaran Rp {{ number_format($pembayaranPending, 0, ',', '.') }} sedang diverifikasi
                          </small>
                        @endif

                        @if($totalBayar > 0)
                          <small class="text-success d-block mt-1">
                            <i class="bi bi-check-circle-fill"></i> Diterima: Rp {{ number_format($totalBayar, 0, ',', '.') }}
                          </small>
                        @endif

                        @if($sisaTagihan > 0)
                          <small class="text-danger fw-bold d-block mt-1">
                            Kurang: Rp {{ number_format($sisaTagihan, 0, ',', '.') }} dari Rp
                            {{ number_format($estimasiBiaya, 0, ',', '.') }}
                          </small>

                          @if($pembayaranPending == 0 && in_array($b->servis->status_pembayaran ?? '', ['belum_bayar', 'dp_lunas']))
                            <a href="{{ route('user.pembayaran.create', $b->servis->id) }}" class="btn btn-sm btn-success mt-2">
                              <i class="bi bi-credit-card"></i> Bayar Sekarang
                            </a>
                          @endif
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
  </div>
@endsection