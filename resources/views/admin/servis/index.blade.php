@extends('layouts.app')

@section('title', 'Data Servis')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Servis</h4>
            <a href="{{ route('admin.servis') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Servis
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Mekanik</th>
                            <th>Tanggal Servis</th>
                            <th>Status</th>
                            <th>Sparepart Digunakan</th>
                            <th>Total Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servis as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->booking->user->name ?? '-' }}</td>
                            <td>{{ $item->mekanik->nama ?? '-' }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                @if($item->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($item->status == 'proses')
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @else
                                    <span class="badge bg-secondary">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($item->spareparts && count($item->spareparts) > 0)
                                    <ul class="mb-0">
                                        @foreach($item->spareparts as $sp)
                                            <li>{{ $sp->nama_sparepart }} ({{ $sp->pivot->jumlah ?? '1' }}x)</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <em>-</em>
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->total_biaya ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.servis.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.servis.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.servis.destroy', $item->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data servis</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
