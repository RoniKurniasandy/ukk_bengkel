@extends('layouts.app')
@section('title', 'Profil Admin')

@section('content')
<style>
    .profile-header {
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        height: 100px;
        border-radius: 15px 15px 0 0;
    }
    .profile-avatar-wrapper {
        margin-top: -50px;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<div class="container py-4">
    <div class="row g-4 justify-content-center">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm overflow-hidden mb-4 glass-card">
                <div class="profile-header"></div>
                <div class="card-body text-center profile-avatar-wrapper pb-4">
                    <div class="position-relative d-inline-block mb-3">
                        @if($user->foto)
                            <img src="{{ asset('storage/photos/' . $user->foto) }}" alt="Profile" id="profile-preview" 
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
                        <label for="foto-input" class="position-absolute bottom-0 end-0 bg-dark text-white rounded-circle p-2 shadow-sm" style="cursor: pointer; transform: translate(5px, 5px);">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                    </div>
                    
                    <h5 class="fw-bold mb-1">{{ $user->nama }}</h5>
                    <p class="text-muted small mb-3"><i class="bi bi-shield-lock-fill me-1"></i> Administrator</p>
                    
                    <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-check-circle-fill me-1"></i> Akun Utama
                    </span>
                </div>
            </div>

            <!-- Stats/Info Card -->
            <div class="card border-0 shadow-sm glass-card rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Informasi Sistem</h6>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Terdaftar Sejak</label>
                        <span class="fw-medium">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small d-block">Terakhir Update</label>
                        <span class="fw-medium text-primary">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 glass-card mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square me-2"></i> Pengaturan Akun Admin</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" name="foto" id="foto-input" class="d-none" accept="image/*" onchange="previewImage(this)">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">NAMA LENGKAP</label>
                                <input type="text" name="nama" class="form-control border-light shadow-none bg-light" value="{{ old('nama', $user->nama) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">EMAIL</label>
                                <input type="email" class="form-control border-light shadow-none bg-light" value="{{ $user->email }}" readonly disabled>
                                <small class="text-muted" style="font-size: 0.7rem;"><i class="bi bi-info-circle me-1"></i>Email tidak dapat diubah.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">NOMOR HP</label>
                                <input type="text" name="no_hp" class="form-control border-light shadow-none bg-light" value="{{ old('no_hp', $user->no_hp) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold">ALAMAT</label>
                                <textarea name="alamat" class="form-control border-light shadow-none bg-light" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-dark px-4 rounded-pill shadow-sm">
                                <i class="bi bi-save me-2"></i> Perbarui Data Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password -->
            <div class="card border-0 shadow-sm rounded-4 glass-card">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-danger mb-0"><i class="bi bi-key-fill me-2"></i> Keamanan</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.profil.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3 text-start">
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
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-outline-danger btn-sm px-4 rounded-pill">
                                Ganti Password
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