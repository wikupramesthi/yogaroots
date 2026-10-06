@extends('layouts.mobile')
@section('title', $tab === 'today' ? "Today's Schedule" : 'Upcoming Classes')
@section('content')

<section class="screen active" id="schedules">
    <div class="px-4 pt-4">

        {{-- HEADER --}}
        <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="{{ route('dashboard.index') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center justify-content-center"
                style="height: 44px; width: 44px;"
                aria-label="Back">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <a href="{{ route('notifications.index') }}"
                class="app-card border-0 rounded-circle position-relative d-flex align-items-center justify-content-center text-dark text-decoration-none flex-shrink-0"
                style="height: 44px; width: 44px; border-radius: 50% !important"
                aria-label="Notifications">
                <i class="bi bi-bell"></i>
                @if (!empty($unreadCount))
                    <span class="position-absolute rounded-circle"
                        style="height: 8px; width: 8px; background: var(--terra); top: 10px; right: 10px;"></span>
                @endif
            </a>
        </div>

        <div class="mb-1">
            <p class="eyebrow mb-1">Schedules</p>
            <h1 class="fw-semibold mb-0" style="font-size: 28px;">
                {{ $tab === 'today' ? "Today's Schedule" : 'Upcoming Classes' }}
            </h1>
            <p class="small text-muted2 mb-0 mt-1">
                @if ($tab === 'today')
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('l, j F Y') }}
                @else
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('l, j F Y') }} · Tomorrow
                @endif
            </p>
        </div>

        {{-- TABS --}}
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('schedules.index', ['tab' => 'today']) }}"
                class="filter d-inline-block text-decoration-none {{ $tab === 'today' ? 'active' : '' }}">
                Today
            </a>
            <a href="{{ route('schedules.index', ['tab' => 'upcoming']) }}"
                class="filter d-inline-block text-decoration-none {{ $tab === 'upcoming' ? 'active' : '' }}">
                Upcoming
            </a>
        </div>

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
                        <p class="mb-1 small fw-semibold">No Classes Today</p>
                        <p class="mb-0 text-muted2 text-small">
                            There are no classes scheduled for today.
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
                            <p class="mb-0 text-muted2 text-small">No classes that day.</p>
                        </div>
                    @endforelse
                </div>
            @endforeach
        @endif

        <div style="height: 24px"></div>
    </div>
</section>

@endsection
