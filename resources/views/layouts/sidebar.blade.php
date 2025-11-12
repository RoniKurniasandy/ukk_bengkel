<div class="sidebar bg-dark text-white position-fixed h-100" id="sidebar" style="width:250px;">
  <div class="p-3 border-bottom">
    <h5 class="fw-bold">Bengkel Mobil Sejahtera</h5>
  </div>

  <ul class="nav flex-column" style=" height: calc(100% - 89.06px);">
    <li class="nav-item">
      <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->is('dashboard') ? 'active bg-primary' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
      </a>
    </li>

    @if(Auth::check() && Auth::user()->role === 'admin')
      <li class="nav-item"><a href="{{ route('admin.users') }}" class="nav-link text-white">Kelola User</a></li>
      <li class="nav-item"><a href="{{ route('admin.servis') }}" class="nav-link text-white">Kelola Servis</a></li>
      <li class="nav-item"><a href="{{ route('admin.booking') }}" class="nav-link text-white">Kelola Booking</a></li>
      <li class="nav-item"><a href="{{ route('admin.sparepart') }}" class="nav-link text-white">Sparepart</a></li>
      <li class="nav-item"><a href="{{ route('admin.transaksi') }}" class="nav-link text-white">Transaksi</a></li>
    @endif

    @if(Auth::check() && Auth::user()->role === 'mekanik')
      <li class="nav-item"><a href="#" class="nav-link text-white"><i class="bi bi-tools me-2"></i> Servis Dikerjakan</a></li>
      <li class="nav-item"><a href="#" class="nav-link text-white"><i class="bi bi-check-circle me-2"></i> Servis Selesai</a></li>
    @endif

    @if(Auth::check() && Auth::user()->role === 'pelanggan')
      <li class="nav-item"><a href="{{ route('pelanggan.booking.index') }}" class="nav-link text-white"><i></i> Booking</a></li>
      <!-- <li class="nav-item"><a href="{{ route('user.') }}"><i class="bi bi-car-front me-2"></i> Servis Saya</a></li>
      <li class="nav-item"><a href="{{ route('user.') }}e"><i class="bi bi-clock-history me-2"></i> Riwayat Servis</a></li> -->
    @endif

    
    <li class="mt-auto border-top pt-3">
      <div class="d-flex align-items-center">
        <span class="me-3 text-primary fw-semibold">{{ Auth::user()->nama }}</span>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-outline-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Keluar
          </button>
        </form>
      </div>
    </li>
  </ul>
</div>

<style>
  .sidebar .nav-link {
    padding: 10px 15px;
    border-radius: 6px;
    transition: background-color 0.2s;
  }

  .sidebar .nav-link:hover {
    background-color: #2563eb;
  }

  .sidebar .nav-link.active {
    background-color: #1d4ed8;
  }

  @media (max-width: 992px) {
    .sidebar {
      left: -250px;
      transition: all 0.3s;
      z-index: 1050;
    }
    .sidebar.show {
      left: 0;
    }
  }
</style>
