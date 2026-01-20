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
  <div class="no-print">
    @include('layouts.sidebar')
  </div>

  <div class="main-content">
    <!--  Navbar di atas konten -->
    <nav class="navbar-dashboard d-flex justify-content-between align-items-center no-print">
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
                    <span id="notification-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        {{ $unreadNotificationsCount }}
                    </span>
                @else
                    <span id="notification-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" style="font-size: 0.6rem;">
                        0
                    </span>
                @endif
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0 overflow-hidden" style="width: 300px;">
                <li class="dropdown-header bg-light py-3 border-bottom">
                    <h6 class="mb-0 fw-bold">Notifikasi</h6>
                </li>
                <div class="notification-list" style="max-height: 350px; overflow-y: auto;">
                    @include('layouts.partials.notifications_list')
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

      // Modern Toast Configuration
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#ffffff',
        color: '#1e293b',
        iconColor: 'var(--primary-color, #4f46e5)',
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

      const showToast = (icon, title) => {
        if (hasSwal) {
          Toast.fire({ 
            icon: icon, 
            title: title,
            customClass: {
              popup: 'shadow-sm border-0 rounded-4'
            }
          });
        } else {
          console.log(`${icon.toUpperCase()}:`, title);
        }
      };

      @if(session('success'))
        showToast('success', "{{ session('success') }}");
      @endif

      @if(session('error'))
        if (hasSwal) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            confirmButtonColor: '#1e3a8a',
            background: '#ffffff',
            customClass: {
              popup: 'rounded-4 border-0 shadow'
            },
            showClass: {
              popup: 'animate__animated animate__fadeInDown'
            }
          });
        } else {
          alert("Error: {{ session('error') }}");
        }
      @endif

      @if($errors->any())
        if (hasSwal) {
          let errors = @json($errors->all());
          let errorMessages = errors.map(error => `• ${error}<br>`).join('');

          Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            html: `<div class="text-start small">${errorMessages}</div>`,
            confirmButtonColor: '#ef4444',
            customClass: {
              popup: 'rounded-4 border-0 shadow'
            }
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
                if (deleteBtn.type === 'submit' && typeof form.requestSubmit === 'function') {
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
                if (saveBtn.type === 'submit' && typeof form.requestSubmit === 'function') {
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
                // Instead of reload, just clear the UI immediately
                const countBadge = document.getElementById('notification-count');
                if (countBadge) {
                    countBadge.textContent = '0';
                    countBadge.classList.add('d-none');
                }
                updateRealtimeData(); // Refresh list via AJAX
            }
        });
    });

    // Real-time Updates (Polling)
    function updateRealtimeData() {
        fetch("{{ route('realtime.updates') }}", {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update Notification Count
            const countBadge = document.getElementById('notification-count');
            if (countBadge) {
                countBadge.textContent = data.unreadNotificationsCount;
                if (data.unreadNotificationsCount > 0) {
                    countBadge.classList.remove('d-none');
                } else {
                    countBadge.classList.add('d-none');
                }
            }

            // Update Notification List
            const listContainer = document.querySelector('.notification-list');
            if (listContainer && data.recentNotifications) {
                listContainer.innerHTML = data.recentNotifications;
            }

            // Update Sidebar Badges
            if (data.sideBadges) {
                for (const [id, count] of Object.entries(data.sideBadges)) {
                    const badgeId = `badge-${id.replace(/_/g, '-')}`;
                    const badgeElem = document.getElementById(badgeId);
                    if (badgeElem) {
                        badgeElem.textContent = count;
                        if (count > 0) {
                            badgeElem.classList.remove('d-none');
                        } else {
                            badgeElem.classList.add('d-none');
                        }
                    }
                }
            }
        })
        .catch(error => console.error('Realtime update error:', error));
    }

    // Start polling every 5 seconds
    @auth
        setInterval(updateRealtimeData, 5000);
    @endauth
  </script>

  @stack('scripts')
</body>

</html>