@extends('layouts.app')

@section('title', 'Tambah Stok Baru')

@section('content')
<div class="container-fluid px-4">
    <div class="user-management-header mb-4"
        style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                        class="bi bi-plus-circle me-2"></i>Tambah Stok</h2>
                <p class="text-white-50 m-0 mt-2">Daftarkan sparepart atau barang baru ke sistem</p>
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

                    <form action="{{ route('admin.stok.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="kode_barang" class="form-label fw-bold text-secondary">Kode Barang / SKU</label>
                                <input type="text" class="form-control form-control-lg @error('kode_barang') is-invalid @enderror" 
                                    id="kode_barang" name="kode_barang" value="{{ old('kode_barang') }}" placeholder="Contoh: OIL-10W40" required 
                                    style="border-radius: 10px;">
                                <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Kode unik untuk identifikasi internal.</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="nama_barang" class="form-label fw-bold text-secondary">Nama Barang</label>
                                <input type="text" class="form-control form-control-lg @error('nama_barang') is-invalid @enderror" 
                                    id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" placeholder="Nama lengkap sparepart" required 
                                    style="border-radius: 10px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="satuan" class="form-label fw-bold text-secondary">Satuan</label>
                                <select class="form-select form-select-lg @error('satuan') is-invalid @enderror" id="satuan" name="satuan" required style="border-radius: 10px;">
                                    <option value="" disabled selected>Pilih Satuan</option>
                                    <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                                    <option value="botol" {{ old('satuan') == 'botol' ? 'selected' : '' }}>Botol</option>
                                    <option value="set" {{ old('satuan') == 'set' ? 'selected' : '' }}>Set</option>
                                    <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>Box</option>
                                    <option value="meter" {{ old('satuan') == 'meter' ? 'selected' : '' }}>Meter</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="jumlah" class="form-label fw-bold text-secondary">Stok Awal</label>
                                <input type="number" class="form-control form-control-lg @error('jumlah') is-invalid @enderror" 
                                    id="jumlah" name="jumlah" value="{{ old('jumlah', 0) }}" min="0" required style="border-radius: 10px;">
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold text-secondary">Nomor Seri</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-upc-scan"></i>
                                    </span>
                                    <div id="serial_preview" class="form-control form-control-lg bg-light text-muted border-start-0" 
                                        style="border-radius: 0 10px 10px 0; font-size: 0.9rem; padding-top: 0.8rem;">
                                        Otomatis...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="harga_beli" class="form-label fw-bold text-secondary">Harga Beli</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">Rp</span>
                                    <input type="number" class="form-control form-control-lg border-start-0 @error('harga_beli') is-invalid @enderror" 
                                        id="harga_beli" name="harga_beli" value="{{ old('harga_beli', 0) }}" min="0" required style="border-radius: 0 10px 10px 0;">
                                </div>
                                <div class="form-text mt-2">Harga modal per item.</div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="harga_jual" class="form-label fw-bold text-secondary">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">Rp</span>
                                    <input type="number" class="form-control form-control-lg border-start-0 @error('harga_jual') is-invalid @enderror" 
                                        id="harga_jual" name="harga_jual" value="{{ old('harga_jual', 0) }}" min="0" required style="border-radius: 0 10px 10px 0;">
                                </div>
                                <div class="form-text mt-2">Harga ke pelanggan.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-bold text-secondary">Keterangan (Opsional)</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                name="keterangan" rows="3" placeholder="Contoh: Lokasi rak, rak A-01"
                                style="border-radius: 10px;">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('admin.stok.index') }}" class="btn btn-light btn-lg px-4 me-md-2" style="border-radius: 10px; font-weight: 600;">Batal</a>
                            <button type="submit" class="btn btn-modern btn-lg px-5">Simpan Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeInp = document.getElementById('kode_barang');
        const nameInp = document.getElementById('nama_barang');
        const preview = document.getElementById('serial_preview');

        function updatePreview() {
            const code = codeInp.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
            const name = nameInp.value;
            
            if (code && name) {
                let initials = name.split(/[\s-_]+/).map(w => w[0]).join('').toUpperCase();
                if (initials.length < 2) {
                    initials = name.replace(/[^A-Za-z0-9]/g, '').substring(0, 3).toUpperCase();
                }
                preview.textContent = `${code}-${initials}-XXXX`;
                preview.classList.remove('text-muted');
                preview.classList.add('text-primary', 'fw-bold');
            } else {
                preview.textContent = "Otomatis...";
                preview.classList.remove('text-primary', 'fw-bold');
                preview.classList.add('text-muted');
            }
        }

        codeInp.addEventListener('input', updatePreview);
        nameInp.addEventListener('input', updatePreview);
    });
</script>
@endsection