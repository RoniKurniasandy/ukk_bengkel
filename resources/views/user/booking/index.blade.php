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
            Untuk melihat servis yang sudah disetujui/dikerjakan, silakan ke menu <a href="{{ route('user.servis.index') }}"
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
                                    <span class="badge 
                                                @if($b->status == 'menunggu') bg-warning text-dark
                                                @elseif($b->status == 'ditolak') bg-danger
                                                @elseif($b->status == 'dibatalkan') bg-secondary
                                                @endif
                                            ">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($b->status == 'menunggu')
                                        <form method="POST" action="{{ route('user.booking.destroy', $b->booking_id) }}"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin membatalkan booking ini?')">
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