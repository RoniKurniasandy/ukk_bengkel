@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Riwayat Servis Selesai</h3>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Keluhan</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
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
                                <td>{{ $item->updated_at->format('d M Y H:i') }}</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada riwayat servis selesai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection