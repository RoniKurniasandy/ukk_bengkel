@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Barang</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.stok.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Harga Beli</label>
                        <input type="number" name="harga_beli" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Stok</label>
                        <input type="number" name="jumlah" class="form-control" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Seri</label>
                    <input type="text" name="nomor_seri" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <button class="btn btn-primary px-4">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('admin.stok.index') }}" class="btn btn-secondary px-4">
                    Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection