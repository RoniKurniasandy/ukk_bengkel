@extends('layouts.app')

@section('title', 'Manajemen Servis')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Manajemen Servis</h4>
        </div>

        <div class="card-body">
            <!-- Filter Tabs -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.servis.index') }}">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'menunggu' ? 'active' : '' }}" href="{{ route('admin.servis.index', ['status' => 'menunggu']) }}">Menunggu Konfirmasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'proses' ? 'active' : '' }}" href="{{ route('admin.servis.index', ['status' => 'proses']) }}">Dalam Pengerjaan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'selesai' ? 'active' : '' }}" href="{{ route('admin.servis.index', ['status' => 'selesai']) }}">Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'tolak' ? 'active' : '' }}" href="{{ route('admin.servis.index', ['status' => 'tolak']) }}">Ditolak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'batal' ? 'active' : '' }}" href="{{ route('admin.servis.index', ['status' => 'batal']) }}">Dibatalkan</a>
                </li>
            </ul>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>No Telp</th>
                            <th>Kendaraan</th>
                            
                            <th>Keluhan</th>
                            <th>Tanggal Booking</th>
                            <th>Mekanik</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->user->nama ?? '-' }}</td>
                            <td>{{ $item->user->no_hp ?? '-' }}</td>
                            <td>{{ $item->kendaraan->merk ?? '-' }} {{ $item->kendaraan->model ?? '-' }}<br>{{ $item->kendaraan->plat_nomor ?? '-' }}</td>
                            
                            <td>{{ $item->keluhan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y H:i') }}</td>
                            <td>{{ $item->servis->mekanik->nama ?? '-' }}</td>
                            <td class="text-center">
                                @if($item->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($item->status == 'disetujui')
                                    <span class="badge bg-info text-dark">Proses</span>
                                @elseif($item->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($item->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($item->status == 'dibatalkan')
                                    <span class="badge bg-secondary">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.servis.edit', $item->booking_id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="bi bi-eye">Detail/Edit</i></a>
                                <form action="{{ route('admin.servis.destroy', $item->booking_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Delete">Hapus<i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data servis.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
