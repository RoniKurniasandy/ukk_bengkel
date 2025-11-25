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
                    <input type="text" class="form-control" value="{{ $booking->kendaraan->merek ?? '-' }} - {{ $booking->kendaraan->model ?? '-' }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea class="form-control" rows="3" disabled>{{ $booking->keluhan }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" id="statusSelect" {{ in_array($booking->status, ['selesai', 'ditolak', 'dibatalkan']) ? 'disabled' : '' }}>
                        <option value="menunggu" {{ $booking->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ $booking->status == 'disetujui' ? 'selected' : '' }}>Disetujui (Proses)</option>
                        <option value="ditolak" {{ $booking->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="selesai" {{ $booking->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @if(in_array($booking->status, ['selesai', 'ditolak', 'dibatalkan']))
                        <input type="hidden" name="status" value="{{ $booking->status }}">
                    @endif
                </div>

                <div class="mb-3" id="mekanikField">
                    <label class="form-label">Pilih Mekanik</label>
                    <select name="mekanik_id" class="form-select" {{ in_array($booking->status, ['selesai', 'ditolak', 'dibatalkan']) ? 'disabled' : '' }}>
                        <option value="">-- Pilih Mekanik --</option>
                        @foreach($mekanik as $m)
                            <option value="{{ $m->id }}" {{ (optional($booking->servis)->mekanik_id == $m->id) ? 'selected' : '' }}>
                                {{ $m->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Wajib dipilih jika status "Disetujui"</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.servis.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Simple script to show/hide mekanik field based on status
    // Though backend validation handles it, UI feedback is nice
</script>
@endsection
