<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard - Bengkel Mobil')</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: "Poppins", sans-serif;
    }

    .main-content {
      margin-left: 250px;
      transition: all 0.3s ease;
      min-height: 100vh;
      background-color: #f8f9fa;
    }

    @media (max-width: 992px) {
      .main-content {
        margin-left: 0;
      }
    }

    .navbar-dashboard {
      background-color: #ffffff;
      border-bottom: 1px solid #dee2e6;
      padding: 12px 20px;
    }

    .page-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: #1e40af;
    }

    .user-info {
      font-weight: 500;
      color: #374151;
    }
  </style>
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
