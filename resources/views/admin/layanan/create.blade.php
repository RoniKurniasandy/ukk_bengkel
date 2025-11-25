@extends('layouts.app')
@section('title', 'Tambah Layanan')

@section('content')
    <div class="container-fluid px-4">
        <div class="user-management-header mb-4"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                            class="bi bi-plus-circle me-2"></i>Tambah Layanan</h2>
                    <p class="text-white-50 m-0 mt-2">Formulir penambahan layanan servis baru</p>
                </div>
                <a href="{{ route('admin.layanan.index') }}"
                    class="btn btn-light text-primary fw-bold mt-3 mt-md-0 shadow-sm" style="border-radius: 10px;">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-modern">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.layanan.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="nama_layanan" class="form-label fw-bold text-secondary">Nama Layanan</label>
                                <input type="text"
                                    class="form-control form-control-lg @error('nama_layanan') is-invalid @enderror"
                                    id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan') }}"
                                    placeholder="Contoh: Ganti Oli Mesin" required style="border-radius: 10px;">
                                @error('nama_layanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="harga" class="form-label fw-bold text-secondary">Harga (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"
                                            style="border-radius: 10px 0 0 10px;">Rp</span>
                                        <input type="number"
                                            class="form-control form-control-lg border-start-0 @error('harga') is-invalid @enderror"
                                            id="harga" name="harga" value="{{ old('harga') }}" placeholder="0" required
                                            min="0" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('harga')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="estimasi_waktu" class="form-label fw-bold text-secondary">Estimasi
                                        Waktu</label>
                                    <input type="text"
                                        class="form-control form-control-lg @error('estimasi_waktu') is-invalid @enderror"
                                        id="estimasi_waktu" name="estimasi_waktu" value="{{ old('estimasi_waktu') }}"
                                        placeholder="Contoh: 30 Menit" required style="border-radius: 10px;">
                                    @error('estimasi_waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-bold text-secondary">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                    name="deskripsi" rows="4" placeholder="Jelaskan detail layanan ini..."
                                    style="border-radius: 10px;">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                                <a href="{{ route('admin.layanan.index') }}" class="btn btn-light btn-lg px-4 me-md-2"
                                    style="border-radius: 10px; font-weight: 600;">Batal</a>
                                <button type="submit" class="btn btn-modern btn-lg px-5">Simpan Layanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection