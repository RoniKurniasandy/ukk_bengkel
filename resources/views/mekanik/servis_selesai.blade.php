@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4 mt-4">
        <!-- Header -->
        <div class="user-management-header mb-4"
          style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
              <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i class="bi bi-check2-all me-2"></i>Riwayat Servis Selesai</h2>
              <p class="text-white-50 m-0 mt-2">Daftar motor yang telah selesai Anda tangani</p>
            </div>
            <div class="text-white-50">
              <i class="bi bi-award me-1"></i> Kerja bagus, terus tingkatkan!
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
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Keluhan</th>
                                <th>Tanggal Selesai</th>
                                <th class="pe-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servis as $item)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; color: #764ba2; font-weight: bold;">
                                                {{ strtoupper(substr($item->booking->user->nama ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold">{{ $item->booking->user->nama ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->booking->kendaraan->merk ?? '-' }} {{ $item->booking->kendaraan->model ?? '-' }}</div>
                                        <div class="badge bg-light text-dark border small mt-1">{{ $item->booking->kendaraan->plat_nomor ?? '-' }}</div>
                                    </td>
                                    <td style="max-width: 200px;" class="text-truncate">
                                        {{ $item->booking->keluhan }}
                                    </td>
                                    <td>
                                        <div class="fw-bold"><i class="bi bi-calendar-check text-success"></i> {{ $item->updated_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $item->updated_at->format('H:i') }} WIB</small>
                                    </td>
                                    <td class="pe-4 text-center">
                                        <span class="badge badge-modern" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                            <i class="bi bi-patch-check"></i> Selesai
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-archive fs-1 d-block mb-3 opacity-50"></i>
                                            <p class="mb-0">Belum ada riwayat servis selesai.</p>
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