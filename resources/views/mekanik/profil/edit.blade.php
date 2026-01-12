@extends('layouts.app')
@section('title', 'Edit Profil')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terjadi Kesalahan:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Edit Data Profil</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('mekanik.profil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto Profil</label>
                                @if($user->foto)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/photos/' . $user->foto) }}" alt="Foto Profil" class="img-thumbnail rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                @endif
                                <input type="file" name="foto" id="foto" class="form-control">
                                <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 2MB</small>
                            </div>

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    value="{{ old('nama', $user->nama) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. HP</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control bg-light"
                                    value="{{ old('no_hp', $user->no_hp) }}" readonly>
                                <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Hubungi Admin untuk mengubah nomor HP.</small>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="3"
                                    placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('mekanik.profil.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Ubah Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('mekanik.profil.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="password_lama" class="form-label">Password Lama <span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password_lama" id="password_lama" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="password_baru" class="form-label">Password Baru <span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password_baru" id="password_baru" class="form-control"
                                    required>
                                <small class="text-muted">Minimal 8 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_baru_confirmation" class="form-label">Konfirmasi Password Baru <span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password_baru_confirmation" id="password_baru_confirmation"
                                    class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-key"></i> Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection