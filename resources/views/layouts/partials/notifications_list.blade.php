@forelse($recentNotifications as $notification)
    <a class="dropdown-item d-flex align-items-center py-3 border-bottom {{ $notification->read_at ? 'bg-light opacity-75' : 'bg-white' }}" href="#">
        <div class="flex-shrink-0 me-3">
            <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                <i class="bi bi-bell-fill"></i>
            </div>
        </div>
        <div class="flex-grow-1">
            <div class="small text-muted float-end">{{ $notification->created_at->diffForHumans() }}</div>
            <div class="{{ $notification->read_at ? 'text-muted' : 'fw-bold text-dark' }} mb-1">
                {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
            </div>
            <div class="small text-muted text-truncate" style="max-width: 250px;">
                {{ $notification->data['message'] ?? 'Klik untuk detail' }}
            </div>
        </div>
    </a>
@empty
    <div class="dropdown-item text-center py-4 text-muted">
        <i class="bi bi-bell-slash fs-2 d-block mb-2 opacity-25"></i>
        <p class="mb-0 small">Belum ada notifikasi</p>
    </div>
@endforelse
