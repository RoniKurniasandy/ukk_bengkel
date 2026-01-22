@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4 mt-4">
        <!-- Header -->
        <div class="user-management-header mb-4"
          style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(246, 211, 101, 0.2);">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
              <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i class="bi bi-gear-fill me-2"></i>Servis Dikerjakan</h2>
              <p class="text-white-50 m-0 mt-2">Daftar motor yang sedang Anda tangani saat ini</p>
            </div>
            <div class="text-white-50">
              <i class="bi bi-clock-history me-1"></i> Pantau waktu pengerjaan Anda
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
                                <th>Waktu Mulai</th>
                                <th class="pe-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($servis as $item)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; color: #fda085; font-weight: bold;">
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
                                        @if($item->waktu_mulai)
                                            <div class="text-success fw-bold"><i class="bi bi-play-fill"></i> {{ $item->waktu_mulai->format('H:i') }} WIB</div>
                                            <small class="text-muted">{{ $item->waktu_mulai->diffForHumans() }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('mekanik.servis.detail', $item->id) }}"
                                                class="btn btn-info btn-sm text-white px-3 fw-bold me-2" style="border-radius: 8px;">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <form action="{{ route('mekanik.servis.update', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-success btn-sm action-confirm px-3 fw-bold" 
                                                    data-title="Konfirmasi Selesai"
                                                    data-message="Apakah servis ini sudah selesai?" 
                                                    data-confirm-text="Ya, Selesai!"
                                                    data-confirm-color="#198754"
                                                    style="border-radius: 8px;">
                                                    <i class="bi bi-check-circle"></i> Selesai
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-tools fs-1 d-block mb-3 opacity-50"></i>
                                            <p class="mb-0">Tidak ada servis yang sedang dikerjakan.</p>
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