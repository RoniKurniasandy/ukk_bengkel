@extends('layouts.app')
@section('title', 'Booking Servis')

@section('content')
    <div class="container-fluid px-4">
        <div class="user-management-header mb-4"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                            class="bi bi-calendar-plus me-2"></i>Booking Servis Baru</h2>
                    <p class="text-white-50 m-0 mt-2">Formulir pemesanan layanan servis kendaraan</p>
                </div>
                <a href="{{ route('user.booking.index') }}"
                    class="btn btn-light text-primary fw-bold mt-3 mt-md-0 shadow-sm" style="border-radius: 10px;">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-modern">
                    <div class="card-body p-4">
                        <form action="{{ route('user.booking.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="kendaraan_id" class="form-label fw-bold text-secondary">Pilih Kendaraan</label>
                                <select name="kendaraan_id" id="kendaraan_id"
                                    class="form-select form-select-lg @error('kendaraan_id') is-invalid @enderror" required
                                    style="border-radius: 10px;">
                                    <option value="">-- Pilih Kendaraan Anda --</option>
                                    @forelse ($kendaraan as $k)
                                        <option value="{{ $k->id }}" {{ old('kendaraan_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->model }} - {{ $k->plat_nomor }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Belum ada kendaraan terdaftar</option>
                                    @endforelse
                                </select>
                                @error('kendaraan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($kendaraan->isEmpty())
                                    <small class="text-muted mt-1 d-block">
                                        <i class="bi bi-info-circle me-1"></i>Anda belum memiliki kendaraan.
                                        <a href="{{ route('user.kendaraan') }}" class="text-primary">Tambahkan kendaraan</a>
                                        terlebih dahulu.
                                    </small>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="layanan_id" class="form-label fw-bold text-secondary">Layanan Servis</label>
                                <select name="layanan_id" id="layanan_id"
                                    class="form-select form-select-lg @error('layanan_id') is-invalid @enderror" required
                                    style="border-radius: 10px;">
                                    <option value="">-- Pilih Jenis Layanan --</option>
                                    @foreach ($layanan as $l)
                                        <option value="{{ $l->id }}" {{ old('layanan_id') == $l->id ? 'selected' : '' }}>
                                            {{ $l->nama_layanan }} - Rp {{ number_format($l->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('layanan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_booking" class="form-label fw-bold text-secondary">Tanggal
                                    Booking</label>
                                <input type="date" name="tanggal_booking" id="tanggal_booking"
                                    class="form-control form-control-lg @error('tanggal_booking') is-invalid @enderror"
                                    min="{{ date('Y-m-d') }}" value="{{ old('tanggal_booking') }}" required
                                    style="border-radius: 10px;">
                                @error('tanggal_booking')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted mt-1 d-block">
                                    <i class="bi bi-info-circle me-1"></i>Pilih tanggal minimal hari ini
                                </small>
                            </div>

                            <div class="mb-4">
                                <label for="keluhan" class="form-label fw-bold text-secondary">Keluhan Kendaraan</label>
                                <textarea name="keluhan" id="keluhan"
                                    class="form-control @error('keluhan') is-invalid @enderror" rows="4"
                                    placeholder="Jelaskan keluhan atau masalah pada kendaraan Anda..." required
                                    style="border-radius: 10px;">{{ old('keluhan') }}</textarea>
                                @error('keluhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                                <a href="{{ route('user.booking.index') }}" class="btn btn-light btn-lg px-4 me-md-2"
                                    style="border-radius: 10px; font-weight: 600;">Batal</a>
                                <button type="submit" class="btn btn-modern btn-lg px-5">
                                    <i class="bi bi-send me-2"></i>Kirim Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection