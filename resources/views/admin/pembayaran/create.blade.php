@extends('layouts.app')

@section('title', 'Input Pembayaran Manual')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-cash-coin me-2"></i>Input Pembayaran Manual (Kasir)</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Pelanggan:</strong> {{ $servis->booking->user->nama }}<br>
                                    <strong>Kendaraan:</strong> {{ $servis->booking->kendaraan->plat_nomor }}
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <strong>Total Biaya:</strong> Rp
                                    {{ number_format($servis->estimasi_biaya, 0, ',', '.') }}<br>
                                    <strong class="text-danger">Sisa Tagihan: Rp
                                        {{ number_format($sisaTagihan, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.pembayaran.store', $servis->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                                        value="{{ $sisaTagihan }}" min="1" required>
                                </div>
                                <small class="text-muted">Masukkan jumlah uang yang diterima.</small>
                            </div>

                            <div class="mb-3">
                                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                    <option value="tunai">Tunai (Cash)</option>
                                    <option value="transfer">Transfer Manual</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan (Opsional)</label>
                                <textarea name="catatan" id="catatan" class="form-control" rows="2"
                                    placeholder="Contoh: Diterima oleh Admin A"></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle"></i> Proses Pembayaran
                                </button>
                                <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection