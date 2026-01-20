@extends('layouts.app')

@section('title', 'Jadwal Servis')

@section('content')
    <div class="container-fluid px-4 mt-4">
        <!-- Header -->
        <div class="user-management-header mb-4"
          style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(67, 233, 123, 0.2);">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
              <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i class="bi bi-calendar-check me-2"></i>Jadwal Servis</h2>
              <p class="text-white-50 m-0 mt-2">Daftar booking yang menunggu untuk dikerjakan</p>
            </div>
            <div class="text-white-50">
              <i class="bi bi-info-circle me-1"></i> Klik "Kerjakan" untuk memulai tugas
            </div>
          </div>
        </div>

        <div class="card-modern shadow-lg border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table-modern mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Tanggal & Jam</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Layanan</th>
                                <th>Estimasi</th>
                                <th class="pe-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $b)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-semibold"><i class="bi bi-calendar3 me-1 text-primary"></i>
                                            {{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d M Y') }}</div>
                                        <div class="small text-muted"><i class="bi bi-clock me-1"></i> {{ $b->jam_booking ?? '-' }} WIB
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $b->user->nama ?? '-' }}</div>
                                        <div class="small text-muted"><i class="bi bi-telephone me-1"></i>{{ $b->user->no_hp ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $b->kendaraan->merk }} {{ $b->kendaraan->model }}</div>
                                        <div class="badge bg-light text-dark border small mt-1">{{ $b->kendaraan->plat_nomor }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-modern" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">{{ $b->layanan->nama_layanan ?? '-' }}</span>
                                        <div class="small mt-1 text-muted">Rp {{ number_format($b->layanan->harga ?? 0, 0, ',', '.') }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-warning border fw-bold">
                                            <i class="bi bi-hourglass-split"></i> {{ $b->layanan->estimasi_waktu ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <form action="{{ route('mekanik.booking.start', $b->booking_id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-success px-3 fw-bold delete-confirm"
                                                data-message="Mulai mengerjakan servis ini?" style="border-radius: 8px;">
                                                <i class="bi bi-play-circle me-1"></i> Kerjakan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center py-5" colspan="7">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                            <p class="mb-0">Belum ada jadwal servis yang tersedia.</p>
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