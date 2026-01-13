@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<style>
    .profile-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        height: 120px;
        border-radius: 15px 15px 0 0;
    }
    .profile-avatar-wrapper {
        margin-top: -60px;
    }
    .membership-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border: none;
        color: #fff;
        overflow: hidden;
        position: relative;
    }
    .membership-card::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }
    .membership-status-badge {
        font-size: 0.75rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .loyal-member-gold {
        background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%) !important;
        color: #fff !important;
    }
    .progress-custom {
        height: 8px;
        background-color: rgba(255, 255, 255, 0.1);
    }
    .progress-custom .progress-bar {
        background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .stat-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
</style>

<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-lg-4">
            <!-- Profile Info Card -->
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
                        <label for="foto-input" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow-sm" style="cursor: pointer; transform: translate(5px, 5px);">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                    </div>
                    
                    <h5 class="fw-bold mb-1">{{ $user->nama }}</h5>
                    <p class="text-muted small mb-3"><i class="bi bi-envelope me-1"></i> {{ $user->email }}</p>
                    
                    @if($user->membership_tier_id)
                        <span class="badge loyal-member-gold px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-star-fill me-1"></i> Member Loyal
                        </span>
                    @else
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                            Pelanggan Regular
                        </span>
                    @endif
                </div>
            </div>

            <!-- Membership & Loyalty Card -->
            <div class="card membership-card shadow-lg mb-4 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="text-white-50 mb-1 membership-status-badge">Membership Tier</h6>
                            <h4 class="fw-bold text-white mb-0">
                                {{ $user->membershipTier ? $user->membershipTier->nama_level : 'Regular' }}
                            </h4>
                        </div>
                        <div class="stat-icon bg-white bg-opacity-10 text-warning">
                            <i class="bi bi-award-fill fs-3"></i>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between text-white-50 small mb-2">
                            <span>Total Akumulasi</span>
                            <span class="text-white">Rp {{ number_format($user->total_transaksi, 0, ',', '.') }}</span>
                        </div>
                        
                        @if(!$user->membership_tier_id)
                            @php
                                $target = 5000000;
                                $progress = min(100, ($user->total_transaksi / $target) * 100);
                                $remaining = max(0, $target - $user->total_transaksi);
                            @endphp
                            <div class="progress progress-custom mb-2">
                                <div class="progress-bar" style="width: {{ $progress }}%"></div>
                            </div>
                            <small class="text-white-50">
                                <i class="bi bi-info-circle me-1"></i>
                                Belanja Rp {{ number_format($remaining, 0, ',', '.') }} lagi untuk jadi **Member Loyal (Diskon 10%)**
                            </small>
                        @else
                            <div class="d-flex align-items-center text-warning small">
                                <i class="bi bi-patch-check-fill me-2 fs-5"></i>
                                <span>Nikmati diskon eksklusif 10% setiap transaksi!</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content (Edit Profile) -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 glass-card mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-primary mb-0"><i class="bi bi-person-lines-fill me-2"></i> Pengaturan Profil</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" name="foto" id="foto-input" class="d-none" accept="image/*" onchange="previewImage(this)">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">NAMA LENGKAP</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama" class="form-control border-light shadow-none" value="{{ old('nama', $user->nama) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">EMAIL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control border-light shadow-none bg-light" value="{{ $user->email }}" readonly disabled>
                                </div>
                                <small class="text-muted" style="font-size: 0.7rem;"><i class="bi bi-info-circle me-1"></i>Email tidak dapat diubah.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">NOMOR HP</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="no_hp" class="form-control border-light shadow-none" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 0812xxxx">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold">ALAMAT DOMISILI</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt"></i></span>
                                    <textarea name="alamat" class="form-control border-light shadow-none" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <i class="bi bi-shield-lock me-1"></i> Data Anda tersimpan dengan aman
                            </div>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="bi bi-save me-2"></i> Perbarui Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Card -->
            <div class="card border-0 shadow-sm rounded-4 glass-card">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold text-danger mb-0"><i class="bi bi-key-fill me-2"></i> Keamanan Akun</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.profil.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Password Lama</label>
                                <input type="password" name="password_lama" class="form-control border-light bg-light" placeholder="••••••••" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Password Baru</label>
                                <input type="password" name="password_baru" class="form-control border-light" placeholder="Min. 8 karakter" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Konfirmasi</label>
                                <input type="password" name="password_baru_confirmation" class="form-control border-light" placeholder="Ulangi password" required>
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