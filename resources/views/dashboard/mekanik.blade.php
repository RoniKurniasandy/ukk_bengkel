@extends('layouts.app')

@section('title', 'Dashboard Mekanik')

@section('content')
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
<div class="row g-3">
  <div class="col-md-6 col-xl-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h6 class="text-muted mb-1"><i class="bi bi-gear-fill me-1"></i> Servis Dikerjakan</h6>
        <h3 class="fw-bold text-primary">{{ $servis_dikerjakan ?? 0 }}</h3>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h6 class="text-muted mb-1"><i class="bi bi-check-circle me-1"></i> Servis Selesai</h6>
        <h3 class="fw-bold text-success">{{ $servis_selesai ?? 0 }}</h3>
      </div>
    </div>
  </div>
</div>
@endsection
