@extends('layouts.app')

@section('title', 'Verifikasi Nomor HP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-phone me-2"></i>Verifikasi Ganti Nomor HP</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="mb-4">
                        Kami telah mengirimkan kode verifikasi ke email Anda <strong>{{ Auth::user()->email }}</strong>. 
                        Silakan masukkan kode tersebut di bawah ini untuk mengonfirmasi perubahan nomor HP menjadi <strong>{{ Auth::user()->pending_no_hp }}</strong>.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.profil.phone.verify') }}">
                        @csrf
                        <div class="mb-4">
                            <input type="text" name="code" class="form-control form-control-lg text-center fw-bold letter-spacing-3 @error('code') is-invalid @enderror" placeholder="000000" maxlength="6" required autofocus>
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
                                Verifikasi Nomor HP
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('user.profil.phone.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none text-muted">
                            Belum menerima kode? Kirim ulang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .letter-spacing-3 {
        letter-spacing: 0.5rem;
    }
</style>
@endsection
