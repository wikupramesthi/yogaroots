@extends('layouts.mobile')
@section('title', __('mobile.notifications'))
@section('content')

<section class="screen active" id="notifications">
    <div class="px-4 pt-4">

        {{-- HEADER --}}
        <div class="mb-1">
            <a href="{{ route('dashboard.index') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center mb-3" onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="ms-2 small fw-semibold">{{ __('mobile.back') }}</span>
            </a>
            <p class="eyebrow mb-1">{{ __('mobile.inbox') }}</p>
            <h1 class="fw-semibold mb-0" style="font-size: 28px;">{{ __('mobile.notifications') }}</h1>
            <p class="small text-muted2 mb-0 mt-1">
                @if ($unreadCount > 0)
                    {{ trans_choice('mobile.unread_line', $unreadCount, ['count' => $unreadCount]) }}
                @else
                    {{ __('mobile.all_caught_up') }}
                @endif
            </p>
        </div>

        {{-- FILTER + MARK ALL --}}
        <div class="d-flex align-items-center justify-content-between gap-2 mt-4">
            <div class="d-flex gap-2">
                <a href="{{ route('notifications.index', ['filter' => 'all']) }}"
                    class="filter d-inline-block text-decoration-none {{ $filter !== 'unread' ? 'active' : '' }}">{{ __('mobile.all') }}</a>
                <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                    class="filter d-inline-block text-decoration-none {{ $filter === 'unread' ? 'active' : '' }}">
                    {{ __('mobile.unread') }}{{ $unreadCount > 0 ? ' (' . $unreadCount . ')' : '' }}
                </a>
            </div>
            @if ($unreadCount > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 text-terra fw-semibold text-decoration-none text-small">
                        {{ __('mobile.mark_all_read') }}
                    </button>
                </form>
            @endif
        </div>

        {{-- LIST --}}
        <div class="d-grid gap-3 mt-3" style="max-height: calc(100vh - 310px); overflow-y: auto; padding-right: 2px;">
            @forelse ($notifications as $notif)
                @php
                    $payload = $notif->data ?? [];
                    $isUnread = is_null($notif->read_at);
                    $path = $payload['path'] ?? null;
                @endphp
                <div class="app-card p-3 notif-item {{ $isUnread ? 'border' : '' }}"
                    data-notif-id="{{ $notif->id }}"
                    data-notif-path="{{ $path }}"
                    role="{{ $path ? 'link' : 'article' }}"
                    tabindex="{{ $path ? '0' : '-1' }}"
                    style="{{ $path ? 'cursor:pointer;' : '' }}{{ $isUnread ? 'border-color: var(--sage);' : '' }}">
                    <div class="d-flex align-items-start gap-3">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 {{ $isUnread ? 'grad-sage' : 'bg-sage-soft' }}"
                            style="width:44px;height:44px;border-radius:15px;">
                            <i class="bi {{ $payload['icon'] ?? 'bi-bell' }} {{ $isUnread ? 'text-white' : 'text-sage' }}"></i>
                        </div>
                        <div class="flex-fill min-w-0">
                            <div class="d-flex align-items-start justify-content-between gap-2">
                                <p class="mb-1 small fw-semibold {{ $isUnread ? '' : 'text-muted' }}">
                                    {{ $payload['judul_kegiatan'] ?? 'Notification' }}
                                </p>
                                @if ($isUnread)
                                    <span class="rounded-circle flex-shrink-0 mt-1"
                                        style="height: 8px; width: 8px; background: var(--terra);"></span>
                                @endif
                            </div>
                            <p class="mb-1 text-muted2 text-small" style="line-height:1.5;">
                                {{ $payload['message'] ?? '-' }}
                            </p>
                            <p class="mb-0 text-muted2 m-meta">
                                {{ $notif->created_at?->diffForHumans() }}
                                @if ($path)
                                    <span class="mx-1">•</span>
                                    <span class="text-sage fw-semibold">{{ __('mobile.tap_to_view') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="app-card text-center p-4">
                    <i class="bi bi-bell-slash text-muted2 fs-3"></i>
                    <p class="mb-1 mt-2 small fw-semibold">
                        {{ $filter === 'unread' ? __('mobile.no_unread') : __('mobile.no_notifications') }}
                    </p>
                    <p class="mb-0 text-muted2 text-small">
                        {{ __('mobile.notif_empty_desc') }}
                    </p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if ($notifications->hasPages())
            <div class="d-flex align-items-center justify-content-between mt-4">
                @if ($notifications->onFirstPage())
                    <span></span>
                @else
                    <a href="{{ $notifications->previousPageUrl() }}"
                        class="filter d-inline-block text-decoration-none">{{ __('mobile.newer') }}</a>
                @endif
                <span class="text-muted2 text-small">
                    {{ __('mobile.page_of', ['current' => $notifications->currentPage(), 'last' => $notifications->lastPage()]) }}
                </span>
                @if ($notifications->hasMorePages())
                    <a href="{{ $notifications->nextPageUrl() }}"
                        class="filter d-inline-block text-decoration-none">{{ __('mobile.older') }}</a>
                @else
                    <span></span>
                @endif
            </div>
        @endif

        <div style="height: 24px"></div>
    </div>
</section>

@push('after-script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        document.querySelectorAll('.notif-item[data-notif-path]').forEach(function (el) {
            function open() {
                var id = el.getAttribute('data-notif-id');
                var path = el.getAttribute('data-notif-path');
                if (!id || !path) return;

                fetch("{{ url('notifications') }}/" + id + "/read", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                }).finally(function () {
                    window.location.href = path;
                });
            }

            el.addEventListener('click', open);
            el.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    open();
                }
            });
        });
    });
</script>
@endpush

@endsection
