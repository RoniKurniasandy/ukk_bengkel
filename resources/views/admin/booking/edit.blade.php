@extends('layouts.app')

@section('title', 'Ubah Status Booking')

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Ubah Status Booking #{{ $booking->booking_id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Pelanggan:</strong> {{ $booking->user->name }}</p>
            <p><strong>Kendaraan:</strong> {{ $booking->kendaraan->nama_kendaraan }}</p>
            <p><strong>Layanan:</strong> {{ ucfirst($booking->jenis_layanan) }}</p>
            <p><strong>Keluhan:</strong> {{ $booking->keluhan ?? '-' }}</p>

            <form action="{{ route('admin.booking.update', $booking->booking_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Pilih Status</label>
                    <select name="status" id="status" class="form-select" required>
                        @foreach($statusOptions as $status)
                            <option value="{{ $status }}" {{ $booking->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.booking') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
