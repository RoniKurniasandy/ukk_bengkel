<!-- @extends('layouts.app')

@section('title', 'Tambah Booking')

@section('content')
<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah Booking Servis</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.booking.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Pelanggan</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Kendaraan</label>
                <select name="kendaraan_id" class="form-select" required>
                    <option value="">-- Pilih Kendaraan --</option>
                    @foreach($kendaraan as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kendaraan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Layanan</label>
                <select name="jenis_layanan" class="form-select" required>
                    <option value="">-- Pilih Layanan --</option>
                    @foreach(['servis mesin','listrik','tune up','ganti oli','aki','ganti ban','servis AC'] as $layanan)
                        <option value="{{ $layanan }}">{{ ucfirst($layanan) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Keluhan</label>
                <textarea name="keluhan" rows="3" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Booking</label>
                <input type="datetime-local" name="tanggal_booking" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="menunggu">Menunggu</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="dibatalkan">Dibatalkan</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-save"></i> Simpan
            </button>
        </form>
    </div>
</div>
@endsection -->
