@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Riwayat Servis Kendaraan</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kendaraan</th>
                <th>Kerusakan</th>
                <th>Status</th>
                <th>Tanggal Servis</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($servis as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->booking->kendaraan->merek }} - {{ $item->booking->kendaraan->model }}</td>
                <td>{{ $item->booking->keluhan }}</td>
                <td>
                    <span class="badge bg-primary">{{ $item->status }}</span>
                </td>
                <td>{{ $item->tanggal_servis ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada riwayat servis.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
