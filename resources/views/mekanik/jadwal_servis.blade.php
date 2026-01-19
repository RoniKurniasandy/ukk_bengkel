@extends('layouts.app')

@section('title', 'Jadwal Servis')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold"><i class="bi bi-calendar-check"></i> Jadwal Servis</h3>
        </div>


        <div class="card shadow-lg border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>No</th>
                            <th>Tanggal & Jam</th>
                            <th>Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Layanan</th>
                            <th>Estimasi Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $b)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div><i class="bi bi-calendar3 me-1"></i>
                                        {{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d M Y') }}</div>
                                    <div class="text-primary"><i class="bi bi-clock me-1"></i> {{ $b->jam_booking ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    {{ $b->user->nama ?? '-' }}<br>
                                    <small class="text-muted">{{ $b->user->no_hp ?? '-' }}</small>
                                </td>
                                <td>
                                    {{ $b->kendaraan->merk }} {{ $b->kendaraan->model }}<br>
                                    <small class="text-muted">{{ $b->kendaraan->plat_nomor }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $b->layanan->nama_layanan ?? '-' }}</span><br>
                                    <small class="text-muted">Biaya: Rp
                                        {{ number_format($b->layanan->harga ?? 0, 0, ',', '.') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass-split"></i> {{ $b->layanan->estimasi_waktu ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('mekanik.booking.start', $b->booking_id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success"
                                            onclick="return confirm('Mulai mengerjakan servis ini?')">
                                            <i class="bi bi-play-circle"></i> Kerjakan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center py-4" colspan="7">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Belum ada jadwal servis. Booking yang disetujui admin akan muncul di sini.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($bookings->count() > 0)
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle"></i> <strong>Info:</strong>
                Klik tombol "Kerjakan" untuk memulai servis. Setelah itu, servis akan muncul di halaman "Servis Dikerjakan".
            </div>
        @endif
    </div>
@endsection