<div class="sidebar bg-dark text-white position-fixed h-100 d-flex flex-column" id="sidebar" style="width:250px;">
    {{-- Header --}}
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-shrink-0">
        <h5 class="fw-bold m-0 text-truncate">Kings Bengkel Mobil</h5>
        <button class="btn btn-link text-white d-lg-none p-0" onclick="document.getElementById('sidebar').classList.remove('show')">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- Navigation List --}}
<ul class="nav flex-column flex-nowrap flex-grow-1 overflow-y-auto py-2 px-2">


        @if(Auth::check() && Auth::user()->role === 'admin')

                    <li class="nav-item mb-1">
                <a href="{{ route('dashboard.admin') }}"
                    class="nav-link text-white rounded d-flex align-items-center {{ request()->routeIs('admin.dashboard*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-speedometer me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- MASTER DATA --}}
            <li class="nav-item mt-3 mb-2 px-3">
                <span class="text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.7rem;">Master Data</span>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.user.index') }}"
                    class="nav-link text-white rounded d-flex align-items-center {{ request()->routeIs('admin.user*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-people me-2"></i>
                    <span>Data Pengguna</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.stok.index') }}"
                    class="nav-link text-white rounded d-flex align-items-center {{ request()->routeIs('admin.stok*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-box-seam me-2"></i>
                    <span>Data Sparepart</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.layanan.index') }}"
                    class="nav-link text-white rounded d-flex align-items-center {{ request()->routeIs('admin.layanan*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-gear me-2"></i>
                    <span>Data Layanan</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.vouchers.index') }}"
                    class="nav-link text-white rounded d-flex align-items-center {{ request()->routeIs('admin.vouchers*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-ticket-perforated me-2"></i>
                    <span>Data Voucher</span>
                </a>
            </li>

            {{-- OPERASIONAL BENGKEL --}}
            <li class="nav-item mt-3 mb-2 px-3">
                <span class="text-white-50 small text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.7rem;">Operasional</span>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.servis.index') }}"
                    class="nav-link text-white rounded d-flex justify-content-between align-items-center {{ request()->routeIs('admin.servis*') ? 'active bg-primary' : '' }}">
                    <div>
                        <i class="bi bi-wrench me-2"></i>
                        <span>Servis & Booking</span>
                    </div>
                    <span id="badge-booking-waiting" class="badge rounded-pill bg-danger shadow-sm {{ ($sideBadges['booking_waiting'] ?? 0) > 0 ? '' : 'd-none' }}">
                        {{ $sideBadges['booking_waiting'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.pembayaran.index') }}"
                    class="nav-link text-white rounded d-flex justify-content-between align-items-center {{ request()->routeIs('admin.pembayaran*') ? 'active bg-primary' : '' }}">
                    <div>
                        <i class="bi bi-credit-card me-2"></i>
                        <span>Data Pembayaran</span>
                    </div>
                    <span id="badge-payment-pending" class="badge rounded-pill bg-danger shadow-sm {{ ($sideBadges['payment_pending'] ?? 0) > 0 ? '' : 'd-none' }}">
                        {{ $sideBadges['payment_pending'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.transaksi') }}"
                    class="nav-link text-white rounded d-flex align-items-center {{ request()->routeIs('admin.transaksi*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    <span>Laporan Transaksi</span>
                </a>
            </li>
        @endif

        @if(Auth::check() && Auth::user()->role === 'mekanik')

          <li class="nav-item mb-1">
                <a href="{{ route('dashboard.mekanik') }}"
                    class="nav-link text-white rounded d-flex align-items-center {{ request()->routeIs('mekanik.dashboard*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-speedometer me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item mb-1">
                <a href="{{ route('mekanik.jadwal.servis') }}" 
                    class="nav-link text-white rounded d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-calendar-check me-2"></i>
                        <span>Jadwal Servis</span>
                    </div>
                    <span id="badge-jadwal-servis" class="badge rounded-pill bg-danger shadow-sm {{ ($sideBadges['jadwal_servis'] ?? 0) > 0 ? '' : 'd-none' }}">
                        {{ $sideBadges['jadwal_servis'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('mekanik.servis.aktif') }}" 
                    class="nav-link text-white rounded d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-tools me-2"></i>
                        <span>Servis Dikerjakan</span>
                    </div>
                    <span id="badge-servis-aktif" class="badge rounded-pill bg-danger shadow-sm {{ ($sideBadges['servis_aktif'] ?? 0) > 0 ? '' : 'd-none' }}">
                        {{ $sideBadges['servis_aktif'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('mekanik.servis.selesai') }}" class="nav-link text-white rounded">
                    <i class="bi bi-check-circle me-2"></i>
                    <span>Servis Selesai</span>
                </a>
            </li>
        @endif

        @if(Auth::check() && Auth::user()->role === 'pelanggan')

                  <li class="nav-item mb-1">
                <a href="{{ route('dashboard.user') }}"
                    class="nav-link text-white rounded d-flex align-items-center {{ request()->routeIs('user.dashboard*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-speedometer me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item mb-1">
                <a href="{{ route('user.servis') }}"
                    class="nav-link text-white rounded d-flex justify-content-between align-items-center {{ request()->is('pelanggan/servis') ? 'active bg-primary' : '' }}">
                    <div>
                        <i class="bi bi-tools me-2"></i>
                        <span>Servis Saya</span>
                    </div>
                    <span id="badge-servis-selesai" class="badge rounded-pill bg-danger shadow-sm {{ ($sideBadges['servis_selesai'] ?? 0) > 0 ? '' : 'd-none' }}">
                        {{ $sideBadges['servis_selesai'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('user.kendaraan') }}"
                    class="nav-link text-white rounded {{ request()->is('pelanggan/kendaraan') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-car-front me-2"></i>
                    <span>Kendaraan Saya</span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('user.booking.index') }}"
                    class="nav-link text-white rounded d-flex justify-content-between align-items-center {{ request()->is('pelanggan/booking') ? 'active bg-primary' : '' }}">
                    <div>
                        <i class="bi bi-calendar-check me-2"></i>
                        <span>Booking Servis</span>
                    </div>
                    <span id="badge-booking-aktif" class="badge rounded-pill bg-danger shadow-sm {{ ($sideBadges['booking_aktif'] ?? 0) > 0 ? '' : 'd-none' }}">
                        {{ $sideBadges['booking_aktif'] ?? 0 }}
                    </span>
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('user.profil.index') }}"
                    class="nav-link text-white rounded {{ request()->is('pelanggan/profil*') ? 'active bg-primary' : '' }}">
                    <i class="bi bi-person-circle me-2"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
        @endif
    </ul>

    {{-- Profile Section --}}
    @auth
    @php
        $profileRoute = match (Auth::user()->role) {
            'pelanggan' => route('user.profil.index'),
            'admin' => route('admin.profil.index'),
            'mekanik' => route('mekanik.profil.index'),
            default => '#'
        };
    @endphp
    <div class="sidebar-profile flex-shrink-0">
        <a href="{{ $profileRoute }}" class="text-decoration-none">
            <div class="d-flex align-items-center p-2 rounded user-profile-hover mb-3">
                <div class="me-2">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/photos/' . Auth::user()->foto) }}" 
                             class="rounded-circle border border-2 border-white" 
                             style="width: 45px; height: 45px; object-fit: cover;"
                             alt="Profile">
                    @else
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 45px; height: 45px; border: 2px solid #fff;">
                            <i class="bi bi-person-fill text-white fs-4"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-grow-1 text-white text-truncate">
                    <div class="fw-bold small text-truncate">{{ Auth::user()->nama }}</div>
                    <div class="text-white-50" style="font-size: 0.7rem;">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
                <div>
                    <i class="bi bi-chevron-right text-white-50 small"></i>
                </div>
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-logout btn-danger w-100 py-2">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar
            </button>
        </form>
    </div>
    @endauth

    <style>
        .sidebar .nav-link {
        padding-top: 0.61rem;
        padding-bottom: 0.61rem;
    }
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }
        .user-profile-hover {
            background-color: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }
        .user-profile-hover:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
            transform: scale(1.02);
        }
    </style>
</div>