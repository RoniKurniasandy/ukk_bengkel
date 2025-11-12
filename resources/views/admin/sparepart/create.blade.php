@extends('admin.layouts.app')

@section('title', 'Tambah Sparepart')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white py-3 px-4">
            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Tambah Sparepart</h5>
        </div>

        <form action="{{ route('admin.sparepart.store') }}" method="POST" class="p-4">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama_sparepart" class="form-label">Nama Sparepart</label>
                    <input type="text" name="nama_sparepart" id="nama_sparepart"
                           class="form-control @error('nama_sparepart') is-invalid @enderror"
                           value="{{ old('nama_sparepart') }}" required>
                    @error('nama_sparepart')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="kode_sparepart" class="form-label">Kode Sparepart</label>
                    <input type="text" name="kode_sparepart" id="kode_sparepart"
                           class="form-control @error('kode_sparepart') is-invalid @enderror"
                           value="{{ old('kode_sparepart') }}" required>
                    @error('kode_sparepart')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok"
                           class="form-control @error('stok') is-invalid @enderror"
                           value="{{ old('stok') }}" min="0" required>
                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" id="harga"
                           class="form-control @error('harga') is-invalid @enderror"
                           value="{{ old('harga') }}" min="0" required>
                    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="form-control @error('keterangan') is-invalid @enderror"
                          placeholder="Opsional...">{{ old('keterangan') }}</textarea>
                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.sparepart.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
