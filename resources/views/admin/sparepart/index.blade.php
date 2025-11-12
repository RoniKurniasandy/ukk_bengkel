@extends('admin.layouts.app')

@section('title', 'Data Sparepart')

@push('styles')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
            <h5 class="mb-0"><i class="fas fa-cogs me-2"></i> Manajemen Sparepart</h5>
            <a href="{{ route('admin.sparepart.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i> Tambah Sparepart
            </a>
        </div>

        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table id="sparepartTable" class="table table-striped table-hover align-middle nowrap" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Sparepart</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($spareparts as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->kode_sparepart }}</td>
                            <td>{{ $item->nama_sparepart }}</td>
                            <td class="text-center">
                                @if($item->stok > 10)
                                    <span class="badge bg-success">{{ $item->stok }}</span>
                                @elseif($item->stok > 0)
                                    <span class="badge bg-warning text-dark">{{ $item->stok }}</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.sparepart.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sparepart.destroy', $item->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus sparepart ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#sparepartTable').DataTable({
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari sparepart...",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada data ditemukan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari total _MAX_ data)",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            }
        });
    });
</script>
@endpush
