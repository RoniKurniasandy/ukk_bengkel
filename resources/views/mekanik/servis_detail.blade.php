@extends('layouts.app')

@section('title', 'Detail Servis')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-tools"></i> Detail Servis</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Informasi Pelanggan</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="150">Nama</th>
                                <td>{{ $servis->booking->user->nama }}</td>
                            </tr>
                            <tr>
                                <th>No. HP</th>
                                <td>{{ $servis->booking->user->no_hp }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Informasi Kendaraan</h6>
                        <table class="table table-sm">
                            <tr>
                                <th width="150">Merek/Model</th>
                                <td>{{ $servis->booking->kendaraan->merk }} {{ $servis->booking->kendaraan->model }}</td>
                            </tr>
                            <tr>
                                <th>Plat Nomor</th>
                                <td>{{ $servis->booking->kendaraan->plat_nomor }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Keluhan</h6>
                    <p class="border p-3 rounded">{{ $servis->booking->keluhan }}</p>
                </div>

                <div class="mb-3">
                    <span class="badge {{ $servis->status == 'dikerjakan' ? 'bg-warning text-dark' : 'bg-success' }} fs-6">
                        {{ $servis->status == 'dikerjakan' ? 'Sedang Dikerjakan' : 'Selesai' }}
                    </span>
                </div>

                {{-- Time Tracking Info --}}
                <div class="card bg-light border-0 mb-3">
                    <div class="card-body py-2">
                        <div class="row text-center">
                            <div class="col-md-4 border-end">
                                <small class="text-muted d-block">Waktu Mulai</small>
                                <strong>{{ $servis->waktu_mulai ? $servis->waktu_mulai->format('H:i') : '-' }}</strong>
                            </div>
                            <div class="col-md-4 border-end">
                                <small class="text-muted d-block">Waktu Selesai</small>
                                <strong>{{ $servis->waktu_selesai ? $servis->waktu_selesai->format('H:i') : '-' }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Durasi</small>
                                @if($servis->waktu_mulai && $servis->waktu_selesai)
                                    <strong class="text-success">
                                        {{ $servis->waktu_mulai->diffForHumans($servis->waktu_selesai, true) }}
                                    </strong>
                                @elseif($servis->waktu_mulai)
                                    <strong class="text-primary">
                                        <i class="bi bi-stopwatch"></i> Berjalan...
                                    </strong>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Items Management Section --}}
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="bi bi-box-seam"></i> Barang Yang Digunakan</h5>
            </div>
            <div class="card-body">
                {{-- Alert Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Form to Add Item --}}
                @if($servis->status != 'selesai')
                    <form action="{{ route('mekanik.servis.addItem', $servis->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                <select name="stok_id" class="form-select" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($stokList as $item)
                                        <option value="{{ $item->stok_id }}">
                                            {{ $item->nama_barang }} - Stok: {{ $item->jumlah }} {{ $item->satuan }} - Rp
                                            {{ number_format($item->harga_jual, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah" class="form-control" min="1" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-circle"></i> Tambah Barang
                                </button>
                            </div>
                        </div>
                    </form>
                @endif

                {{-- Items List --}}
                @if($servis->detailServis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                    @if($servis->status != 'selesai')
                                        <th class="text-center">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servis->detailServis as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail->stok->nama_barang }}</td>
                                        <td>{{ $detail->jumlah }} {{ $detail->stok->satuan }}</td>
                                        <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        @if($servis->status != 'selesai')
                                            <td class="text-center">
                                                <form action="{{ route('mekanik.servis.removeItem', $detail->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-confirm" data-message="Hapus barang '{{ $detail->stok->nama_barang }}' dari daftar servis ini?" data-bs-toggle="tooltip"
                                                        title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                <tr class="table-primary">
                                    <td colspan="4" class="text-end"><strong>Total Estimasi Biaya:</strong></td>
                                    <td colspan="{{ $servis->status != 'selesai' ? 2 : 1 }}">
                                        <strong>Rp {{ number_format($servis->estimasi_biaya ?? 0, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        Belum ada barang yang ditambahkan.
                    </div>
                @endif
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('mekanik.servis.aktif') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    @if($servis->status == 'dikerjakan')
                        <form action="{{ route('mekanik.servis.update', $servis->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="button" class="btn btn-success save-confirm" data-message="Tandai servis ini sebagai selesai? Status akan berubah dan biaya akan final.">
                                <i class="bi bi-check-circle-fill"></i> Tandai Selesai
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection