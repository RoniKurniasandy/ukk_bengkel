<div class="sidebar bg-dark text-white position-fixed h-100" id="sidebar" style="width:250px;">
  <div class="p-3 border-bottom">
    <h5 class="fw-bold">Bengkel Mobil Sejahtera</h5>
  </div>

  <ul class="nav flex-column" style=" height: calc(100% - 89.06px);">
    <li class="nav-item">
      <a href="{{ route('dashboard') }}"
        class="nav-link text-white {{ request()->is('dashboard') ? 'active bg-primary' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
      </a>
    </li>

    @if(Auth::check() && Auth::user()->role === 'admin')
      <li class="nav-item"><a href="{{ route('admin.servis.index') }}" class="nav-link text-white"><i
            class="bi bi-wrench me-2"></i> Manajemen Servis</a></li>
      <li class="nav-item"><a href="{{ route('admin.users') }}" class="nav-link text-white"><i
            class="bi bi-people me-2"></i> Data Pengguna</a></li>
      <li class="nav-item"><a href="{{ route('admin.stok.index') }}" class="nav-link text-white"><i
            class="bi bi-box-seam me-2"></i> Stok Sparepart</a></li>
      <li class="nav-item"><a href="{{ route('admin.layanan.index') }}" class="nav-link text-white"><i
            class="bi bi-gear me-2"></i> Layanan</a></li>
      <li class="nav-item"><a href="{{ route('admin.transaksi') }}" class="nav-link text-white"><i
            class="bi bi-cash-stack me-2"></i> Transaksi</a></li>
    @endif

    @if(Auth::check() && Auth::user()->role === 'mekanik')
      <li class="nav-item"><a href="{{ route('mekanik.servis.aktif') }}" class="nav-link text-white"><i
            class="bi bi-tools me-2"></i> Servis Dikerjakan</a></li>
      <li class="nav-item"><a href="{{ route('mekanik.servis.selesai') }}" class="nav-link text-white"><i
            class="bi bi-check-circle me-2"></i> Servis Selesai</a></li>
    @endif

    @if(Auth::check() && Auth::user()->role === 'pelanggan')
      <li class="nav-item">
        <a href="{{ route('user.servis') }}"
          class="nav-link text-white {{ request()->is('pelanggan/servis') ? 'active bg-primary' : '' }}">
          <i class="bi bi-tools me-2"></i> Servis Saya
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('user.kendaraan') }}"
          class="nav-link text-white {{ request()->is('pelanggan/kendaraan') ? 'active bg-primary' : '' }}">
          <i class="bi bi-car-front me-2"></i> Kendaraan Saya
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('user.booking.index') }}"
          class="nav-link text-white {{ request()->is('pelanggan/booking') ? 'active bg-primary' : '' }}">
          <i class="bi bi-calendar-check me-2"></i> Booking Servis
        </a>
      </li>
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