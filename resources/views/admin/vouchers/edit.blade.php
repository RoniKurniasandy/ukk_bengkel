@extends('layouts.app')

@section('title', 'Edit Voucher')

@section('content')
<div class="container-fluid px-4">
    <div class="user-management-header mb-4"
        style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                        class="bi bi-pencil-square me-2"></i>Edit Voucher</h2>
                <p class="text-white-50 m-0 mt-2">Ubah informasi kode promo: <span class="text-white fw-bold">{{ $voucher->kode }}</span></p>
            </div>
            <a href="{{ route('admin.vouchers.index') }}"
                class="btn btn-light text-primary fw-bold mt-3 mt-md-0 shadow-sm" style="border-radius: 10px;">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
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

                    <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="kode" class="form-label fw-bold text-secondary">Kode Voucher</label>
                            <input type="text" class="form-control form-control-lg text-uppercase fw-bold font-monospace @error('kode') is-invalid @enderror" 
                                id="kode" name="kode" value="{{ old('kode', $voucher->kode) }}" required 
                                style="border-radius: 10px; letter-spacing: 2px; color: #667eea;">
                            <div class="form-text mt-2">Kode voucher bersifat unik dan digunakan pelanggan saat pembayaran.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="tipe_diskon" class="form-label fw-bold text-secondary">Tipe Diskon</label>
                                <select class="form-select form-select-lg @error('tipe_diskon') is-invalid @enderror" id="tipe_diskon" name="tipe_diskon" required style="border-radius: 10px;">
                                    <option value="nominal" {{ old('tipe_diskon', $voucher->tipe_diskon) == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                    <option value="persen" {{ old('tipe_diskon', $voucher->tipe_diskon) == 'persen' ? 'selected' : '' }}>Persentase (%)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="nilai" class="form-label fw-bold text-secondary">Nilai Potongan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" id="addon-nilai" style="border-radius: 10px 0 0 10px;">
                                        {{ old('tipe_diskon', $voucher->tipe_diskon) == 'persen' ? '%' : 'Rp' }}
                                    </span>
                                    <input type="number" class="form-control form-control-lg border-start-0 @error('nilai') is-invalid @enderror" 
                                        id="nilai" name="nilai" value="{{ old('nilai', $voucher->nilai) }}" min="0" required style="border-radius: 0 10px 10px 0;">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="min_transaksi" class="form-label fw-bold text-secondary">Minimal Belanja</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">Rp</span>
                                    <input type="number" class="form-control form-control-lg border-start-0 @error('min_transaksi') is-invalid @enderror" 
                                        id="min_transaksi" name="min_transaksi" value="{{ old('min_transaksi', $voucher->min_transaksi) }}" min="0" style="border-radius: 0 10px 10px 0;">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="kuota" class="form-label fw-bold text-secondary">Kuota Penggunaan</label>
                                <input type="number" class="form-control form-control-lg @error('kuota') is-invalid @enderror" 
                                    id="kuota" name="kuota" value="{{ old('kuota', $voucher->kuota) }}" min="0" style="border-radius: 10px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="tgl_mulai" class="form-label fw-bold text-secondary">Tanggal Mulai</label>
                                <input type="date" class="form-control form-control-lg @error('tgl_mulai') is-invalid @enderror" 
                                    id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai', $voucher->tgl_mulai ? $voucher->tgl_mulai->format('Y-m-d') : '') }}" style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="tgl_berakhir" class="form-label fw-bold text-secondary">Tanggal Berakhir</label>
                                <input type="date" class="form-control form-control-lg @error('tgl_berakhir') is-invalid @enderror" 
                                    id="tgl_berakhir" name="tgl_berakhir" value="{{ old('tgl_berakhir', $voucher->tgl_berakhir ? $voucher->tgl_berakhir->format('Y-m-d') : '') }}" style="border-radius: 10px;">
                            </div>
                        </div>

                        <div class="form-check form-switch mb-5">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $voucher->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-secondary" for="is_active">Aktifkan Voucher Ini</label>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-light btn-lg px-4 me-md-2" style="border-radius: 10px; font-weight: 600;">Batal</a>
                            <button type="submit" class="btn btn-modern btn-lg px-5 save-confirm" data-message="Simpan perubahan voucher ini?">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('tipe_diskon').addEventListener('change', function() {
        const addon = document.getElementById('addon-nilai');
        if (this.value === 'persen') {
            addon.textContent = '%';
        } else {
            addon.textContent = 'Rp';
        }
    });
</script>
@endsection
