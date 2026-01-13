@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">🧾 Data Stok Barang</h3>
    <a href="{{ route('admin.stok.create') }}" class="btn btn-primary shadow-sm">
        + Tambah Barang
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong class="text-secondary">Manajemen Barang</strong>
    </div>
    <div class="card-body">
        {{-- Jika data kosong --}}
        @if($stok->isEmpty())
            <div class="text-center py-4 text-muted">
                <i class="bi bi-archive"></i> Belum ada barang dalam stok
            </div>
        @else

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stok as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_barang }}</td>
                        <td class="fw-semibold">{{ $item->nama_barang }}</td>
                        <td>
                            @if($item->jumlah > 10)
                                <span class="badge bg-success">{{ $item->jumlah }}</span>
                            @elseif($item->jumlah > 0)
                                <span class="badge bg-warning">{{ $item->jumlah }}</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.stok.edit', $item->stok_id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.stok.destroy', $item->stok_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger delete-confirm" data-message="Anda akan menghapus data sparepart '{{ $item->nama_barang }}'.">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif
    </div>
</div>
@endsection
