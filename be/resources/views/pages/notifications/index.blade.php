@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Notifications" page="Account" active="Notifications"
        route="{{ route('notifications.index') }}" />
@endsection

<section class="section">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-3 fade show" role="alert">
            <span class="alert-text text-white">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="card-title mb-0">All Notifications</h5>
                @if ($unreadCount > 0)
                    <span class="badge bg-danger-subtle text-danger">{{ $unreadCount }} unread</span>
                @endif
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="btn-group" role="group">
                    <a href="{{ route('notifications.index') }}"
                        class="btn btn-sm {{ $filter === 'all' ? 'btn-primary' : 'btn-light' }}">All</a>
                    <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                        class="btn btn-sm {{ $filter === 'unread' ? 'btn-primary' : 'btn-light' }}">Unread</a>
                </div>
                @if ($unreadCount > 0)
                    <form action="{{ route('notifications.readAll') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="bi bi-check2-all me-1"></i>Mark all as read
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse ($notifications as $notification)
                    <div
                        class="list-group-item d-flex align-items-start gap-3 px-4 py-3 {{ $notification->read_at ? '' : 'bg-primary bg-opacity-10' }}">
                        <span class="mt-1">
                            <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }} fs-5 text-primary"></i>
                        </span>
                        <div class="flex-fill min-w-0">
                            <p class="fw-bold mb-0 text-dark">
                                {{ $notification->data['judul_kegiatan'] ?? 'Notification' }}
                            </p>
                            <p class="mb-1">{{ $notification->data['message'] ?? '-' }}</p>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i>
                                {{ $notification->created_at->diffForHumans() }}
                                ({{ $notification->created_at->format('d M Y H:i') }})
                            </small>
                        </div>
                        <div class="d-flex flex-column gap-2 flex-shrink-0">
                            @if (!empty($notification->data['path']))
                                <a href="{{ $notification->data['path'] }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                            @endif
                            @if (!$notification->read_at)
                                <a href="javascript:void(0)" class="btn btn-sm btn-light mark-as-read"
                                    data-id="{{ $notification->id }}">
                                    <i class="bi bi-check-lg me-1"></i>Mark read
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-bell-slash fs-3 d-block mb-2"></i>
                        No notifications yet.
                    </div>
                @endforelse
            </div>

            @if ($notifications->hasPages())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 px-4 py-3">
                    <div class="text-muted small">
                        Showing <strong>{{ $notifications->firstItem() }}</strong> –
                        <strong>{{ $notifications->lastItem() }}</strong> of
                        <strong>{{ $notifications->total() }}</strong> notifications
                    </div>
                    <div>{{ $notifications->links() }}</div>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
