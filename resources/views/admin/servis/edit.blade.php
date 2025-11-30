@extends('layouts.app')

@section('title', 'Edit Data Servis')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Edit Data Servis / Konfirmasi Booking</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.servis.update', $item->booking_id ?? $booking->booking_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <input type="text" class="form-control" value="{{ $booking->user->name ?? '-' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kendaraan</label>
                        <input type="text" class="form-control"
                            value="{{ $booking->kendaraan->merek ?? '-' }} - {{ $booking->kendaraan->model ?? '-' }}"
                            disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keluhan</label>
                        <textarea class="form-control" rows="3" disabled>{{ $booking->keluhan }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Saat Ini</label>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                @if($booking->status == 'menunggu')
                                    <span class="badge bg-warning text-dark fs-6">Menunggu Konfirmasi</span>
                                @elseif($booking->status == 'disetujui')
                                    <span class="badge bg-info text-dark fs-6">Disetujui - Sedang Proses</span>
                                @elseif($booking->status == 'selesai')
                                    <span class="badge bg-success fs-6">Selesai</span>
                                @elseif($booking->status == 'ditolak')
                                    <span class="badge bg-danger fs-6">Ditolak</span>
                                @elseif($booking->status == 'dibatalkan')
                                    <span class="badge bg-secondary fs-6">Dibatalkan</span>
                                @endif
                            </div>
                        </div>

                        {{-- Time Tracking Info --}}
                        @if($booking->servis)
                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body py-2">
                                    <div class="row text-center">
                                        <div class="col-md-4 border-end">
                                            <small class="text-muted d-block">Waktu Mulai</small>
                                            <strong>{{ $booking->servis->waktu_mulai ? $booking->servis->waktu_mulai->format('H:i') : '-' }}</strong>
                                        </div>
                                        <div class="col-md-4 border-end">
                                            <small class="text-muted d-block">Waktu Selesai</small>
                                            <strong>{{ $booking->servis->waktu_selesai ? $booking->servis->waktu_selesai->format('H:i') : '-' }}</strong>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Durasi</small>
                                            @if($booking->servis->waktu_mulai && $booking->servis->waktu_selesai)
                                                <strong class="text-success">
                                                    {{ $booking->servis->waktu_mulai->diffForHumans($booking->servis->waktu_selesai, true) }}
                                                </strong>
                                            @elseif($booking->servis->waktu_mulai)
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
                        @endif
                    </div>

                    @if($booking->status == 'menunggu')
                        <!-- Form untuk menyetujui dengan assign mekanik -->
                        <div class="mb-3">
                            <label class="form-label">Pilih Mekanik <span class="text-danger">*</span></label>
                            <select name="mekanik_id" class="form-select" required>
                                <option value="">-- Pilih Mekanik --</option>
                                @foreach($mekanik as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Wajib dipilih untuk menyetujui booking</small>
                        </div>

                        <input type="hidden" name="status" value="disetujui">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.servis.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <div>
                                <button type="submit" class="btn btn-success me-2">
                                    <i class="bi bi-check-circle"></i> Setujui & Assign Mekanik
                                </button>
                                <button type="button" class="btn btn-danger"
                                    onclick="if(confirm('Tolak booking ini?')) { document.getElementById('formTolak').submit(); }">
                                    <i class="bi bi-x-circle"></i> Tolak Booking
                                </button>
                            </div>
                        </div>
                    @elseif($booking->status == 'disetujui')
                        <div class="mb-3">
                            <label class="form-label">Mekanik yang Ditugaskan</label>
                            <input type="text" class="form-control"
                                value="{{ $booking->servis->mekanik->nama ?? 'Belum ada mekanik' }}" disabled>
                        </div>

                        @if($booking->servis && $booking->servis->mekanik_id)
                            <input type="hidden" name="status" value="selesai">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.servis.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary"
                                    onclick="return confirm('Tandai servis ini sebagai selesai?')">
                                    <i class="bi bi-check-circle-fill"></i> Tandai Selesai
                                </button>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                Mekanik belum ditugaskan. Tidak dapat menyelesaikan servis.
                            </div>
                            <a href="{{ route('admin.servis.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        @endif
                    @else
                        <!-- Status sudah final (selesai, ditolak, dibatalkan) -->
                        <div class="alert alert-info">
                            Status sudah final dan tidak dapat diubah.
                        </div>
                        <a href="{{ route('admin.servis.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    @endif
                </form>

                <!-- Form tersembunyi untuk tolak booking -->
                @if($booking->status == 'menunggu')
                    <form id="formTolak" action="{{ route('admin.servis.updateStatus', $booking->booking_id) }}" method="POST"
                        style="display: none;">
                        @csrf
                        <input type="hidden" name="status" value="ditolak">
                    </form>
                @endif
            </div>
        </div>

        {{-- Items Management Section --}}
        @if($booking->servis && $booking->status != 'ditolak' && $booking->status != 'dibatalkan')
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
                    @if($booking->status != 'selesai')
                        <form action="{{ route('admin.servis.addItem', $booking->booking_id) }}" method="POST" class="mb-4">
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
                    @if($booking->servis->detailServis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                        @if($booking->status != 'selesai')
                                            <th class="text-center">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->servis->detailServis as $index => $detail)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $detail->stok->nama_barang }}</td>
                                            <td>{{ $detail->jumlah }} {{ $detail->stok->satuan }}</td>
                                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                            @if($booking->status != 'selesai')
                                                <td class="text-center">
                                                    <form action="{{ route('admin.servis.removeItem', $detail->id) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Hapus barang ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
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
                                        <td colspan="{{ $booking->status != 'selesai' ? 2 : 1 }}">
                                            <strong>Rp
                                                {{ number_format($booking->servis->estimasi_biaya ?? 0, 0, ',', '.') }}</strong>
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
        @endif
    </div>

    <script>
        // Simple script to show/hide mekanik field based on status
        // Though backend validation handles it, UI feedback is nice
    </script>
@endsection