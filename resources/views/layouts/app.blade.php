<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard - Bengkel Mobil')</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  @include('layouts.sidebar')

  <div class="main-content">
    <!--  Navbar di atas konten -->
    <nav class="navbar-dashboard d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <button class="btn btn-outline-primary btn-sm d-lg-none me-3" id="toggleSidebar">
          <i class="bi bi-list"></i>
        </button>
        <span class="page-title">@yield('title', 'Dashboard')</span>
      </div>

      <div class="d-flex align-items-center me-3">
        {{-- Notification Bell --}}
        <div class="dropdown me-3">
            <button class="btn btn-link position-relative text-dark p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell fs-4"></i>
                @if($unreadNotificationsCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        {{ $unreadNotificationsCount }}
                    </span>
                @endif
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0 overflow-hidden" style="width: 300px;">
                <li class="dropdown-header bg-light py-3 border-bottom">
                    <h6 class="mb-0 fw-bold">Notifikasi</h6>
                </li>
                <div class="notification-list" style="max-height: 350px; overflow-y: auto;">
                    @forelse($recentNotifications as $notification)
                        <li>
                            <a class="dropdown-item p-3 border-bottom d-flex align-items-start {{ $notification->read_at ? '' : 'bg-light-subtle' }}" href="{{ $notification->data['url'] ?? '#' }}">
                                <div class="bg-{{ $notification->data['type'] ?? 'info' }}-subtle text-{{ $notification->data['type'] ?? 'info' }} rounded-circle p-2 me-3">
                                    <i class="bi {{ $notification->data['icon'] ?? 'bi-info-circle' }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small text-wrap">{{ $notification->data['title'] }}</div>
                                    <div class="small text-muted text-wrap">{{ $notification->data['message'] }}</div>
                                    <div class="x-small text-muted mt-1" style="font-size: 0.7rem;">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="p-4 text-center text-muted">
                            <i class="bi bi-bell-slash fs-2 mb-2 d-block"></i>
                            <span class="small">Tidak ada notifikasi baru</span>
                        </li>
                    @endforelse
                </div>
                @if(count($recentNotifications) > 0)
                    <li class="p-2 text-center bg-light">
                        <button id="markAllRead" class="btn btn-link btn-sm small text-primary text-decoration-none fw-semibold border-0">Tandai semua terbaca</button>
                    </li>
                @endif
            </ul>
        </div>
      </div>
    </nav>

    <!--  Area konten utama -->
    <div class="p-4">
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle me-2"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle me-2"></i>
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @yield('content')
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    toggleBtn?.addEventListener('click', () => sidebar.classList.toggle('show'));
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      console.log('Antigravity: System UI initialized.');

      const hasSwal = typeof Swal !== 'undefined';
      if (!hasSwal) console.warn('Antigravity Warning: SweetAlert2 not loaded correctly.');

      // Konfigurasi Toast
      const showToast = (icon, title) => {
        if (hasSwal) {
          Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
          }).fire({ icon, title });
        } else {
          console.log('Success:', title);
        }
      };

      @if(session('success'))
        showToast('success', "{{ session('success') }}");
      @endif

      @if(session('error'))
        if (hasSwal) {
          Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: "{{ session('error') }}",
            confirmButtonColor: '#4f46e5',
          });
        } else {
          alert("Perhatian: {{ session('error') }}");
        }
      @endif

      @if($errors->any())
        if (hasSwal) {
          let errorMessages = '';
          @foreach($errors->all() as $error)
            errorMessages += "{{ $error }}\n";
          @endforeach

          Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: errorMessages,
            confirmButtonColor: '#f5576c',
          });
        }
      @endif

      // Global Delete Confirmation
      document.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.delete-confirm');
        if (deleteBtn) {
          e.preventDefault();
          const form = deleteBtn.closest('form');
          const message = deleteBtn.dataset.message || 'Yakin ingin menghapus data ini?';
          
          if (hasSwal) {
            Swal.fire({
              title: 'Konfirmasi Hapus',
              text: message,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#f5576c',
              cancelButtonColor: '#6c757d',
              confirmButtonText: 'Ya, Hapus!',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                if (typeof form.requestSubmit === 'function') {
                  form.requestSubmit(deleteBtn);
                } else {
                  form.submit();
                }
              }
            });
          } else {
            if (confirm(message)) {
              form.submit();
            }
          }
        }

        // Global Save/Submit Confirmation
        const saveBtn = e.target.closest('.save-confirm');
        if (saveBtn) {
          e.preventDefault();
          const form = saveBtn.closest('form');
          const message = saveBtn.dataset.message || 'Apakah Anda yakin ingin menyimpan perubahan ini?';
          
          if (hasSwal) {
            Swal.fire({
              title: 'Konfirmasi Simpan',
              text: message,
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#4f46e5',
              cancelButtonColor: '#6c757d',
              confirmButtonText: 'Ya, Simpan',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                if (typeof form.requestSubmit === 'function') {
                  form.requestSubmit(saveBtn);
                } else {
                  form.submit();
                }
              }
            });
          } else {
            if (confirm(message)) {
              form.submit();
            }
          }
        }
      });
    });
  </script>

  <script>
    document.getElementById('markAllRead')?.addEventListener('click', function(e) {
        e.preventDefault();
        fetch("{{ route('notifications.markAllRead') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    });
  </script>

  @stack('scripts')
</body>

</html>