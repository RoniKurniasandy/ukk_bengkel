@extends('layouts.app')
@section('title', 'Kelola Layanan')

@section('content')
    <div class="container-fluid px-4">
        <div class="user-management-header mb-4"
            style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                            class="bi bi-gear-wide-connected me-2"></i>Kelola Layanan</h2>
                    <p class="text-white-50 m-0 mt-2">Manajemen daftar layanan dan harga servis</p>
                </div>
                <a href="{{ route('admin.layanan.create') }}"
                    class="btn btn-light text-primary fw-bold mt-3 mt-md-0 shadow-sm" style="border-radius: 10px;">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Layanan
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table-modern mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 5%;">No</th>
                                <th style="width: 25%;">Nama Layanan</th>
                                <th style="width: 20%;">Harga</th>
                                <th style="width: 15%;">Estimasi</th>
                                <th style="width: 20%;">Deskripsi</th>
                                <th class="text-end pe-4" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($layanan as $item)
                                <tr>
                                    <td class="ps-4">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $item->nama_layanan }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-modern"
                                            style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); font-size: 0.85rem;">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="bi bi-clock me-2"></i>{{ $item->estimasi_waktu }}
                                        </div>
                                    </td>
                                    <td class="text-muted small">{{ Str::limit($item->deskripsi, 50) }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.layanan.edit', $item->id) }}"
                                            class="btn btn-sm btn-outline-warning me-1" style="border-radius: 8px;">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-confirm"
                                                style="border-radius: 8px;" data-message="Yakin ingin menghapus layanan '{{ $item->nama_layanan }}'?">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                            <p class="mb-0">Belum ada data layanan.</p>
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