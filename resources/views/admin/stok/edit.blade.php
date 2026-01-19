@extends('layouts.app')

@section('title', 'Edit Stok Barang')

@section('content')
<div class="container-fluid px-4">
    <div class="user-management-header mb-4"
        style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                        class="bi bi-pencil-square me-2"></i>Edit Stok</h2>
                <p class="text-white-50 m-0 mt-2">Perbarui informasi barang: <strong>{{ $stok->nama_barang }}</strong></p>
            </div>
            <a href="{{ route('admin.stok.index') }}"
                class="btn btn-light text-primary fw-bold mt-3 mt-md-0 shadow-sm" style="border-radius: 10px;">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card-modern">
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.stok.update', $stok->stok_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-secondary">Kode Barang / SKU (Terkunci)</label>
                                <input type="text" class="form-control form-control-lg bg-light" 
                                    value="{{ $stok->kode_barang }}" readonly 
                                    style="border-radius: 10px; color: #64748b;">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="nama_barang" class="form-label fw-bold text-secondary">Nama Barang</label>
                                <input type="text" class="form-control form-control-lg @error('nama_barang') is-invalid @enderror" 
                                    id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $stok->nama_barang) }}" required 
                                    style="border-radius: 10px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="satuan" class="form-label fw-bold text-secondary">Satuan</label>
                                <select class="form-select form-select-lg @error('satuan') is-invalid @enderror" id="satuan" name="satuan" required style="border-radius: 10px;">
                                    <option value="pcs" {{ old('satuan', $stok->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="liter" {{ old('satuan', $stok->satuan) == 'liter' ? 'selected' : '' }}>Liter</option>
                                    <option value="botol" {{ old('satuan', $stok->satuan) == 'botol' ? 'selected' : '' }}>Botol</option>
                                    <option value="set" {{ old('satuan', $stok->satuan) == 'set' ? 'selected' : '' }}>Set</option>
                                    <option value="box" {{ old('satuan', $stok->satuan) == 'box' ? 'selected' : '' }}>Box</option>
                                    <option value="meter" {{ old('satuan', $stok->satuan) == 'meter' ? 'selected' : '' }}>Meter</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="jumlah" class="form-label fw-bold text-secondary">Total Stok</label>
                                <input type="number" class="form-control form-control-lg @error('jumlah') is-invalid @enderror" 
                                    id="jumlah" name="jumlah" value="{{ old('jumlah', $stok->jumlah) }}" min="0" required style="border-radius: 10px;">
                                <div class="form-text mt-2 text-info small"><i class="bi bi-info-circle me-1"></i>Menambah stok akan mencatat transaksi pembelian.</div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-secondary">Nomor Seri (Terkunci)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg bg-light text-muted border-start-0" 
                                        value="{{ $stok->nomor_seri }}" readonly 
                                        style="border-radius: 0 10px 10px 0; font-family: monospace;">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="harga_beli" class="form-label fw-bold text-secondary">Harga Beli</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">Rp</span>
                                    <input type="number" class="form-control form-control-lg border-start-0 @error('harga_beli') is-invalid @enderror" 
                                        id="harga_beli" name="harga_beli" value="{{ old('harga_beli', (int)$stok->harga_beli) }}" min="0" required style="border-radius: 0 10px 10px 0;">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="harga_jual" class="form-label fw-bold text-secondary">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">Rp</span>
                                    <input type="number" class="form-control form-control-lg border-start-0 @error('harga_jual') is-invalid @enderror" 
                                        id="harga_jual" name="harga_jual" value="{{ old('harga_jual', (int)$stok->harga_jual) }}" min="0" required style="border-radius: 0 10px 10px 0;">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-bold text-secondary">Keterangan (Opsional)</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                name="keterangan" rows="3" placeholder="Tambahkan catatan..."
                                style="border-radius: 10px;">{{ old('keterangan', $stok->keterangan) }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('admin.stok.index') }}" class="btn btn-light btn-lg px-4 me-md-2" style="border-radius: 10px; font-weight: 600;">Batal</a>
                            <button type="submit" class="btn btn-modern btn-lg px-5 save-confirm" data-message="Simpan perubahan data barang ini?">Update Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection