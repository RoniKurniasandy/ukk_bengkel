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
