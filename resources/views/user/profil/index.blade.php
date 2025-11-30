@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profil Saya</h5>
                        <a href="{{ route('user.profil.edit') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-pencil"></i> Edit Profil
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150" class="fw-bold">Nama Lengkap</td>
                                <td>: {{ $user->nama }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email</td>
                                <td>: {{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">No. HP</td>
                                <td>: {{ $user->no_hp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Alamat</td>
                                <td>: {{ $user->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Role</td>
                                <td>: <span class="badge bg-info">{{ ucfirst($user->role) }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Bergabung Sejak</td>
                                <td>: {{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Keamanan</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">
                            <i class="bi bi-info-circle"></i>
                            Untuk mengubah password, silakan klik tombol "Edit Profil" di atas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection