@extends('layouts.app')

@section('title', 'Data Booking Servis')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Booking Servis</h4>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No.</th>
                            <th>Nama Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Layanan</th>
                            <th>Keluhan</th>
                            <th>Tanggal Booking</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                        <tr>
                            <td class="fw-semibold">#{{ $booking->booking_id }}</td>
                            <td>{{ $booking->user->name ?? '-' }}</td>
                            <td>{{ $booking->kendaraan->nama_kendaraan ?? '-' }}</td>
                            <td class="text-capitalize">{{ $booking->jenis_layanan }}</td>
                            <td>{{ $booking->keluhan ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y, H:i') }}</td>
                            <td class="text-center">
                                @if($booking->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($booking->status == 'disetujui')
                                    <span class="badge bg-primary">Disetujui</span>
                                @elseif($booking->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($booking->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($booking->status == 'dibatalkan')
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @else
                                    <span class="badge bg-light text-dark">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.booking.edit', $booking->booking_id) }}" 
                                   class="btn btn-sm btn-warning">
                                   <i class="fas fa-edit"></i> Ubah Status
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data booking</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
