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
                            <th>Tanggal Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servis as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->booking->user->nama ?? '-' }}</td>
                                <td>{{ $item->booking->kendaraan->merk ?? '-' }} {{ $item->booking->kendaraan->model ?? '-' }}<br>{{ $item->booking->kendaraan->plat_nomor ?? '-' }}</td>
                                <td>{{ $item->booking->keluhan }}</td>
                                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('mekanik.servis.update', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah servis ini sudah selesai?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Selesai
                                        </button>
                                    </form>
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