@extends('layouts.app')

@section('title', 'Data Stok Sparepart')

@section('content')
<div class="container-fluid px-4">
    <div class="user-management-header mb-4"
        style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                        class="bi bi-box-seam me-2"></i>Data Sparepart</h2>
                <p class="text-white-50 m-0 mt-2">Manajemen persediaan suku cadang dan stok barang</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.stok.create') }}"
                    class="btn btn-light text-success fw-bold shadow-sm" style="border-radius: 10px;">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Stok Baru
                </a>
            </div>
        </div>
    </div>


    <div class="card-modern">
        <div class="card-body p-0">
            {{-- Search & Filter --}}
            <div class="px-4 py-4 border-bottom bg-light bg-opacity-50">
                <form action="{{ route('admin.stok.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" 
                                    placeholder="Cari nama barang..." value="{{ request('search') }}" style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2">
                            <button type="submit" class="btn btn-primary w-100 fw-bold" style="border-radius: 10px;">Cari</button>
                        </div>
                        @if(request('search'))
                            <div class="col-md-3 col-lg-2">
                                <a href="{{ route('admin.stok.index') }}" class="btn btn-light border w-100 fw-bold" style="border-radius: 10px;">Reset</a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Barang</th>
                            <th>Harga Jual</th>
                            <th>Stok Tersedia</th>
                            <th>Satuan</th>
                            <th>Status Stok</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stok as $index => $item)
                            <tr>
                                <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->nama_barang }}</div>
                                    <small class="text-muted">ID: #SP{{ str_pad($item->stok_id, 4, '0', STR_PAD_LEFT) }}</small>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="fs-5 fw-bold {{ $item->jumlah <= 5 ? 'text-danger' : 'text-primary' }}">{{ $item->jumlah }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2">{{ $item->satuan }}</span>
                                </td>
                                <td>
                                    @if($item->jumlah <= 0)
                                        <span class="badge badge-modern bg-danger">Habis</span>
                                    @elseif($item->jumlah <= 5)
                                        <span class="badge badge-modern bg-warning text-dark">Hampir Habis</span>
                                    @else
                                        <span class="badge badge-modern" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">Aman</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('admin.stok.edit', $item->stok_id) }}"
                                            class="btn btn-sm btn-outline-warning" style="border-radius: 8px;" data-bs-toggle="tooltip" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.stok.destroy', $item->stok_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-confirm" style="border-radius: 8px;" 
                                                data-message="Hapus sparepart '{{ $item->nama_barang }}' dari stok?" data-bs-toggle="tooltip" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted"> Belum ada data sparepart dalam stok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
