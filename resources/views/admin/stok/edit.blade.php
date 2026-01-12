@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Edit Barang</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.stok.update', $stok->stok_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ $stok->kode_barang }}" class="form-control bg-light" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ $stok->nama_barang }}" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Harga Beli</label>
                        <input type="number" name="harga_beli" value="{{ $stok->harga_beli }}" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" value="{{ $stok->harga_jual }}" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Stok</label>
                        <input type="number" name="jumlah" value="{{ $stok->jumlah }}" class="form-control" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Seri</label>
                    <input type="text" name="nomor_seri" value="{{ $stok->nomor_seri }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ $stok->keterangan }}</textarea>
                </div>

                <button class="btn btn-warning px-4">
                    <i class="bi bi-pencil-square"></i> Update
                </button>
                <a href="{{ route('admin.stok.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection