@extends('layouts.mobile')
@section('title', $tab === 'today' ? __('mobile.today_schedule') : __('mobile.upcoming_classes'))
@section('content')

<section class="screen active" id="schedules">
    <div class="px-4 pt-4">

        {{-- HEADER --}}
        <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="{{ route('dashboard.index') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center"
                onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="ms-2 small fw-semibold">{{ __('mobile.back') }}</span>
            </a>
            <a href="{{ route('notifications.index') }}"
                class="app-card border-0 rounded-circle position-relative d-flex align-items-center justify-content-center text-dark text-decoration-none flex-shrink-0"
                style="height: 44px; width: 44px; border-radius: 50% !important"
                aria-label="{{ __('mobile.notifications') }}">
                <i class="bi bi-bell"></i>
                @if (!empty($unreadCount))
                    <span class="position-absolute rounded-circle"
                        style="height: 8px; width: 8px; background: var(--terra); top: 10px; right: 10px;"></span>
                @endif
            </a>
        </div>

        <div class="mb-1">
            <p class="eyebrow mb-1">{{ __('mobile.schedules') }}</p>
            <h1 class="fw-semibold mb-0" style="font-size: 28px;">
                {{ $tab === 'today' ? __('mobile.today_schedule') : __('mobile.upcoming_classes') }}
            </h1>
            <p class="small text-muted2 mb-0 mt-1">
                @if ($tab === 'today')
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('l, j F Y') }}
                @else
                    {{ __('mobile.next_7_days', ['date' => \Carbon\Carbon::parse($date)->translatedFormat('j M')]) }}
                @endif
            </p>
        </div>

        {{-- QUICK LINKS --}}
        <div class="d-flex gap-2 mt-3">
            <a href="{{ route('bookings.my') }}"
                class="app-card flex-fill text-decoration-none text-dark d-flex align-items-center gap-2 px-3 py-2">
                <i class="bi bi-calendar-check text-sage"></i>
                <span class="text-small fw-semibold">{{ __('mobile.my_bookings') }}</span>
            </a>
            <a href="{{ route('orders.index') }}"
                class="app-card flex-fill text-decoration-none text-dark d-flex align-items-center gap-2 px-3 py-2">
                <i class="bi bi-receipt text-sage"></i>
                <span class="text-small fw-semibold">{{ __('mobile.my_orders') }}</span>
            </a>
        </div>

        {{-- TABS --}}
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('schedules.index', array_filter(['tab' => 'today', 'search' => $search ?? null, 'studio' => $studioUuid ?? null, 'level' => $level ?? null])) }}"
                class="filter d-inline-block text-decoration-none {{ $tab === 'today' ? 'active' : '' }}">{{ __('mobile.today') }}</a>
            <a href="{{ route('schedules.index', array_filter(['tab' => 'upcoming', 'search' => $search ?? null, 'studio' => $studioUuid ?? null, 'level' => $level ?? null])) }}"
                class="filter d-inline-block text-decoration-none {{ $tab === 'upcoming' ? 'active' : '' }}">{{ __('mobile.upcoming') }}</a>
        </div>

        {{-- SEARCH + FILTER --}}
        <form method="GET" action="{{ route('schedules.index') }}" class="mt-3">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="app-card d-flex align-items-center gap-2 px-3 py-2">
                <i class="bi bi-search text-muted2"></i>
                <input type="search" name="search" value="{{ $search ?? '' }}"
                    class="border-0 bg-transparent w-100 small" style="outline:none"
                    placeholder="{{ __('mobile.search_class_instructor') }}" autocomplete="off">
                @if (!empty($search) || !empty($studioUuid) || !empty($level))
                    <a href="{{ route('schedules.index', ['tab' => $tab]) }}" class="text-muted2" aria-label="Clear filters">
                        <i class="bi bi-x-circle"></i>
                    </a>
                @endif
            </div>
            <div class="d-flex gap-2 mt-2">
                <select name="studio" class="form-control form-control-sm" onchange="this.form.submit()" aria-label="Studio filter">
                    <option value="">{{ __('mobile.all_studios') }}</option>
                    @foreach (($studios ?? []) as $studio)
                        <option value="{{ $studio->uuid }}" @selected(($studioUuid ?? '') === $studio->uuid)>{{ $studio->name }}</option>
                    @endforeach
                </select>
                <select name="level" class="form-control form-control-sm" onchange="this.form.submit()" aria-label="Level filter">
                    <option value="">{{ __('mobile.all_levels') }}</option>
                    @foreach (['foundation' => 'Foundation', 'intermediate' => 'Intermediate', 'advance' => 'Advance'] as $lv => $label)
                        <option value="{{ $lv }}" @selected(($level ?? '') === $lv)>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sage btn-sm text-nowrap">{{ __('mobile.search') }}</button>
            </div>
        </form>

        {{-- TODAY LIST --}}
        @if ($tab === 'today')
            <div class="d-grid gap-3 mt-3">
                @forelse ($schedules as $schedule)
                    @include('pages.mobile.partials.schedule-card', [
                        'schedule' => $schedule,
                        'bookingDate' => $date,
                        'showDate' => false,
                    ])
                @empty
                    <div class="app-card text-center p-4">
                        <i class="bi bi-calendar2-week text-muted2 fs-3"></i>
                        <p class="mb-1 small fw-semibold">{{ __('mobile.no_classes_today') }}</p>
                        <p class="mb-0 text-muted2 text-small">
                            {{ __('mobile.no_classes_today_desc') }}
                        </p>
                    </div>
                @endforelse
            </div>
        @endif

        {{-- UPCOMING GROUPS --}}
        @if ($tab === 'upcoming')
            @foreach ($groups as $group)
                <p class="small fw-semibold {{ $loop->first ? 'mt-3' : 'mt-4' }} mb-2 text-sage">
                    {{ \Carbon\Carbon::parse($group['date'])->translatedFormat('l, j F Y') }}
                </p>
                <div class="d-grid gap-3">
                    @forelse ($group['schedules'] as $schedule)
                        @include('pages.mobile.partials.schedule-card', [
                            'schedule' => $schedule,
                            'bookingDate' => $group['date'],
                            'showDate' => false,
                        ])
                    @empty
                        <div class="app-card text-center p-3">
                            <p class="mb-0 text-muted2 text-small">{{ __('mobile.no_classes_day') }}</p>
                        </div>
                    @endforelse
                </div>
            @endforeach
        @endif

        <div style="height: 24px"></div>
    </div>
</section>

@endsection
