@extends('layouts.app')

@section('title', 'Dashboard Mekanik')

@section('content')
<div class="container-fluid px-4">
    @if(auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
      <div class="alert alert-warning border-0 shadow-sm mb-4 d-flex align-items-center justify-content-between" style="border-radius: 12px; background: #fffcf0; border-left: 5px solid #ffc107 !important;">
        <div class="d-flex align-items-center">
          <div class="icon-circle bg-warning text-white me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 50%;">
            <i class="bi bi-exclamation-triangle-fill"></i>
          </div>
          <div>
            <h6 class="mb-0 fw-bold text-dark">Email Belum Diverifikasi</h6>
            <p class="mb-0 text-muted small">Silakan verifikasi email Anda untuk mengakses jadwal dan detail servis.</p>
          </div>
        </div>
        <a href="{{ route('verification.notice') }}" class="btn btn-warning btn-sm fw-bold px-3" style="border-radius: 8px;">Verifikasi Sekarang</a>
      </div>
    @endif

    <!-- Header -->
    <div class="user-management-header mb-4"
      style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.2);">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i class="bi bi-person-gear me-2"></i>Dashboard Mekanik</h2>
          <p class="text-white-50 m-0 mt-2">Selamat datang kembali, {{ auth()->user()->nama }}! Berikut ringkasan tugas Anda.</p>
        </div>
        <div class="text-white-50">
          {{ now()->format('l, d F Y') }}
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
      <div class="col-md-6 col-xl-4">
        <div class="card-modern h-100 p-4">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">JADWAL HARI INI</p>
              <h3 class="fw-bold mb-0" style="color: #2d3748;">{{ $jadwal_hari_ini ?? 0 }}</h3>
            </div>
            <div class="icon-shape text-white rounded-circle p-3 d-flex align-items-center justify-content-center"
              style="width: 48px; height: 48px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
              <i class="bi bi-calendar-check fs-5"></i>
            </div>
          </div>
          <div class="mt-3">
            <span class="text-muted small">Servis yang menunggu dikerjakan</span>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="card-modern h-100 p-4">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">SEDANG DIKERJAKAN</p>
              <h3 class="fw-bold mb-0" style="color: #2d3748;">{{ $servis_dikerjakan ?? 0 }}</h3>
            </div>
            <div class="icon-shape text-white rounded-circle p-3 d-flex align-items-center justify-content-center"
              style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
              <i class="bi bi-tools fs-5"></i>
            </div>
          </div>
          <div class="mt-3">
            <span class="text-success small fw-bold"><i class="bi bi-arrow-up-short"></i> Dalam proses servis</span>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="card-modern h-100 p-4">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1 font-weight-bold" style="font-size: 0.85rem;">TOTAL SELESAI</p>
              <h3 class="fw-bold mb-0" style="color: #2d3748;">{{ $servis_selesai ?? 0 }}</h3>
            </div>
            <div class="icon-shape text-white rounded-circle p-3 d-flex align-items-center justify-content-center"
              style="width: 48px; height: 48px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
              <i class="bi bi-check2-all fs-5"></i>
            </div>
          </div>
          <div class="mt-3">
            <span class="text-muted small">Total servis yang telah Anda selesaikan</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Aktivitas Terbaru Section -->
    <div class="card-modern">
      <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold m-0" style="color: #2d3748;"><i class="bi bi-clock-history me-2 text-primary"></i>Aktivitas Servis Terbaru</h5>
        <a href="{{ route('mekanik.servis.aktif') }}" class="btn btn-sm btn-modern">Lihat Semua</a>
      </div>
      <div class="table-responsive">
        <table class="table-modern mb-0">
          <thead>
            <tr>
              <th class="ps-4">No</th>
              <th>Pelanggan</th>
              <th>Kendaraan</th>
              <th>Layanan</th>
              <th>Status</th>
              <th>Waktu Update</th>
            </tr>
          </thead>
          <tbody>
            @forelse($servis_terbaru as $index => $s)
              <tr>
                <td class="ps-4">{{ $index + 1 }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                      style="width: 32px; height: 32px; color: #4facfe; font-weight: bold;">
                      {{ strtoupper(substr($s->booking->user->nama ?? '?', 0, 1)) }}
                    </div>
                    <span class="fw-semibold">{{ $s->booking->user->nama ?? '-' }}</span>
                  </div>
                </td>
                <td>
                  {{ $s->booking->kendaraan->merk ?? '' }} {{ $s->booking->kendaraan->model ?? '' }}
                  <br><small class="text-muted">{{ $s->booking->kendaraan->plat_nomor ?? '-' }}</small>
                </td>
                <td>{{ $s->booking->layanan->nama_layanan ?? '-' }}</td>
                <td>
                  @if($s->status == 'selesai')
                    <span class="badge badge-modern"
                      style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">Selesai</span>
                  @elseif($s->status == 'dikerjakan')
                    <span class="badge badge-modern"
                      style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">Dikerjakan</span>
                  @else
                    <span class="badge badge-modern bg-secondary">{{ ucfirst($s->status) }}</span>
                  @endif
                </td>
                <td>{{ $s->updated_at->diffForHumans() }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-5">
                  <div class="text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                    <p class="mb-0">Belum ada aktivitas servis terbaru</p>
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
