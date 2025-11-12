@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Kelola User</h4>
    <a href="#" class="btn btn-primary btn-sm">
      <i class="bi bi-plus-circle me-1"></i> Tambah User
    </a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Role</th>
            <th>Tanggal Daftar</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $index => $user)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $user->nama }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->no_hp ?? '-' }}</td>
            <td><span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span></td>
            <td>{{ $user->created_at->format('d M Y') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-3">Belum ada user terdaftar.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
