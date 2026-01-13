@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mt-4">Buat Voucher Baru</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Voucher</a></li>
                <li class="breadcrumb-item active">Buat Baru</li>
            </ol>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-ticket-plus me-2"></i>Form Voucher</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.vouchers.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="kode" class="form-label fw-bold">Kode Voucher</label>
                            <input type="text" class="form-control form-control-lg text-uppercase fw-bold font-monospace" id="kode" name="kode" value="{{ old('kode') }}" placeholder="CONTOH: PROMO10" required>
                            <div class="form-text">Gunakan huruf kapital dan angka. Kode harus unik.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipe_diskon" class="form-label">Tipe Diskon</label>
                                <select class="form-select" id="tipe_diskon" name="tipe_diskon" required>
                                    <option value="nominal" {{ old('tipe_diskon') == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                    <option value="persen" {{ old('tipe_diskon') == 'persen' ? 'selected' : '' }}>Persentase (%)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nilai" class="form-label">Nilai Potongan</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="addon-nilai">Rp</span>
                                    <input type="number" class="form-control" id="nilai" name="nilai" value="{{ old('nilai', 0) }}" min="0" required>
                                </div>
                                <div class="form-text">Jika persen, masukkan angka 1-100.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="min_transaksi" class="form-label">Minimal Belanja</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="min_transaksi" name="min_transaksi" value="{{ old('min_transaksi', 0) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kuota" class="form-label">Kuota Penggunaan</label>
                                <input type="number" class="form-control" id="kuota" name="kuota" value="{{ old('kuota', 100) }}" min="0">
                                <div class="form-text">Masukkan jumlah maksimal voucher bisa digunakan.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tgl_mulai" class="form-label">Tanggal Mulai (Opsional)</label>
                                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tgl_berakhir" class="form-label">Tanggal Berakhir (Opsional)</label>
                                <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir" value="{{ old('tgl_berakhir') }}">
                            </div>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Aktifkan Voucher Ini</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 save-confirm" data-message="Simpan data voucher ini?"><i class="bi bi-save me-1"></i> Simpan Voucher</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple script to switch addon text based on type
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
