@extends('layouts.app')

@section('title', 'Manajemen Servis')

@section('content')
<div class="container-fluid px-4">
    <div class="user-management-header mb-4"
        style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                        class="bi bi-tools me-2"></i>Manajemen Servis</h2>
                <p class="text-white-50 m-0 mt-2">Pantau dan kelola seluruh antrean servis pelanggan</p>
            </div>
        </div>
    </div>


    <div class="card-modern">
        <div class="card-header bg-white p-0 border-bottom">
            <ul class="nav nav-tabs nav-fill border-0" id="servisTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom {{ !request('status') ? 'active text-primary' : 'text-secondary' }}"
                        href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => null])) }}">
                        <i class="bi bi-collection me-2"></i>Semua
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom {{ request('status') == 'menunggu' ? 'active text-warning' : 'text-secondary' }}"
                        href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'menunggu'])) }}">
                        <i class="bi bi-hourglass-split me-2"></i>Menunggu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom {{ request('status') == 'proses' ? 'active text-primary' : 'text-secondary' }}"
                        href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'proses'])) }}">
                        <i class="bi bi-gear-wide-connected me-2"></i>Proses
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom {{ request('status') == 'selesai' ? 'active text-success' : 'text-secondary' }}"
                        href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'selesai'])) }}">
                        <i class="bi bi-check-circle me-2"></i>Selesai
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="card-body p-0">
            {{-- Filter Section --}}
            <div class="px-4 py-4 border-bottom bg-light bg-opacity-50">
                <form action="{{ route('admin.servis.index') }}" method="GET">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label small fw-bold text-secondary">Cari Booking</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-left-0" 
                                    placeholder="Nama, Plat, Mekanik..." value="{{ request('search') }}" style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small fw-bold text-secondary">Dari Tanggal</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" style="border-radius: 10px;">
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small fw-bold text-secondary">Sampai Tanggal</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" style="border-radius: 10px;">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label small fw-bold text-secondary">Urutan</label>
                            <select name="sort" class="form-select" style="border-radius: 10px;">
                                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 fw-bold flex-grow-1" style="border-radius: 10px;">
                                <i class="bi bi-filter me-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.servis.index', ['status' => request('status')]) }}" class="btn btn-light px-3 border" style="border-radius: 10px;">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Waktu Booking</th>
                            <th>Mekanik</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
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
                                <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->user->nama ?? '-' }}</div>
                                    <small class="text-muted"><i class="bi bi-phone me-1"></i>{{ $item->user->no_hp ?? '-' }}</small>
                                </td>
                                <td>
                                    <div class="fw-semibold text-primary">{{ $item->kendaraan->plat_nomor ?? '-' }}</div>
                                    <small class="text-muted">{{ $item->kendaraan->merk ?? '' }} {{ $item->kendaraan->model ?? '' }}</small>
                                </td>
                                <td>
                                    <div class="text-dark"><i class="bi bi-calendar3 me-1 text-primary"></i>{{ \Carbon\Carbon::parse($item->tanggal_booking)->format('d M Y') }}</div>
                                    <div class="{{ $isPast ? 'text-danger' : ($isToday ? 'text-success' : 'text-primary') }} fw-bold small">
                                        <i class="bi bi-clock me-1"></i>{{ $item->jam_booking ?? '-' }} WIB
                                    </div>
                                    @if($isPast)
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle py-0 mt-1" style="font-size: 0.7rem;">Lewat Waktu</span>
                                    @elseif($isToday && $item->status == 'menunggu')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle py-0 mt-1" style="font-size: 0.7rem;">Hari Ini</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->servis && $item->servis->mekanik)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person-gear text-primary"></i>
                                            </div>
                                            <span class="small fw-semibold">{{ $item->servis->mekanik->nama }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted small italic">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status == 'menunggu')
                                        <span class="badge badge-modern bg-warning">Menunggu</span>
                                    @elseif($item->status == 'disetujui')
                                        <span class="badge badge-modern bg-info">Menunggu Mekanik</span>
                                    @elseif($item->status == 'dikerjakan')
                                        <span class="badge badge-modern bg-primary">Dikerjakan</span>
                                    @elseif($item->status == 'selesai')
                                        <span class="badge badge-modern" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">Selesai</span>
                                    @elseif($item->status == 'ditolak')
                                        <span class="badge badge-modern bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge badge-modern bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('admin.servis.edit', $item->booking_id) }}"
                                            class="btn btn-sm btn-outline-primary" style="border-radius: 8px;" data-bs-toggle="tooltip" title="Kelola Servis">
                                            <i class="bi bi-gear-fill"></i>
                                        </a>
                                        <form action="{{ route('admin.servis.destroy', $item->booking_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-confirm" style="border-radius: 8px;" 
                                                data-message="Hapus data booking ini?" data-bs-toggle="tooltip" title="Hapus Data">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Tidak ditemukan data servis sesuai filter.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection