@extends('layouts.app')
@section('title', 'Profil Admin')

@section('content')
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">Profil Saya</h3>
        </div>
        
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-4 mb-4">
                    <!-- Profile Card -->
                    <div class="card border-0 shadow-sm mb-4 text-center py-4">
                        <div class="card-body">
                            <div class="mb-3 position-relative d-inline-block profile-img-container">
                                 @if($user->foto)
                                    <img src="{{ asset('storage/photos/' . $user->foto) }}" alt="Foto Profil" id="profile-preview" class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                                @else
                                    <div id="profile-placeholder" class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 150px; height: 150px; border: 4px solid #fff;">
                                        <i class="bi bi-person-fill text-secondary" style="font-size: 4rem;"></i>
                                    </div>
                                    <img src="" alt="Foto Profil" id="profile-preview" class="rounded-circle shadow-sm d-none" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                                @endif
                                
                                <!-- Overlay Edit Button -->
                                <label for="foto-input" class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow p-2" style="cursor: pointer; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid #dee2e6;">
                                    <i class="bi bi-pencil-fill text-primary"></i>
                                </label>
                                <input type="file" name="foto" id="foto-input" class="d-none" accept="image/*" onchange="previewImage(this)">
                            </div>
                            
                            <h5 class="fw-bold text-dark mb-1">{{ $user->nama }}</h5>
                            <p class="text-muted mb-2">{{ ucfirst($user->role) }}</p>
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                <i class="bi bi-check-circle-fill me-1"></i> Akun Aktif
                            </span>
                        </div>
                    </div>

                    <!-- Account Info Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 pt-3">
                            <h6 class="fw-bold text-primary mb-0">Informasi Akun</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted small">Email Saat Ini</label>
                                <p class="fw-medium text-dark mb-0">{{ $user->email }}</p>
                            </div>
                            <div class="mb-0">
                                <label class="text-muted small">Terdaftar Sejak</label>
                                <p class="fw-medium text-dark mb-0">{{ $user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-8">
                    <!-- Biodata Edit Form -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom pt-3 pb-2">
                             <h6 class="fw-bold text-primary mb-0">Edit Biodata Diri</h6>
                        </div>
                        <div class="card-body">
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label text-muted">Nama Lengkap</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label text-muted">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label text-muted">Role Pengguna</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control bg-light" value="{{ ucfirst($user->role) }}" readonly>
                                        <small class="text-muted d-block mt-1">Role tidak dapat diubah</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label text-muted">Nomor HP</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="no_hp" class="form-control bg-light" value="{{ old('no_hp', $user->no_hp) }}" readonly>
                                        <small class="text-muted d-block mt-1">Hubungi admin untuk ubah nomor</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label text-muted">Alamat</label>
                                    <div class="col-sm-8">
                                        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-8 offset-md-4">
                 <!-- Password Change Form -->
                 <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom pt-3 pb-2">
                         <h6 class="fw-bold text-danger mb-0">Ganti Password</h6>
                    </div>
                    <div class="card-body">
                         <form action="{{ route('admin.profil.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-muted">Password Lama</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password_lama" class="form-control" placeholder="••••••••">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-muted">Password Baru</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password_baru" class="form-control" placeholder="••••••••">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label text-muted">Konfirmasi Password</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password_baru_confirmation" class="form-control" placeholder="••••••••">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-key me-1"></i> Update Password
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
    </div>
@endsection