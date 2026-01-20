@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-primary text-white text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none;">
                    @php
                        $userEmail = auth()->user()->email ?? session('email');
                        $type = $type ?? 'email'; // Default to email verification
                        $formAction = ($type === 'password') ? route('password.verify.otp') : route('verification.verify.otp');
                        $title = ($type === 'password') ? 'Reset Password' : 'Verifikasi Akun';
                        $subtitle = ($type === 'password') ? 'Masukkan kode OTP untuk mereset password Anda' : 'Demi keamanan, silakan verifikasi email Anda';
                    @endphp

                    <div class="icon-shape bg-white text-primary rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi {{ $type === 'password' ? 'bi-key' : 'bi-shield-check' }} fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $title }}</h4>
                    <p class="text-white-50 m-0 small">{{ $subtitle }}</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <p class="text-muted">
                            Kami telah mengirimkan 6 digit kode OTP ke email:<br>
                            <span class="text-dark fw-bold">{{ $userEmail }}</span>
                        </p>
                    </div>

                    <form method="POST" action="{{ $formAction }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $userEmail }}">
                        <div class="mb-4 text-center">
                            <input type="text" 
                                   name="otp" 
                                   id="otp" 
                                   class="form-control form-control-lg text-center fw-bold @error('otp') is-invalid @enderror" 
                                   maxlength="6" 
                                   placeholder="0 0 0 0 0 0"
                                   required 
                                   autofocus
                                   style="font-size: 2.5rem; letter-spacing: 0.3em; border-radius: 15px; border: 2px solid #e2e8f0; height: 80px;"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            @error('otp')
                                <div class="invalid-feedback mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold py-3" style="border-radius: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                Verifikasi Sekarang
                            </button>
                        </div>
                    </form>

                    <div class="text-center border-top pt-4">
                        <p class="text-muted small mb-3">Tidak menerima kode? (Cek folder spam/update)</p>
                        <form action="{{ route('verification.send') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm px-4 fw-bold" style="border-radius: 10px;">
                                <i class="bi bi-send-fill me-1"></i> Kirim Ulang Kode
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    #otp:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
    }
</style>
@endsection
