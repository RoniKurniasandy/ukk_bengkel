@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold">Daftar Booking Servis</h3>
            <a href="{{ route('user.booking.create') }}" class="btn btn-primary px-4">
                <i class="bi bi-plus-lg"></i> Booking Baru
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> <strong>Info:</strong> Halaman ini hanya menampilkan booking yang
            <strong>belum disetujui</strong>.
            Untuk melihat servis yang sudah disetujui/dikerjakan, silakan ke menu <a href="{{ route('user.servis') }}"
                class="alert-link"><strong>Servis Saya</strong></a>.
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Layanan Servis</th>
                            <th>Waktu Booking</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bookings as $b)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $b->layanan->nama_layanan ?? 'Umum' }}</td>
                                <td>
                                    <div>
                                        <i
                                            class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d M Y') }}
                                    </div>
                                    <div class="text-primary">
                                        <i class="bi bi-clock me-1"></i><strong>{{ $b->jam_booking ?? '-' }}</strong> WIB
                                    </div>
                                </td>
                                <td>
                                    @if($b->status == 'disetujui')
                                        <div class="d-flex flex-column align-items-start">
                                            <span class="badge bg-warning text-dark mb-1">
                                                <i class="bi bi-check-circle-fill"></i> Disetujui
                                            </span>
                                            <small class="text-danger fw-bold" style="font-size: 0.75rem;">
                                                <i class="bi bi-hourglass-split"></i> Menunggu Mekanik
                                            </small>
                                        </div>
                                    @elseif($b->status == 'menunggu')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-hourglass-top"></i> Menunggu Konfirmasi
                                        </span>
                                    @elseif($b->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @elseif($b->status == 'dibatalkan')
                                        <span class="badge bg-secondary">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($b->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($b->status == 'menunggu')
                                        <form method="POST" action="{{ route('user.booking.destroy', $b->booking_id) }}"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-confirm"
                                                data-message="Yakin ingin membatalkan booking servis ini?">
                                                <i class="bi bi-x-circle"></i> Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td class="text-center py-4" colspan="5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Tidak ada booking yang menunggu konfirmasi.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection