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
            <div class="fw-bold text-dark">{{ $item->layanan->nama_layanan ?? 'Umum' }}</div>
            <small class="text-muted">Estimasi: Rp {{ number_format($item->layanan->harga ?? 0, 0, ',', '.') }}</small>
        </td>
        <td>
            <div class="text-dark small" style="max-width: 200px; word-break: break-word; overflow-wrap: break-word;">
                {{ Str::limit($item->keluhan, 50) }}
            </div>
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
            @elseif($item->status == 'dibatalkan')
                <span class="badge badge-modern bg-secondary">Dibatalkan</span>
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
                    <button type="button" class="btn btn-sm btn-outline-danger action-confirm" style="border-radius: 8px;" 
                        data-title="Hapus Data"
                        data-message="Yakin ingin menghapus data booking ini?" 
                        data-confirm-text="Ya, Hapus"
                        data-confirm-color="#dc3545"
                        data-bs-toggle="tooltip" title="Hapus Data">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center py-5">
            <div class="text-muted">
                <i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i>
                <p class="mb-0">Tidak ditemukan data servis sesuai filter.</p>
            </div>
        </td>
    </tr>
@endforelse
