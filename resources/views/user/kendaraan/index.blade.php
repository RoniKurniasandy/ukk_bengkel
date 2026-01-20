@extends('layouts.app')

@section('title', 'Kendaraan Saya')

@section('content')
<div class="container-fluid px-4 py-4">

    <!-- Header -->
    <div class="user-management-header mb-4"
      style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i class="bi bi-bicycle me-2"></i>Kendaraan Saya</h2>
          <p class="text-white-50 m-0 mt-2">Kelola daftar kendaraan yang Anda gunakan untuk servis</p>
        </div>
        <button class="btn btn-white fw-bold px-4 py-2" data-bs-toggle="modal" data-bs-target="#addKendaraanModal" style="border-radius: 12px; background: #fff; color: #1e3a8a;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kendaraan
        </button>
      </div>
    </div>

    {{-- Tabel Kendaraan --}}
    <div class="card-modern shadow-lg border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Merk Kendaraan</th>
                            <th>Model / Tipe</th>
                            <th>Nomor Plat</th>
                            <th class="pe-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kendaraan as $index => $item)
                            <tr>
                                <td class="ps-4">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-semibold text-primary">{{ $item->merk }}</div>
                                </td>
                                <td>{{ $item->model }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2 fw-bold" style="letter-spacing: 1px;">{{ $item->plat_nomor }}</span>
                                </td>
                                <td class="pe-4 text-center">
                                    <form action="{{ route('user.kendaraan.destroy', $item->id) }}" 
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger px-3 delete-confirm" data-message="Anda akan menghapus data kendaraan '{{ $item->merk }} {{ $item->model }}' dengan plat '{{ $item->plat_nomor }}'." style="border-radius: 8px;">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-car-front fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada kendaraan terdaftar. Silakan tambahkan kendaraan untuk mulai booking.</p>
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
    document.addEventListener('DOMContentLoaded', function() {
        var addModal = new bootstrap.Modal(document.getElementById('addKendaraanModal'));
        addModal.show();
    });
</script>
@endif

@endsection
