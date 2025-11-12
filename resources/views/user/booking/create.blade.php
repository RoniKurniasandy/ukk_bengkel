@extends('layouts.app')

@section('title', 'Tambah Booking Servis')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Booking Servis</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('user.booking.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kendaraan_id" class="form-label">Pilih Kendaraan</label>
                    <select name="kendaraan_id" id="kendaraan_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Kendaraan --</option>
                        @foreach($kendaraan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kendaraan }} - {{ $item->no_polisi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                    <select name="jenis_layanan" id="jenis_layanan" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Jenis Layanan --</option>
                        <option value="servis mesin">Servis Mesin</option>
                        <option value="listrik">Servis Kelistrikan</option>
                        <option value="tune up">Tune Up</option>
                        <option value="ganti oli">Ganti Oli</option>
                        <option value="aki">Ganti Aki</option>
                        <option value="ganti ban">Ganti Ban</option>
                        <option value="servis AC">Servis AC</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keluhan" class="form-label">Keluhan</label>
                    <textarea name="keluhan" id="keluhan" class="form-control" rows="3" placeholder="Tuliskan keluhan kendaraan..."></textarea>
                </div>

                <div class="mb-3">
                    <label for="tanggal_booking" class="form-label">Tanggal & Waktu Booking</label>
                    <input type="datetime-local" name="tanggal_booking" id="tanggal_booking" class="form-control" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('user.booking.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
