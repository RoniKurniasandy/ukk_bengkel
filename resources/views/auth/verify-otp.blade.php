@extends('layouts.app')

@section('title', 'Verifikasi OTP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Verifikasi OTP</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">
                        Masukkan 6 digit kode OTP yang telah kami kirimkan ke email Anda: <strong>{{ session('email', old('email')) }}</strong>
                    </p>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.verify.otp') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email', old('email')) }}">

                        <div class="mb-3 text-center">
                            <label for="otp" class="form-label visually-hidden">Kode OTP</label>
                            <input id="otp" type="text" class="form-control form-control-lg text-center fs-2 tracking-widest @error('otp') is-invalid @enderror" name="otp" required autofocus maxlength="6" placeholder="000000" style="letter-spacing: 0.5em;">
                            @error('otp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary rounded-pill btn-lg">
                                Verifikasi
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <form action="{{ route('password.email') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('email', old('email')) }}">
                            <button type="submit" class="btn btn-link p-0 text-decoration-none small">
                                Kirim Ulang OTP
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
