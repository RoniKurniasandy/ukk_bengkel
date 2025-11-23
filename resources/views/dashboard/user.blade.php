@extends('layouts.app')
@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container-fluid py-4">
  <h2 class="fw-bold text-indigo mb-4">Dashboard Pelanggan</h2>

  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0"><i class="ti ti-calendar me-2"></i>Riwayat Booking Servis</h5>
      <a href="{{ route('user.booking.create') }}" class="btn btn-light btn-sm">Booking Baru</a>
    </div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Jenis Servis</th>
            <th>Tanggal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($bookings ?? [] as $i => $b)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ data_get($b, 'jenis_layanan', '-') }}</td>
            <td>{{ data_get($b, 'tanggal_booking', '-') }}</td>
            <td>
              @php $status = data_get($b, 'status', 'menunggu'); @endphp
              <span class="badge bg-{{ $status == 'selesai' ? 'success' : ($status == 'disetujui' ? 'info' : 'warning') }}">
                {{ ucfirst($status) }}
              </span>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center text-muted py-4">Belum ada booking servis.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection