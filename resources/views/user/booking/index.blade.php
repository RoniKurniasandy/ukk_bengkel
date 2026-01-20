@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4 py-4">
        <!-- Header -->
        <div class="user-management-header mb-4"
          style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.2);">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
              <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i class="bi bi-calendar-event me-2"></i>Daftar Booking Servis</h2>
              <p class="text-white-50 m-0 mt-2">Daftar permintaan servis yang sedang menunggu konfirmasi admin</p>
            </div>
            <a href="{{ route('user.booking.create') }}" class="btn btn-white fw-bold px-4 py-2" style="border-radius: 12px; background: #fff; color: #4facfe;">
                <i class="bi bi-plus-lg me-1"></i> Booking Baru
            </a>
          </div>
        </div>

        <div class="card-modern shadow-lg border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table-modern mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Layanan Servis</th>
                                <th>Kendaraan</th>
                                <th>Waktu Booking</th>
                                <th>Status</th>
                                <th class="pe-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($bookings as $b)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-semibold text-primary">{{ $b->layanan->nama_layanan ?? 'Umum' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $b->kendaraan->merk ?? '-' }} {{ $b->kendaraan->model ?? '-' }}</div>
                                        <div class="badge bg-light text-dark border small mt-1">{{ $b->kendaraan->plat_nomor ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><i class="bi bi-calendar3 me-1 text-primary"></i> {{ \Carbon\Carbon::parse($b->tanggal_booking)->format('d M Y') }}</div>
                                        <div class="small text-muted"><i class="bi bi-clock me-1"></i> {{ $b->jam_booking ?? '-' }} WIB</div>
                                    </td>
                                    <td>
                                        @if($b->status == 'disetujui')
                                            <span class="badge badge-modern" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">Disetujui</span>
                                        @elseif($b->status == 'menunggu')
                                            <span class="badge badge-modern bg-secondary">Menunggu Admin</span>
                                        @elseif($b->status == 'ditolak')
                                            <span class="badge badge-modern bg-danger">Ditolak</span>
                                        @elseif($b->status == 'dibatalkan')
                                            <span class="badge badge-modern bg-light text-muted border">Dibatalkan</span>
                                        @else
                                            <span class="badge badge-modern bg-secondary">{{ ucfirst($b->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-center">
                                        @if($b->status == 'menunggu')
                                            <form method="POST" action="{{ route('user.booking.destroy', $b->booking_id) }}"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger px-3 delete-confirm"
                                                    data-message="Yakin ingin membatalkan booking servis ini?" style="border-radius: 8px;">
                                                    <i class="bi bi-x-circle"></i> Batalkan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">Sudah diproses</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center py-5" colspan="6">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                            <p class="mb-0">Tidak ada booking yang sedang menunggu konfirmasi.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($bookings->count() > 0)
            <div class="alert alert-info border-0 shadow-sm mt-4 d-flex align-items-center" style="border-radius: 12px; background: #eef2ff; border-left: 5px solid #667eea !important;">
                <i class="bi bi-info-circle-fill text-primary fs-4 me-3"></i>
                <div class="small">
                    Halaman ini menampilkan booking yang belum diproses atau sedang menunggu. Jika sudah disetujui mekanik, silakan pantau di menu <a href="{{ route('user.servis') }}" class="fw-bold text-primary text-decoration-none">Riwayat Servis</a>.
                </div>
            </div>
        @endif
    </div>
@endsection