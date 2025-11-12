@extends('admin.layouts.app')

@section('title', 'Detail Sparepart')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-info text-white py-3 px-4">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i> Detail Sparepart</h5>
        </div>

        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Kode Sparepart</h6>
                    <p class="fs-5 fw-semibold">{{ $sparepart->kode_sparepart }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6 class="text-muted mb-1">Nama Sparepart</h6>
                    <p class="fs-5 fw-semibold">{{ $sparepart->nama_sparepart }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <h6 class="text-muted mb-1">Stok</h6>
                    @if($sparepart->stok > 10)
                        <span class="badge bg-success px-3 py-2 fs-6">{{ $sparepart->stok }}</span>
                    @elseif($sparepart->stok > 0)
                        <span class="badge bg-warning text-dark px-3 py-2 fs-6">{{ $sparepart->stok }}</span>
                    @else
                        <span class="badge bg-danger px-3 py-2 fs-6">Habis</span>
                    @endif
                </div>
                <div class="col-md-4 mb-3">
                    <h6 class="text-muted mb-1">Harga</h6>
                    <p class="fs-5 fw-semibold text-primary">Rp {{ number_format($sparepart->harga, 0, ',', '.') }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h6 class="text-muted mb-1">Dibuat pada</h6>
                    <p class="fs-6">{{ $sparepart->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-muted mb-1">Keterangan</h6>
                <p class="fs-6">{{ $sparepart->keterangan ?? '-' }}</p>
            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.sparepart.edit', $sparepart->id) }}" class="btn btn-warning text-dark">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <form action="{{ route('admin.sparepart.destroy', $sparepart->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin ingin menghapus sparepart ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </form>
                <a href="{{ route('admin.sparepart.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
