@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Daftar Servis (Dikerjakan)</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Keluhan</th>
                            <th>Waktu Booking</th>
                            <th>Waktu Mulai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servis as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->booking->user->nama ?? '-' }}</td>
                                <td>{{ $item->booking->kendaraan->merk ?? '-' }}
                                    {{ $item->booking->kendaraan->model ?? '-' }}<br>{{ $item->booking->kendaraan->plat_nomor ?? '-' }}
                                </td>
                                <td>{{ $item->booking->keluhan }}</td>
                                <td>
                                    <div><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($item->booking->tanggal_booking)->format('d M Y') }}</div>
                                    <div class="text-primary"><i class="bi bi-clock me-1"></i>{{ $item->booking->jam_booking ?? '-' }}</div>
                                </td>
                                <td>
                                    @if($item->waktu_mulai)
                                        <div class="text-success fw-bold">{{ $item->waktu_mulai->format('H:i') }} WIB</div>
                                        <small class="text-muted">{{ $item->waktu_mulai->diffForHumans() }}</small>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('mekanik.servis.detail', $item->id) }}"
                                            class="btn btn-info btn-sm text-white" data-bs-toggle="tooltip"
                                            title="Lihat Detail & Tambah Barang">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <form action="{{ route('mekanik.servis.update', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah servis ini sudah selesai?');" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                                title="Tandai Selesai">
                                                <i class="bi bi-check-circle"></i> Selesai
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada servis yang sedang dikerjakan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection