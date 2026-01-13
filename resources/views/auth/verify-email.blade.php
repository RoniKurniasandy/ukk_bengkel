@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-envelope-check me-2"></i>Verifikasi Email Anda</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="mb-4">
                        Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi email Anda dengan mengeklik tautan yang baru saja kami kirimkan. 
                        Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan ulang.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            Tautan verifikasi baru telah dikirimkan ke alamat email Anda.
                        </div>
                    @endif

                    <div class="d-flex justify-content-center gap-3">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                Kirim Ulang Email Verifikasi
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger px-4 rounded-pill">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
