@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold text-primary mb-4">Tambah Layanan</h3>

    <div class="card shadow-sm p-4">
        <form action="{{ route('admin.layanan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="fw-semibold">Nama Layanan</label>
                <input type="text" name="nama_layanan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Estimasi Waktu (menit)</label>
                <input type="number" name="estimasi_waktu" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control"></textarea>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary me-2">Kembali</a>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
