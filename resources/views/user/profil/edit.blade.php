@extends('layouts.app')
@section('title', 'Edit Profil')

@section('content')
<style>
    .edit-header {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        padding: 40px 0;
        border-radius: 20px;
        margin-bottom: -40px;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<div class="container py-4">
    <div class="edit-header text-center text-white mb-5">
        <h3 class="fw-bold mb-1">Perbarui Profil Anda</h3>
        <p class="opacity-75 mb-0">Pastikan data Anda selalu up-to-date untuk layanan terbaik</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Data Profil -->
            <div class="card border-0 shadow-lg rounded-4 glass-card mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="bi bi-person-lines-fill text-primary fs-5"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-0">Informasi Pribadi</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Profile Photo -->
                            <div class="col-12 text-center mb-2">
                                <div class="position-relative d-inline-block">
                                    @if($user->foto)
                                        <img src="{{ asset('storage/photos/' . $user->foto) }}" alt="Preview" id="profile-preview" 
                                             class="rounded-circle border border-4 border-white shadow" 
                                             style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div id="profile-placeholder" class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center border border-4 border-white shadow" 
                                             style="width: 120px; height: 120px;">
                                            <i class="bi bi-person-fill text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                        <img src="" id="profile-preview" class="rounded-circle border border-4 border-white shadow d-none" 
                                             style="width: 120px; height: 120px; object-fit: cover;">
                                    @endif
                                    <label for="foto" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow" style="cursor: pointer; transform: translate(5px, 5px);">
                                        <i class="bi bi-camera-fill"></i>
                                    </label>
                                    <input type="file" name="foto" id="foto" class="d-none" accept="image/*" onchange="previewImage(this)">
                                </div>
                                <p class="text-muted small mt-2">Maks: 2MB (JPG, PNG)</p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">NAMA LENGKAP</label>
                                <input type="text" name="nama" class="form-control border-light shadow-none bg-light" value="{{ old('nama', $user->nama) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">EMAIL</label>
                                <input type="email" name="email" class="form-control border-light shadow-none bg-light" value="{{ old('email', $user->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">NOMOR HP</label>
                                <input type="text" name="no_hp" class="form-control border-light shadow-none bg-light" value="{{ old('no_hp', $user->no_hp) }}">
                                <small class="text-info small"><i class="bi bi-info-circle me-1"></i>Kini Anda dapat mengubah nomor HP sendiri.</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold">ALAMAT LENGKAP</label>
                                <textarea name="alamat" class="form-control border-light shadow-none bg-light" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('user.profil.index') }}" class="btn btn-link text-muted text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Profil
                            </a>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow save-confirm" data-message="Simpan perubahan data profil Anda?">
                                <i class="bi bi-save2-fill me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password -->
            <div class="card border-0 shadow-lg rounded-4 glass-card overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="bi bi-shield-lock-fill text-danger fs-5"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-0">Keamanan</h6>
                </div>
                <div class="card-body p-4 text-start">
                    <form action="{{ route('user.profil.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Password Lama</label>
                                <input type="password" name="password_lama" class="form-control border-light" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Password Baru</label>
                                <input type="password" name="password_baru" class="form-control border-light" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Konfirmasi</label>
                                <input type="password" name="password_baru_confirmation" class="form-control border-light" required>
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-danger px-4 rounded-pill shadow-sm save-confirm" data-message="Anda yakin ingin memperbarui password akun Anda?">
                                <i class="bi bi-key-fill me-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('profile-preview');
                var placeholder = document.getElementById('profile-placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if(placeholder) placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection