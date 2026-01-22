@extends('layouts.app')

@section('title', 'Manajemen Servis')

@section('content')
<div class="container-fluid px-4">
    <div class="user-management-header mb-4"
        style="background: var(--banner-gradient); border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="text-white fw-bold m-0" style="font-size: 1.75rem;"><i
                        class="bi bi-tools me-2"></i>Manajemen Servis</h2>
                <p class="text-white-50 m-0 mt-2">Pantau dan kelola seluruh antrean servis pelanggan</p>
            </div>
        </div>
    </div>


    <div class="card-modern">
        <div class="card-header bg-white p-0 border-bottom">
            <ul class="nav nav-tabs nav-fill border-0" id="servisTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom {{ !request('status') ? 'active text-primary' : 'text-secondary' }}"
                        href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => null])) }}">
                        <i class="bi bi-collection me-2"></i>Semua
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom {{ request('status') == 'menunggu' ? 'active text-warning' : 'text-secondary' }}"
                        href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'menunggu'])) }}">
                        <i class="bi bi-hourglass-split me-2"></i>Menunggu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom {{ request('status') == 'proses' ? 'active text-primary' : 'text-secondary' }}"
                        href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'proses'])) }}">
                        <i class="bi bi-gear-wide-connected me-2"></i>Proses
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom {{ request('status') == 'selesai' ? 'active text-success' : 'text-secondary' }}"
                        href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'selesai'])) }}">
                        <i class="bi bi-check-circle me-2"></i>Selesai
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 fw-bold border-0 border-bottom {{ request('status') == 'batal' ? 'active text-danger' : 'text-secondary' }}"
                        href="{{ route('admin.servis.index', array_merge(request()->except('status'), ['status' => 'batal'])) }}">
                        <i class="bi bi-x-circle me-2"></i>Dibatalkan
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="card-body p-0">
            {{-- Filter Section --}}
            <div class="px-4 py-4 border-bottom bg-light bg-opacity-50">
                <form action="{{ route('admin.servis.index') }}" method="GET">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label small fw-bold text-secondary">Cari Booking</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-left-0" 
                                    placeholder="Nama, Plat, Mekanik..." value="{{ request('search') }}" style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small fw-bold text-secondary">Dari Tanggal</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" style="border-radius: 10px;">
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label small fw-bold text-secondary">Sampai Tanggal</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" style="border-radius: 10px;">
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label small fw-bold text-secondary">Urutan</label>
                            <select name="sort" class="form-select" style="border-radius: 10px;">
                                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 fw-bold flex-grow-1" style="border-radius: 10px;">
                                <i class="bi bi-filter me-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.servis.index', ['status' => request('status')]) }}" class="btn btn-light px-3 border" style="border-radius: 10px;">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Layanan</th>
                            <th>Keluhan</th>
                            <th>Waktu Booking</th>
                            <th>Mekanik</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="servisTableBody">
                        @include('admin.servis.table_rows')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let timeout = null;
    const filterForm = document.querySelector('form[action="{{ route('admin.servis.index') }}"]');
    const tableBody = document.getElementById('servisTableBody');

    function fetchResults() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);

        // Update URL without reload
        history.pushState(null, '', '?' + params.toString());

        fetch(`{{ route('admin.servis.index') }}?` + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            tableBody.innerHTML = html;
        });
    }

    // Input debounce for text search
    filterForm.querySelectorAll('input[type="text"]').forEach(input => {
        input.addEventListener('keyup', function() {
            clearTimeout(timeout);
            timeout = setTimeout(fetchResults, 500);
        });
    });

    // Instant update for selects and dates
    filterForm.querySelectorAll('select, input[type="date"]').forEach(input => {
        input.addEventListener('change', fetchResults);
    });
    
    // Prevent default form submission
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        fetchResults();
    });
</script>
@endpush
@endsection