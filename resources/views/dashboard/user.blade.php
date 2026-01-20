@extends('layouts.app')
@section('title', 'Dashboard Pelanggan')

@section('content')
  <div class="container-fluid px-4 py-4">
    @if(auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
      <div class="alert alert-warning border-0 shadow-sm mb-4 d-flex align-items-center justify-content-between" style="border-radius: 12px; background: #fffcf0; border-left: 5px solid #ffc107 !important;">
        <div class="d-flex align-items-center">
          <div class="icon-circle bg-warning text-white me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%;">
            <i class="bi bi-exclamation-triangle-fill"></i>
          </div>
          <div>
            <h6 class="mb-0 fw-bold text-dark">Email Belum Diverifikasi</h6>
            <p class="mb-0 text-muted small">Silakan verifikasi email Anda untuk melakukan booking dan melihat riwayat servis lengkap.</p>
          </div>
        </div>
        <a href="{{ route('verification.notice') }}" class="btn btn-warning btn-sm fw-bold px-3" style="border-radius: 8px;">Verifikasi Sekarang</a>
      </div>
    @endif

    <!-- Header -->
    <div class="user-management-header mb-4"
      style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i class="bi bi-speedometer2 me-2"></i>Dashboard Pelanggan</h2>
          <p class="text-white-50 m-0 mt-2">Selamat datang kembali, {{ explode(' ', $user->nama)[0] }}! Ringkasan aktivitas Anda hari ini.</p>
        </div>
        <div class="text-white-50">
          {{ now()->format('l, d F Y') }}
        </div>
      </div>
    </div>

    <!-- Stats Cards Summary -->
    <div class="row g-4 mb-4">
      <div class="col-md-6 col-xl-3">
        <div class="card-modern h-100 p-4">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">TOTAL SERVIS</p>
              <h3 class="fw-bold mb-0" style="color: #2d3748;">{{ $totalServis }}</h3>
            </div>
            <div class="icon-shape bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center"
              style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
              <i class="bi bi-tools fs-5"></i>
            </div>
          </div>
          <div class="mt-3">
            <span class="text-muted small">Sudah pernah Anda lakukan</span>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xl-3">
        <div class="card-modern h-100 p-4">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">SERVIS AKTIF</p>
              <h3 class="fw-bold mb-0" style="color: #2d3748;">{{ $servisAktif }}</h3>
            </div>
            <div class="icon-shape text-white rounded-circle p-3 d-flex align-items-center justify-content-center"
              style="width: 48px; height: 48px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
              <i class="bi bi-gear-fill fs-5"></i>
            </div>
          </div>
          <div class="mt-3">
            <span class="text-primary small fw-semibold">Sedang dalam antrean/pengerjaan</span>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xl-3">
        <div class="card-modern h-100 p-4">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">KENDARAAN SAYA</p>
              <h3 class="fw-bold mb-0" style="color: #2d3748;">{{ $totalKendaraan }}</h3>
            </div>
            <div class="icon-shape text-white rounded-circle p-3 d-flex align-items-center justify-content-center"
              style="width: 48px; height: 48px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
              <i class="bi bi-bicycle fs-5"></i>
            </div>
          </div>
          <div class="mt-3">
            <a href="{{ route('user.kendaraan') }}" class="text-decoration-none small text-success">Kelola kendaraan <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xl-3">
        <div class="card-modern h-100 p-4 @if($sisaTagihan > 0) border-danger-subtle bg-danger bg-opacity-10 @endif">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">TOTAL PENGELUARAN</p>
              <h3 class="fw-bold mb-0 @if($sisaTagihan > 0) text-danger @endif" style="color: #2d3748;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            </div>
            <div class="icon-shape text-white rounded-circle p-3 d-flex align-items-center justify-content-center"
              style="width: 48px; height: 48px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
              <i class="bi bi-cash-stack fs-5"></i>
            </div>
          </div>
          <div class="mt-3">
            @if($sisaTagihan > 0)
                <span class="text-danger small fw-bold">Belum dibayar: Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</span>
            @else
                <span class="text-muted small">Tercatat di sistem bengkel</span>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Booking History Table -->
    <div class="card-modern">
      <div class="p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="fw-bold m-0" style="color: #2d3748;"><i class="bi bi-clock-history me-2 text-indigo"></i>Riwayat Booking Servis</h5>
        
        <div class="d-flex gap-2">
            {{-- Filter Button --}}
            <div class="dropdown">
                <button class="btn btn-modern btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-filter me-1"></i> Filter Status
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg border-0" style="min-width: 250px; border-radius: 12px;">
                    <form action="{{ route('dashboard.user') }}" method="GET">
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="filter" class="form-select form-select-sm">
                                <option value="semua" {{ request('filter', 'semua') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                                <option value="aktif" {{ request('filter') == 'aktif' ? 'selected' : '' }}>Servis Aktif</option>
                                <option value="selesai" {{ request('filter') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Urutan</label>
                            <select name="sort" class="form-select form-select-sm">
                                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                            <a href="{{ route('dashboard.user') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <a href="{{ route('user.booking.create') }}" class="btn btn-primary btn-sm btn-modern px-3">
              <i class="bi bi-plus-lg me-1"></i> Booking Baru
            </a>
        </div>
      </div>
      
      <div class="table-responsive">
        <table class="table-modern mb-0">
          <thead>
            <tr>
              <th class="ps-4">No</th>
              <th>Jenis Servis / Layanan</th>
              <th>Tanggal Booking</th>
              <th>Status Progres</th>
              <th class="pe-4 text-center">Status Pembayaran</th>
            </tr>
          </thead>
          <tbody>
            @forelse($bookings as $i => $b)
                @php
                  $sisaTagihanBooking = 0;
                  $totalBayarBooking = 0;
                  $estimasiBiayaBooking = 0;
                  $pembayaranPendingBooking = 0;

                  if ($b->servis) {
                    $totalBayarBooking = \App\Models\Pembayaran::where('servis_id', $b->servis->id)
                      ->where('status', 'diterima')
                      ->sum('jumlah');

                    $pembayaranPendingBooking = \App\Models\Pembayaran::where('servis_id', $b->servis->id)
                      ->where('status', 'pending')
                      ->sum('jumlah');

                    $estimasiBiayaBooking = $b->servis->estimasi_biaya;
                    $sisaTagihanBooking = max(0, $estimasiBiayaBooking - $totalBayarBooking);
                  }
                @endphp

              <tr>
                <td class="ps-4">{{ $i + 1 }}</td>
                <td>
                  <div class="fw-semibold">{{ data_get($b, 'layanan.nama_layanan', '-') }}</div>
                  <div class="small text-muted">{{ $b->kendaraan->merk ?? '' }} {{ $b->kendaraan->model ?? '' }} ({{ $b->kendaraan->plat_nomor ?? '-' }})</div>
                </td>
                <td>
                  <div class="fw-semibold"><i class="bi bi-calendar-event me-1 text-indigo"></i> {{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d M Y') }}</div>
                  <div class="small text-muted"><i class="bi bi-clock me-1"></i> {{ $b->jam_booking ?? '-' }} WIB</div>
                </td>
                <td>
                  @php $status = data_get($b, 'status', 'menunggu'); @endphp
                  @if($status == 'selesai')
                    <span class="badge badge-modern" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">Selesai</span>
                  @elseif($status == 'dikerjakan')
                    <span class="badge badge-modern" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">Dikerjakan</span>
                  @elseif($status == 'disetujui')
                    <span class="badge badge-modern" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">Disetujui</span>
                  @else
                    <span class="badge badge-modern bg-secondary">Menunggu</span>
                  @endif
                </td>
                <td class="pe-4 text-center">
                    @if($b->servis)
                      @if($sisaTagihanBooking == 0 && $pembayaranPendingBooking == 0)
                        <span class="badge bg-light text-success border border-success-subtle px-3 fw-bold">
                          <i class="bi bi-check-circle-fill"></i> Lunas
                        </span>
                        <small class="text-muted d-block mt-1">Total: Rp {{ number_format($estimasiBiayaBooking, 0, ',', '.') }}</small>
                      @else
                        @if($pembayaranPendingBooking > 0)
                          <div class="mb-1">
                            <span class="badge bg-light text-warning border border-warning-subtle fw-bold">
                                <i class="bi bi-hourglass-split"></i> Verifikasi...
                            </span>
                          </div>
                        @endif

                        @if($sisaTagihanBooking > 0)
                          <div class="text-danger fw-bold small">Kurang: Rp {{ number_format($sisaTagihanBooking, 0, ',', '.') }}</div>
                          @if($pembayaranPendingBooking == 0 && in_array($b->servis->status_pembayaran ?? '', ['belum_bayar', 'dp_lunas']))
                            <a href="{{ route('user.pembayaran.create', $b->servis->id) }}" class="btn btn-sm btn-success mt-1 py-0 px-2 small">
                              <i class="bi bi-credit-card"></i> Bayar
                            </a>
                          @endif
                        @endif
                      @endif
                    @else
                      <span class="text-muted small">Menunggu proses servis</span>
                    @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="text-muted">
                    <i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i>
                    <p class="mb-0">Belum ada riwayat booking servis.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection