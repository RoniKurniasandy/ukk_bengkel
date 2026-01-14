<div class="sidebar bg-dark text-white position-fixed h-100" id="sidebar" style="width:250px;">
  <div class="p-3 border-bottom">
    <h5 class="fw-bold">Kings Bengkel Mobil</h5>
  </div>

  <ul class="nav flex-column" style=" height: calc(100% - 89.06px);">
    <li class="nav-item">
      <a href="{{ route('dashboard') }}"
        class="nav-link text-white {{ request()->is('dashboard') ? 'active bg-primary' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
      </a>
    </li>

    @if(Auth::check() && Auth::user()->role === 'admin')
      {{-- MASTER DATA --}}
      <li class="nav-item mt-3 mb-2">
        <span class="text-white-50 small text-uppercase fw-bold px-3" style="letter-spacing: 1px;">Master Data</span>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.user.index') }}"
          class="nav-link text-white {{ request()->routeIs('admin.user*') ? 'active bg-primary' : '' }}">
          <i class="bi bi-people me-2"></i> Data Pengguna
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.stok.index') }}"
          class="nav-link text-white {{ request()->routeIs('admin.stok*') ? 'active bg-primary' : '' }}">
          <i class="bi bi-box-seam me-2"></i> Data Sparepart
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.layanan.index') }}"
          class="nav-link text-white {{ request()->routeIs('admin.layanan*') ? 'active bg-primary' : '' }}">
          <i class="bi bi-gear me-2"></i> Data Layanan
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.vouchers.index') }}"
          class="nav-link text-white {{ request()->routeIs('admin.vouchers*') ? 'active bg-primary' : '' }}">
          <i class="bi bi-ticket-perforated me-2"></i> Data Voucher
        </a>
      </li>

      {{-- OPERASIONAL BENGKEL --}}
      <li class="nav-item mt-3 mb-2">
        <span class="text-white-50 small text-uppercase fw-bold px-3" style="letter-spacing: 1px;">Operasional</span>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.servis.index') }}"
          class="nav-link text-white {{ request()->routeIs('admin.servis*') ? 'active bg-primary' : '' }} d-flex justify-content-between align-items-center">
          <span><i class="bi bi-wrench me-2"></i> Servis & Booking</span>
          @if(($sideBadges['booking_waiting'] ?? 0) > 0)
            <span class="badge rounded-pill bg-danger shadow-sm">{{ $sideBadges['booking_waiting'] }}</span>
          @endif
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.pembayaran.index') }}"
          class="nav-link text-white {{ request()->routeIs('admin.pembayaran*') ? 'active bg-primary' : '' }} d-flex justify-content-between align-items-center">
          <span><i class="bi bi-credit-card me-2"></i> Data Pembayaran</span>
          @if(($sideBadges['payment_pending'] ?? 0) > 0)
            <span class="badge rounded-pill bg-danger shadow-sm">{{ $sideBadges['payment_pending'] }}</span>
          @endif
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.transaksi') }}"
          class="nav-link text-white {{ request()->routeIs('admin.transaksi*') ? 'active bg-primary' : '' }}">
          <i class="bi bi-file-earmark-text me-2"></i> Laporan Transaksi
        </a>
      </li>
    @endif

    @if(Auth::check() && Auth::user()->role === 'mekanik')
      <li class="nav-item">
        <a href="{{ route('mekanik.jadwal.servis') }}" class="nav-link text-white d-flex justify-content-between align-items-center">
            <span><i class="bi bi-calendar-check me-2"></i> Jadwal Servis</span>
            @if(($sideBadges['jadwal_servis'] ?? 0) > 0)
                <span class="badge rounded-pill bg-danger shadow-sm">{{ $sideBadges['jadwal_servis'] }}</span>
            @endif
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('mekanik.servis.aktif') }}" class="nav-link text-white d-flex justify-content-between align-items-center">
            <span><i class="bi bi-tools me-2"></i> Servis Dikerjakan</span>
            @if(($sideBadges['servis_aktif'] ?? 0) > 0)
                <span class="badge rounded-pill bg-danger shadow-sm">{{ $sideBadges['servis_aktif'] }}</span>
            @endif
        </a>
      </li>
      <li class="nav-item"><a href="{{ route('mekanik.servis.selesai') }}" class="nav-link text-white"><i
            class="bi bi-check-circle me-2"></i> Servis Selesai</a></li>
    @endif

    @if(Auth::check() && Auth::user()->role === 'pelanggan')
      <li class="nav-item">
        <a href="{{ route('user.servis') }}"
          class="nav-link text-white {{ request()->is('pelanggan/servis') ? 'active bg-primary' : '' }} d-flex justify-content-between align-items-center">
          <span><i class="bi bi-tools me-2"></i> Servis Saya</span>
          @if(($sideBadges['servis_selesai'] ?? 0) > 0)
            <span class="badge rounded-pill bg-danger shadow-sm">{{ $sideBadges['servis_selesai'] }}</span>
          @endif
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
          class="nav-link text-white {{ request()->is('pelanggan/booking') ? 'active bg-primary' : '' }} d-flex justify-content-between align-items-center">
          <span><i class="bi bi-calendar-check me-2"></i> Booking Servis</span>
          @if(($sideBadges['booking_aktif'] ?? 0) > 0)
            <span class="badge rounded-pill bg-danger shadow-sm">{{ $sideBadges['booking_aktif'] }}</span>
          @endif
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('user.profil.index') }}"
          class="nav-link text-white {{ request()->is('pelanggan/profil*') ? 'active bg-primary' : '' }}">
          <i class="bi bi-person-circle me-2"></i> Profil Saya
        </a>
      </li>
    @endif

    <li class="mt-auto border-top pt-3">
      @auth
      @php
        $profileRoute = match (Auth::user()->role) {
          'pelanggan' => route('user.profil.index'),
          'admin' => route('admin.profil.index'),
          'mekanik' => route('mekanik.profil.index'),
          default => '#'
        };
      @endphp

      <a href="{{ $profileRoute }}" class="text-decoration-none">
        <div class="d-flex align-items-center p-2 rounded user-profile-hover">
          <div class="me-2">
            @if(Auth::user()->foto)
              <img src="{{ asset('storage/photos/' . Auth::user()->foto) }}" 
                   class="rounded-circle border border-2 border-primary" 
                   style="width: 40px; height: 40px; object-fit: cover;"
                   alt="Profile">
            @else
              <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px;">
                <i class="bi bi-person-fill text-white fs-5"></i>
              </div>
            @endif
          </div>
          <div class="flex-grow-1 text-white">
            <div class="fw-semibold small">{{ Auth::user()->nama }}</div>
            <div class="text-white-50" style="font-size: 0.75rem;">{{ ucfirst(Auth::user()->role) }}</div>
          </div>
          <div>
            <i class="bi bi-chevron-right text-white-50"></i>
          </div>
        </div>
      </a>

      <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button class="btn btn-outline-danger btn-sm w-100">
          <i class="bi bi-box-arrow-right"></i> Keluar
        </button>
      </form>
      @endauth
    </li>
  </ul>

  <style>
    .user-profile-hover {
      transition: all 0.3s ease;
    }

    .user-profile-hover:hover {
      background-color: rgba(255, 255, 255, 0.1);
      transform: translateX(5px);
    }
  </style>
</div>