@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
  <style>
    /* Modern Gradient Background */
    .user-management-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    }
    .user-management-header h2 {
      color: white;
      font-weight: 700;
      margin: 0;
      font-size: 1.75rem;
    }
    .user-management-header p {
      color: rgba(255, 255, 255, 0.9);
      margin: 0.5rem 0 0 0;
      font-size: 0.95rem;
    }
    .modern-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: none;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    .modern-card:hover {
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      transform: translateY(-2px);
    }
    .stats-card {
      background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
      border-radius: 12px;
      padding: 1.25rem;
      color: white;
      margin-bottom: 1.5rem;
    }
    .stats-card.blue { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .stats-card.green { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .stats-number { font-size: 2rem; font-weight: 700; margin: 0; }
    .stats-label { font-size: 0.875rem; opacity: 0.95; margin: 0; }
    .btn-modern {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 10px;
      padding: 0.625rem 1.5rem;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .btn-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    .modern-table { margin: 0; }
    .modern-table thead { background: linear-gradient(135deg, #f6f8fb 0%, #e9ecef 100%); }
    .modern-table thead th {
      border: none; padding: 1rem; font-weight: 600; color: #495057; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .modern-table tbody tr { border-bottom: 1px solid #f1f3f5; transition: all 0.2s ease; }
    .modern-table tbody tr:hover { background-color: #f8f9fa; transform: scale(1.01); }
    .modern-table tbody td { padding: 1rem; vertical-align: middle; color: #495057; border: none; }
    .badge-modern { padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; font-size: 0.75rem; letter-spacing: 0.3px; }
    .badge-pelanggan { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .badge-mekanik { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
    .user-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: inline-flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem; margin-right: 0.75rem; }
    .user-info { display: flex; align-items: center; }
    .user-name { font-weight: 600; color: #212529; }
    .search-box { position: relative; margin-bottom: 1.5rem; }
    .search-box input { border-radius: 12px; border: 2px solid #e9ecef; padding: 0.75rem 1rem 0.75rem 3rem; transition: all 0.3s ease; width: 100%; }
    .search-box input:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15); }
    .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #6c757d; }
    .empty-state { padding: 3rem 1rem; text-align: center; }
    .empty-state i { font-size: 4rem; color: #dee2e6; margin-bottom: 1rem; }
    .empty-state h5 { color: #6c757d; font-weight: 600; }
    .empty-state p { color: #adb5bd; }
    @media (max-width: 768px) {
      .user-management-header { padding: 1.5rem; }
      .user-management-header h2 { font-size: 1.5rem; }
      .stats-card { margin-bottom: 1rem; }
    }
  </style>

  <div class="container-fluid px-4">
    <div class="user-management-header">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h2><i class="bi bi-people-fill me-2"></i>Kelola User</h2>
          <p>Manajemen data pengguna sistem bengkel</p>
        </div>
        <a href="{{ route('admin.user.create') }}" class="btn btn-modern mt-3 mt-md-0"><i class="bi bi-plus-circle me-2"></i>Tambah User Baru</a>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-md-6">
        <div class="stats-card blue">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="stats-number">{{ $users->where('role', 'pelanggan')->count() }}</p>
              <p class="stats-label">Total Pelanggan</p>
            </div>
            <i class="bi bi-person-badge" style="font-size: 2.5rem; opacity: 0.3;"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="stats-card">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="stats-number">{{ $users->where('role', 'mekanik')->count() }}</p>
              <p class="stats-label">Total Mekanik</p>
            </div>
            <i class="bi bi-tools" style="font-size: 2.5rem; opacity: 0.3;"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.user.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label fw-bold small text-muted">Cari User</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" id="search" class="form-control border-start-0 ps-0" 
                            placeholder="Nama, Email, atau No HP..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="role" class="form-label fw-bold small text-muted">Role</label>
                    <select name="role" id="role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="pelanggan" {{ request('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        <option value="mekanik" {{ request('role') == 'mekanik' ? 'selected' : '' }}>Mekanik</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="start_date" class="form-label fw-bold small text-muted">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <label for="end_date" class="form-label fw-bold small text-muted">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-primary fw-bold text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
                @if(request()->has('search') || request()->has('role') || request()->has('start_date'))
                    <div class="col-12 text-center mt-2">
                        <a href="{{ route('admin.user.index') }}" class="text-decoration-none small text-muted">
                            <i class="bi bi-x-circle me-1"></i> Reset Pencarian
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="modern-card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="modern-table table mb-0">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">User</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 15%;">No HP</th>
                <th style="width: 15%;">Role</th>
                <th style="width: 15%;">Tanggal Daftar</th>
              </tr>
            </thead>
            <tbody id="user-table-body">
              @forelse($users as $index => $user)
                <tr class="user-row">
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td>
                    <div class="user-info">
                      @if($user->foto)
                        <img src="{{ asset('storage/photos/' . $user->foto) }}" alt="user-avatar" class="user-avatar" style="object-fit: cover;">
                      @else
                        <div class="user-avatar">{{ strtoupper(substr($user->nama, 0, 1)) }}</div>
                      @endif
                      <span class="user-name">{{ $user->nama }}</span>
                    </div>
                  </td>
                  <td><i class="bi bi-envelope me-2" style="color: #6c757d;"></i>{{ $user->email }}</td>
                  <td>
                    @if($user->no_hp)
                      <i class="bi bi-telephone me-2" style="color: #6c757d;"></i>{{ $user->no_hp }}
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td>
                    @if($user->role == 'pelanggan')
                      <span class="badge badge-modern badge-pelanggan"><i class="bi bi-person-badge me-1"></i>{{ ucfirst($user->role) }}</span>
                    @elseif($user->role == 'mekanik')
                      <span class="badge badge-modern badge-mekanik"><i class="bi bi-tools me-1"></i>{{ ucfirst($user->role) }}</span>
                    @else
                      <span class="badge badge-modern" style="background: #6c757d; color: white;">{{ ucfirst($user->role) }}</span>
                    @endif
                  </td>
                  <td><i class="bi bi-calendar-event me-2" style="color: #6c757d;"></i>{{ $user->created_at->format('d M Y') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="6">
                    <div class="empty-state">
                      <i class="bi bi-inbox"></i>
                      <h5>Belum ada user yang sesuai filter</h5>
                      <p>Coba ubah kata kunci atau kriteria pencarian Anda</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const roleSelect = document.getElementById('role');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const tableBody = document.getElementById('user-table-body');
        const filterForm = document.querySelector('form');
        
        // Disable default form submission for enter key
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            fetchUsers();
        });

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        // Main fetch function
        function fetchUsers() {
            // Show loading state
            tableBody.style.opacity = '0.5';
            
            const params = new URLSearchParams({
                search: searchInput.value,
                role: roleSelect.value,
                start_date: startDateInput.value,
                end_date: endDateInput.value
            });

            const url = `{{ route('admin.user.index') }}?${params.toString()}`;

            // Update URL in browser without reload
            window.history.pushState({}, '', url);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTableBody = doc.getElementById('user-table-body');
                
                if (newTableBody) {
                    tableBody.innerHTML = newTableBody.innerHTML;
                }
                
                // Restore opacity
                tableBody.style.opacity = '1';
            })
            .catch(error => {
                console.error('Error:', error);
                tableBody.style.opacity = '1';
            });
        }

        // Event listeners
        const debouncedFetch = debounce(fetchUsers, 500); // Wait 500ms after typing stops

        searchInput.addEventListener('input', debouncedFetch);
        roleSelect.addEventListener('change', fetchUsers);
        startDateInput.addEventListener('change', fetchUsers);
        endDateInput.addEventListener('change', fetchUsers);
    });
  </script>


@endsection