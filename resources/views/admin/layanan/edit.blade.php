@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold text-primary mb-4">Edit Layanan</h3>

    <div class="card shadow-sm p-4">
        <form action="{{ route('admin.layanan.update', $layanan->layanan_id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="fw-semibold">Nama Layanan</label>
                <input type="text" name="nama_layanan" class="form-control" value="{{ $layanan->nama_layanan }}" required>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ $layanan->harga }}" required>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Estimasi Waktu (menit)</label>
                <input type="number" name="estimasi_waktu" class="form-control" value="{{ $layanan->estimasi_waktu }}" required>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ $layanan->deskripsi }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
