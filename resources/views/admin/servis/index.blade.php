@extends('layouts.app')

@section('title', 'Manajemen Servis')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Manajemen Servis</h4>
            </div>

            <div class="card-body">
                {{-- Filter Tabs --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ !request('status') ? 'active' : '' }}"
                            href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => null])) }}">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'menunggu' ? 'active' : '' }}"
                            href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'menunggu'])) }}">Menunggu Konfirmasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'proses' ? 'active' : '' }}"
                            href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'proses'])) }}">Dalam Pengerjaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'selesai' ? 'active' : '' }}"
                            href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'selesai'])) }}">Selesai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'tolak' ? 'active' : '' }}"
                            href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'tolak'])) }}">Ditolak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'batal' ? 'active' : '' }}"
                            href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'batal'])) }}">Dibatalkan</a>
                    </li>
                </ul>

                {{-- Search Form --}}
                <form action="{{ route('admin.servis.index') }}" method="GET" class="mb-4">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control" 
                                    placeholder="Cari Nama, Plat Nomor, atau Mekanik..." 
                                    value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar"></i></span>
                                <input type="date" name="date" class="form-control" 
                                    value="{{ request('date') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Cari</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.servis.index', ['status' => request('status')]) }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>No Telp</th>
                                <th>Kendaraan</th>
                                <th>Keluhan</th>
                                <th>Waktu Booking</th>
                                <th>Mekanik</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $index => $item)
                                @php
                                    $bookingDateTime = \Carbon\Carbon::parse($item->tanggal_booking)->setTimeFromTimeString($item->jam_booking ?? '00:00');
                                    $isPast = $bookingDateTime->isPast() && $item->status == 'menunggu';
                                    $isToday = $bookingDateTime->isToday();
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $item->user->nama ?? '-' }}</td>
                                    <td>{{ $item->user->no_hp ?? '-' }}</td>
                                    <td>{{ $item->kendaraan->merk ?? '-' }}
                                        {{ $item->kendaraan->model ?? '-' }}<br>{{ $item->kendaraan->plat_nomor ?? '-' }}
                                    </td>

                                    <td>{{ Str::limit($item->keluhan, 50) }}</td>
                                    <td>
                                        <div>
                                            <i
                                                class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y') }}
                                        </div>
                                        <div
                                            class="{{ $isPast ? 'text-danger' : ($isToday ? 'text-success' : 'text-primary') }}">
                                            <i class="bi bi-clock me-1"></i><strong>{{ $item->jam_booking ?? '-' }}</strong> WIB
                                        </div>
                                        @if($isPast)
                                            <span class="badge bg-danger badge-sm mt-1">
                                                <i class="bi bi-exclamation-triangle"></i> Lewat Waktu
                                            </span>
                                        @elseif($isToday && $item->status == 'menunggu')
                                            <span class="badge bg-success badge-sm mt-1">
                                                <i class="bi bi-bell"></i> Hari Ini
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item->servis->mekanik->nama ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($item->status == 'menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($item->status == 'disetujui')
                                            <span class="badge bg-info text-dark">Menunggu Mekanik</span>
                                        @elseif($item->status == 'dikerjakan')
                                            <span class="badge bg-primary">Sedang Dikerjakan</span>
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
                                        <div class="btn-group" role="group">
                                            {{-- Detail --}}
                                            <a href="{{ route('admin.servis.edit', $item->booking_id) }}"
                                                class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Lihat Detail & Kelola">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('admin.servis.destroy', $item->booking_id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Hapus Data">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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
    @push('scripts')
        <script>
            // Initialize Bootstrap tooltips
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            });
        </script>
    @endpush

@endsection