@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="fw-bold text-primary mb-4">Daftar Layanan</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary">+ Tambah Layanan</a>
        </div>

        <table class="table table-bordered text-center">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama Layanan</th>
                    <th>Harga</th>
                    <th>Estimasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanan as $l)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $l->nama_layanan }}</td>
                        <td>Rp {{ number_format($l->harga, 0, ',', '.') }}</td>
                        <td>{{ $l->estimasi_waktu }}</td>
                        <td>
                            <a href="{{ route('admin.layanan.edit', $l->layanan_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.layanan.destroy', $l->layanan_id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@endsection