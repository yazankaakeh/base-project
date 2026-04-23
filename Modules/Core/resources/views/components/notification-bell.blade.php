@php
    $notifications = auth()->user()->notifications()->latest()->take(5)->get();
    $unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<div class="dropdown">
    <button class="btn btn-icon btn-outline-secondary dropdown-toggle hide-arrow" type="button"
            data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ti tabler-bell"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadCount }}
                <span class="visually-hidden">unread notifications</span>
            </span>
        @endif
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <div class="dropdown-header d-flex align-items-center py-3">
            <h6 class="mb-0 me-auto">{{ trans('core::core.notifications.title') }}</h6>
            @if($unreadCount > 0)
                <span class="badge bg-label-primary rounded-pill">{{ $unreadCount }}</span>
            @endif
        </div>

        @if($notifications->count() > 0)
            <div class="dropdown-body">
                @foreach($notifications as $notification)
                    <div class="list-group list-group-flush">
                        <a href="javascript:void(0);"
                           class="list-group-item list-group-item-action dropdown-notifications-item {{ $notification->read_at ? '' : 'unread' }}"
                           onclick="markAsRead('{{ $notification->id }}')">
                            <div class="d-flex gap-2">
                                <div class="flex-shrink-0">
                                    <div class="avatar me-1">
                                        <span class="avatar-initial rounded-circle bg-label-{{ $notification->read_at ? 'secondary' : 'primary' }}">
                                            <i class="ti tabler-{{ $notification->data['icon'] ?? 'bell' }}"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                    <h6 class="mb-1 text-truncate">{{ $notification->data['title'] ?? 'Notification' }}</h6>
                                    <small class="text-truncate text-body">{{ $notification->data['body'] ?? $notification->data['message'] ?? '' }}</small>
                                    <div class="d-flex align-items-center gap-1">
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        @if(!$notification->read_at)
                                            <span class="badge bg-label-primary rounded-pill">New</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="dropdown-footer">
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary text-nowrap w-100">
                    {{ trans('core::core.notifications.viewAll') }}
                </a>
            </div>
        @else
            <div class="dropdown-body">
                <div class="text-center py-3">
                    <i class="ti tabler-bell-off text-muted" style="font-size: 2rem;"></i>
                    <p class="text-muted mt-2 mb-0">{{ trans('core::core.notifications.noNotifications') }}</p>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.notification-bell .dropdown-menu {
    width: 350px;
    max-height: 400px;
    overflow-y: auto;
}

.notification-bell .list-group-item.unread {
    background-color: rgba(var(--bs-primary-rgb), 0.1);
    border-left: 3px solid var(--bs-primary);
}

.notification-bell .list-group-item:hover {
    background-color: var(--bs-light);
}

.notification-bell .badge {
    font-size: 0.75rem;
}
</style>

<script>
function markAsRead(notificationId) {
    fetch(`/doctor/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload the page to update the notification count
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}
</script>
