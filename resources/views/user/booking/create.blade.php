@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-lg border-0 p-4">
        <h3 class="fw-bold mb-3">Booking Servis Baru</h3>

        <form action="{{ route('user.booking.store') }}" method="POST">
            @csrf


            <div class="mb-3">
                <label class="fw-semibold">Layanan Servis</label>
                <select name="jenis_servis" class="form-select" required>
                    <option value="">-- Pilih Layanan Servis --</option>
                    <option value="Servis Listrik">Servis Listrik</option>
                    <option value="Tune Up">Tune Up</option>
                    <option value="Ganti Oli">Ganti Oli</option>
                    <option value="Ganti Aki">Ganti Aki</option>
                    <option value="Ganti Ban">Ganti Ban</option>
                    <option value="Servis AC">Servis AC</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="kendaraan_id" class="form-label">Pilih Kendaraan</label>
                <select name="kendaraan_id" class="form-control" required>
                    @foreach ($kendaraan as $k)
                    <option value="{{ $k->id }}">{{ $k->model }} - {{ $k->plat_nomor }}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label class="fw-semibold">Tanggal Booking</label>
                <input type="date" name="tanggal_booking" class="form-control"
                    min="{{ date('Y-m-d') }}" required>
            </div>


            <div class="mb-3">
                <label class="fw-semibold">Keluhan Kendaraan</label>
                <textarea name="keluhan" class="form-control" rows="4" required></textarea>
            </div>

            <button class="btn btn-primary px-4">Kirim Booking</button>
            <a href="{{ route('user.booking.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

</div>
@endsection