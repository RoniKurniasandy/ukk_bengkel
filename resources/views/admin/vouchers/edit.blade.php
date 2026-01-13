@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mt-4">Edit Voucher</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}">Voucher</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>Edit Data Voucher</h5>
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

                    <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="kode" class="form-label fw-bold">Kode Voucher</label>
                            <input type="text" class="form-control form-control-lg text-uppercase fw-bold font-monospace" id="kode" name="kode" value="{{ old('kode', $voucher->kode) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipe_diskon" class="form-label">Tipe Diskon</label>
                                <select class="form-select" id="tipe_diskon" name="tipe_diskon" required>
                                    <option value="nominal" {{ old('tipe_diskon', $voucher->tipe_diskon) == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                    <option value="persen" {{ old('tipe_diskon', $voucher->tipe_diskon) == 'persen' ? 'selected' : '' }}>Persentase (%)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nilai" class="form-label">Nilai Potongan</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="addon-nilai">
                                        {{ old('tipe_diskon', $voucher->tipe_diskon) == 'persen' ? '%' : 'Rp' }}
                                    </span>
                                    <input type="number" class="form-control" id="nilai" name="nilai" value="{{ old('nilai', $voucher->nilai) }}" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="min_transaksi" class="form-label">Minimal Belanja</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="min_transaksi" name="min_transaksi" value="{{ old('min_transaksi', $voucher->min_transaksi) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kuota" class="form-label">Kuota Penggunaan</label>
                                <input type="number" class="form-control" id="kuota" name="kuota" value="{{ old('kuota', $voucher->kuota) }}" min="0">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai', $voucher->tgl_mulai ? $voucher->tgl_mulai->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                                <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir" value="{{ old('tgl_berakhir', $voucher->tgl_berakhir ? $voucher->tgl_berakhir->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $voucher->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktifkan Voucher Ini</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 save-confirm" data-message="Simpan perubahan voucher ini?"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
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
