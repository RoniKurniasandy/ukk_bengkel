@extends('layouts.app')

@section('title', 'Kendaraan Saya')

@section('content')
<div class="container mt-4">

    {{-- Judul Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Kendaraan Saya</h3>
        
        <!-- Tombol Tambah Kendaraan -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKendaraanModal">
            + Tambah Kendaraan
        </button>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tabel Kendaraan --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="text-white" style="background:#0d6efd;">
                    <tr>
                        <th>No</th>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>No. Plat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kendaraan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->merk }}</td>
                            <td>{{ $item->model }}</td>
                            <td>{{ $item->plat_nomor }}</td>
                            <td>
                                <form action="{{ route('user.kendaraan.destroy', $item->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Hapus kendaraan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-secondary">
                                Belum ada kendaraan terdaftar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal Tambah Kendaraan --}}
<div class="modal fade" id="addKendaraanModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('user.kendaraan.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Merk</label>
                    <input type="text" name="merk" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Model</label>
                    <input type="text" name="model" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Plat</label>
                    <input type="text" name="plat_nomor" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
<script>
    var addModal = new bootstrap.Modal(document.getElementById('addKendaraanModal'));
    addModal.show();
</script>
@endif

@endsection
