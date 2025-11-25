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


    </nav>

    <!--  Area konten utama -->
    <div class="p-4">
      @yield('content')
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    toggleBtn?.addEventListener('click', () => sidebar.classList.toggle('show'));
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>