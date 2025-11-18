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

    <div class="card shadow-lg border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Layanan Servis</th>
                        <th>Tanggal Booking</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bookings->where('status', '!=', 'selesai') as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $b->jenis_layanan }}</td>
                        <td>{{ $b->tanggal_booking }}</td>
                        <td>
                            <span class="badge 
                                @if($b->status == 'menunggu') bg-warning 
                                @elseif($b->status == 'disetujui') bg-info
                                @elseif($b->status == 'ditolak') bg-danger
                                @elseif($b->status == 'dibatalkan') bg-secondary
                                @endif
                            ">
                                {{ ucfirst($b->status) }}
                            </span>
                        </td>
                        <td>
                            @if($b->status == 'menunggu')
                            <form method="POST" action="{{ route('user.booking.destroy', $b->booking_id) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-x-circle"></i> Batalkan
                                </button>
                            </form>
                            @else
                            -
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="5">Belum ada booking servis</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection