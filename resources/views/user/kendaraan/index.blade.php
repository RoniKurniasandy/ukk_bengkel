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
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-confirm" data-message="Anda akan menghapus data kendaraan '{{ $item->merk }} {{ $item->model }}' dengan plat '{{ $item->plat_nomor }}'.">
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
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('user.kendaraan.store') }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            @csrf
            <div class="modal-header border-0 p-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                        <i class="bi bi-car-front-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold">Tambah Kendaraan</h5>
                        <p class="text-muted small mb-0">Daftarkan kendaraan baru untuk booking servis</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label class="form-label fw-bold small text-secondary">Merk Kendaraan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-primary"></i></span>
                        <input type="text" name="merk" class="form-control bg-light border-0 p-2" placeholder="Contoh: Toyota, Honda..." required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold small text-secondary">Model / Tipe</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-info-circle text-primary"></i></span>
                        <input type="text" name="model" class="form-control bg-light border-0 p-2" placeholder="Contoh: Avanza, Civic..." required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">Nomor Plat</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-hash text-primary"></i></span>
                        <input type="text" name="plat_nomor" class="form-control bg-light border-0 p-2" placeholder="Contoh: B 1234 ABC" required style="border-radius: 0 10px 10px 0;">
                    </div>
                    <div class="form-text small">Gunakan huruf kapital untuk nomor plat agar mudah dikenali.</div>
                </div>
            </div>

            <div class="modal-footer border-0 p-4 pt-0">
                <button class="btn btn-light fw-bold px-4 py-2 me-2" type="button" data-bs-dismiss="modal" style="border-radius: 12px;">Batal</button>
                <button class="btn btn-primary fw-bold px-4 py-2 save-confirm" type="submit" data-message="Daftarkan kendaraan baru ini ke akun Anda?" style="border-radius: 12px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none;">
                    <i class="bi bi-plus-lg me-1"></i> Simpan Kendaraan
                </button>
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
