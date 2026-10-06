@extends('layouts.mobile')
@section('title', 'Dashboard')
@section('content')

<section class="screen {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" id="home">
    <div class="px-4 pt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-1 small text-muted2">
                    {{ now()->translatedFormat('l, j F Y') }}
                </p>

                <h1 class="h3 fw-semibold mb-0">
                    Hi, {{ auth()->user()->name }}
                </h1>
            </div>
            <a href="{{ route('notifications.index') }}"
                class="app-card border-0 rounded-circle position-relative d-flex align-items-center justify-content-center text-dark text-decoration-none"
                style="height: 44px; width: 44px; border-radius: 50% !important"
                aria-label="Notifications">
                <i class="bi bi-bell"></i>
                @if (!empty($unreadCount))
                <span
                    class="position-absolute rounded-circle"
                    style="
                    height: 8px;
                    width: 8px;
                    background: var(--terra);
                    top: 10px;
                    right: 10px;
                  "></span>
                @endif
            </a>
        </div>

        @if ($banner)
        <div class="hero mt-4">

            <img
                src="{{ asset('storage/' . $banner->gambar) }}"
                alt="{{ $banner->nama }}">

            <div class="veil"></div>
            <div class="position-absolute bottom-0 start-0 end-0 p-4">
                <span class="chip bg-light text-dark">
                    <i class="bi bi-heart-fill text-terra"></i>
                    Wellness & Mindfulness
                </span>

                @if ($banner->deskripsi)
                <h2
                    class="fw-semibold text-white mt-3 m-h1"
                    style="line-height:1.1;max-width:90%;">
                    {{ $banner->deskripsi }}
                </h2>
                @endif

                <a href="{{ route('packages.member') }}" class="btn btn-warm px-4 py-2 mt-3">
                    Book Your Class →
                </a>

            </div>
        </div>
        @endif

        <div class="row g-3 mt-1 text-center">
            <div class="col-4">
                <div class="app-card py-3">
                    <p class="mb-0 fw-semibold text-sage">{{ $jumlahInstruktur }}</p>
                    <p class="mb-0 text-muted2 text-small">Instructors</p>
                </div>
            </div>
            <div class=" col-4">
                <div class="app-card py-3">
                    <p class="mb-0 fw-semibold text-sage">{{ $totalClasses }}</p>
                    <p class="mb-0 text-muted2 text-small">
                        Classes
                    </p>
                </div>
            </div>
            <div class="col-4">
                <div class="app-card py-3">
                    <p class="mb-0 fw-semibold text-sage">{{ $totalEvents }}</p>
                    <p class="mb-0 text-muted2 text-small">
                        Events
                    </p>
                </div>
            </div>
        </div>

        @if ($activePackage)
            <a data-bs-toggle="modal" data-bs-target="#activePackageModal" href="#"
                class="text-decoration-none d-block"
                style="cursor:pointer;">
        @endif
            <div class="app-card d-flex align-items-center gap-3 p-3 mt-4">
                <div
                    class="grad-sage d-flex align-items-center justify-content-center"
                    style="height: 48px; width: 48px; border-radius: 18px">
                    <i class="bi bi-flower1"></i>
                </div>
                <div class="flex-fill">
                    @if ($activePackage)
                        <p class="mb-0 small fw-semibold text-dark">{{ $activePackage->package?->name ?? 'Membership' }}</p>
                    <p class="mb-1 text-muted2 text-small">
                        @if ($activePackage->quota === null)
                            Unlimited classes
                        @else
                            {{ $activePackage->quota }} class{{ $activePackage->quota == 1 ? '' : 'es' }} left
                        @endif
                        @if ($activePackage->expired_at)
                            · until {{ $activePackage->expired_at->format('d M Y') }}
                        @endif
                    </p>
                    @if ($activePackage->expired_at && $activePackage->started_at)
                        @php
                            $total = max(1, $activePackage->started_at->diffInSeconds($activePackage->expired_at));
                            $remaining = max(0, now()->diffInSeconds($activePackage->expired_at, false));
                            $pct = min(100, max(0, $remaining / $total * 100));
                        @endphp
                        <div
                            class="progress"
                            style="height: 6px; background: var(--sage-soft)">
                            <div
                                class="progress-bar"
                                style="width: {{ $pct }}%; background-image: var(--grad-sage)"></div>
                        </div>
                    @endif
                @else
                    <p class="mb-0 small fw-semibold">No active package</p>
                    <p class="mb-1 text-muted2 text-small">Pick a membership to start booking classes.</p>
                    <a href="{{ route('packages.member') }}"
                        class="btn btn-link p-0 text-terra fw-semibold text-decoration-none text-small">
                        Browse packages →
                    </a>
                @endif
            </div>
            </div>
        @if ($activePackage)
            </a>

            {{-- Active Package Detail Modal --}}
            <div class="modal fade" id="activePackageModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4 overflow-hidden">
                        <div class="modal-body p-4">
                            <span class="chip bg-sage-soft text-sage text-uppercase m-micro">Active Package</span>
                            <h5 class="fw-bold mt-2 mb-1">{{ $activePackage->package?->name }}</h5>

                            @if ($activePackage->package?->description)
                                <p class="text-muted2 mb-3" style="font-size:13px;line-height:1.6">
                                    {{ $activePackage->package->description }}
                                </p>
                            @endif

                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted2 text-small">Quota</span>
                                <span class="small fw-semibold">
                                    {{ $activePackage->quota === null ? 'Unlimited' : $activePackage->quota . ' classes' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted2 text-small">Started</span>
                                <span class="small fw-semibold">{{ $activePackage->started_at?->format('d M Y') ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="text-muted2" style="font-size:12px">Expires</span>
                                <span class="small fw-semibold">{{ $activePackage->expired_at?->format('d M Y') ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted2" style="font-size:12px">Attended sessions</span>
                                <span class="small fw-semibold">{{ $attendedCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">Today’s Schedule</h3>
            <a href="{{ route('schedules.index', ['tab' => 'today']) }}"
                class="btn btn-link p-0 text-terra fw-semibold text-decoration-none text-small">
                View all
            </a>
        </div>

        <div class="d-grid gap-3 mt-3" id="todayList">

            @forelse ($todaySchedules as $schedule)

            @php
            $booked = $schedule->bookings_count;
            $remaining = max(0, $schedule->capacity - $booked);

            $startTime = \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
            $endTime = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');

            $level = ucfirst($schedule->class?->level ?? '-');
            $className = $schedule->class?->name ?? '-';
            $instructor = $schedule->class?->instructor?->name ?? '-';
            @endphp

            <div class="app-card d-flex align-items-center gap-3 p-3">

                {{-- Time --}}
                @php
                $start = \Carbon\Carbon::parse($schedule->start_time);
                $end = \Carbon\Carbon::parse($schedule->end_time);

                $durationMinutes = $start->diffInMinutes($end);
                @endphp

                <div class="d-flex flex-column align-items-center justify-content-center bg-sage-soft"
                    style="height:56px;width:56px;border-radius:18px">

                    <span class="fw-bold text-sage small">
                        {{ $durationMinutes }}
                    </span>

                    <span class="text-muted2 text-small">
                        min
                    </span>

                </div>

                {{-- Class Info --}}
                <div class="flex-fill" style="min-width:0">

                    <p class="mb-1 small fw-semibold text-truncate">
                        {{ $className }}
                    </p>
                    <div class="d-flex align-items-center gap-2 text-muted2 text-truncate text-small">

                        <span class="text-truncate">
                            <i class="bi bi-person"></i>
                            {{ $instructor }}
                        </span>

                        <span>•</span>

                        <span class="text-nowrap">
                            {{ $level }}
                        </span>

                    </div>

                </div>

                <div class="d-flex flex-column align-items-end gap-2 flex-shrink-0">
                @if ($remaining <= 0)
                    <span class="badge rounded-pill bg-danger-subtle text-danger-emphasis text-nowrap">
                    Full
                    </span>
                    @elseif ($remaining <= 3)
                        <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis text-nowrap">
                        {{ $remaining }} Slots
                        </span>
                        @else
                        <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis text-nowrap">
                            {{ $remaining }} Slots
                        </span>
                        @endif

                @php $myBooking = ($myBookings ?? collect())->get($schedule->uuid . '|' . ($todayDate ?? now()->format('Y-m-d'))); @endphp

                @if ($myBooking && $myBooking->status === 'attended')
                    <span class="badge rounded-pill bg-success-subtle text-success-emphasis">
                        Done
                    </span>
                @elseif ($myBooking && $myBooking->status === 'waiting_list')
                    <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis">
                        Waiting
                    </span>
                @elseif ($myBooking && $myBooking->status === 'confirmed')
                    <form action="{{ route('class-bookings.checkin', $myBooking->uuid) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-warm btn-sm text-nowrap">Check In</button>
                    </form>
                @elseif (!empty($activePackage))
                    <form action="{{ route('class-bookings.store') }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="class_schedule_uuid" value="{{ $schedule->uuid }}">
                        <input type="hidden" name="booking_date" value="{{ $todayDate ?? now()->format('Y-m-d') }}">
                        <button type="submit" class="btn btn-warm btn-sm text-nowrap">{{ $remaining <= 0 ? 'Waitlist' : 'Book' }}</button>
                    </form>
                @else
                    <a href="{{ route('packages.member') }}" class="btn btn-sm btn-outline-secondary text-nowrap">Join</a>
                @endif
                </div>

            </div>

            @empty

            <div class="app-card text-center p-4">
                <i class="bi bi-calendar2-week text-muted2 fs-3"></i>
                <p class="mb-1 small fw-semibold">
                    No Classes Today
                </p>

                <p class="mb-0 text-muted2 text-small">
                    There are no classes scheduled for today.
                </p>
            </div>

            @endforelse

        </div>


        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">Upcoming Classes</h3>
            <a href="{{ route('schedules.index', ['tab' => 'upcoming']) }}"
                class="btn btn-link p-0 text-terra fw-semibold text-decoration-none text-small">
                View all
            </a>
        </div>
        <div class="d-grid gap-3 mt-3" id="todayList">

            @forelse($upcomingClasses as $schedule)

            @php
            $class = $schedule->class;
            $instructor = $class?->instructor;

            $startTime = \Carbon\Carbon::parse($schedule->start_time);
            $endTime = \Carbon\Carbon::parse($schedule->end_time);
            @endphp

            <div class="app-card p-3">

                <div class="d-flex align-items-center gap-3">

                    <div class="avatar flex-shrink-0">
                        <img src="{{ $instructor?->avatar
        ? (Str::startsWith($instructor->avatar, 'http')
            ? $instructor->avatar
            : asset('storage/' . $instructor->avatar))
        : asset('dist/assets/images/avatar.jpg') }}"
                            alt="{{ $instructor?->name ?? 'Instructor' }}"
                            class="rounded-circle"
                            style="width:56px;height:56px;object-fit:cover;">
                    </div>

                    {{-- Class Info --}}
                    <div class="flex-fill" style="min-width:0">

                        <p class="mb-1 small fw-semibold text-truncate">
                            {{ $class?->name ?? 'Class unavailable' }}
                        </p>

                        <p class="mb-1 text-muted2 text-truncate text-small">
                            <i class="bi bi-person me-1"></i>
                            {{ $instructor?->name ?? 'No Instructor' }}

                            @if ($class?->level)
                            <span class="mx-1">•</span>
                            <i class="bi bi-bar-chart me-1"></i>
                            {{ ucfirst($class->level) }}
                            @endif
                        </p>

                        <p class="mb-0 text-muted2 text-truncate text-small">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ ucfirst($schedule->day) }}

                            <span class="mx-1">•</span>

                            <i class="bi bi-clock me-1"></i>
                            {{ $startTime->format('H:i') }}
                            -
                            {{ $endTime->format('H:i') }}
                        </p>

                    </div>
                    @php $upBooking = ($myBookings ?? collect())->get($schedule->uuid . '|' . ($tomorrowDate ?? now()->addDay()->format('Y-m-d'))); @endphp

                    @if ($upBooking && $upBooking->status === 'attended')
                        <span class="badge rounded-pill bg-success-subtle text-success-emphasis flex-shrink-0">
                            Done
                        </span>
                    @elseif ($upBooking && $upBooking->status === 'waiting_list')
                        <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis flex-shrink-0">
                            Waiting
                        </span>
                    @elseif ($upBooking && $upBooking->status === 'confirmed')
                        <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis flex-shrink-0">
                            Booked
                        </span>
                    @elseif (!empty($activePackage))
                        <form action="{{ route('class-bookings.store') }}" method="POST" class="m-0 flex-shrink-0">
                            @csrf
                            <input type="hidden" name="class_schedule_uuid" value="{{ $schedule->uuid }}">
                            <input type="hidden" name="booking_date" value="{{ $tomorrowDate ?? now()->addDay()->format('Y-m-d') }}">
                            <button type="submit" class="btn-pill flex-shrink-0">Join</button>
                        </form>
                    @else
                        <a href="{{ route('packages.member') }}" class="btn-pill flex-shrink-0 text-decoration-none text-center">Join</a>
                    @endif

                </div>

            </div>

            @empty

            <div class="app-card text-center p-4">
                <i class="bi bi-calendar2-week text-muted2 fs-3"></i>

                <p class="mb-1 mt-2 fw-semibold">
                    No Upcoming Classes
                </p>

                <p class="mb-0 text-muted2 small">
                    You don't have any upcoming classes yet.
                </p>
            </div>

            @endforelse

        </div>

        {{-- =========================
    Art Of Living
========================= --}}

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h3 class="h5 fw-semibold mb-0">
                Art of Living
            </h3>

            <span class="badge bg-sage-soft text-sage">
                {{ count($courses) }} Courses
            </span>
        </div>

        <div class="d-grid gap-2 mt-3">

            @forelse ($courses as $course)

            @php
            $title = $course['title'] ?? 'Art of Living Course';

            $startDate = !empty($course['start_date'])
            ? \Carbon\Carbon::parse($course['start_date'])
            : null;

            $city = $course['city'] ?? '-';

            $teachers = $course['teachers'] ?? [];

            $teacher = is_array($teachers) && count($teachers)
            ? implode(', ', $teachers)
            : null;

            $fee = (int) ($course['course_fee'] ?? 0);

            $registerUrl = $course['register_url'] ?? null;

            $isFull = ($course['is_event_capacity_full'] ?? '0') == '1';

            $isClosed = !empty($course['is_registration_closed']);

            $endDate = !empty($course['end_date'])
            ? \Carbon\Carbon::parse($course['end_date'])
            : null;

            $timing = $course['course_complex_timing']
            ?? $course['complex_timings']
            ?? $course['weekday_timings']
            ?? null;

            if ($timing) {
            $timing = strip_tags(str_ireplace(['<br>', '<br />', '<br/>'], ' · ', $timing));
            }
            @endphp


            <div class="app-card p-3">

                <div class="d-flex gap-3">

                    {{-- DATE --}}
                    <div
                        class="d-flex flex-column align-items-center justify-content-center bg-sage-soft flex-shrink-0"
                        style="
                        width:52px;
                        height:52px;
                        border-radius:15px;
                    ">
                        @if ($startDate)

                        <span
                            class="fw-bold text-sage"
                            style="font-size:17px; line-height:1;">
                            {{ $startDate->format('d') }}
                        </span>

                        <span
                            class="text-muted2 text-uppercase mt-1 m-tiny">
                            {{ $startDate->format('M') }}
                        </span>

                        @else

                        <span class="fw-bold text-muted2">
                            -
                        </span>

                        @endif
                    </div>


                    {{-- CONTENT --}}
                    <div class="flex-fill" style="min-width:0">

                        {{-- TITLE --}}
                        <div
                            class="fw-semibold small"
                            style="word-break:break-word">
                            {{ $title }}
                        </div>


                        {{-- LOCATION --}}
                        <div class="d-flex align-items-start gap-2 mt-1 m-meta text-muted2">
                            <i class="bi bi-geo-alt flex-shrink-0" style="width:14px"></i>
                            <span class="text-truncate">{{ $city }}</span>
                        </div>

                        {{-- TEACHER --}}
                        @if ($teacher)
                        <div class="d-flex align-items-start gap-2 mt-1 m-meta text-muted2">
                            <i class="bi bi-person flex-shrink-0" style="width:14px"></i>
                            <span class="text-truncate">{{ $teacher }}</span>
                        </div>
                        @endif

                        {{-- DATE --}}
                        <div class="d-flex align-items-start gap-2 mt-1 m-meta text-muted2">
                            <i class="bi bi-calendar3 flex-shrink-0" style="width:14px"></i>
                            <span>
                                @if ($startDate)
                                {{ $startDate->format('d M Y') }}
                                @if ($endDate && $startDate->format('Y-m-d') !== $endDate->format('Y-m-d'))
                                – {{ $endDate->format('d M Y') }}
                                @endif
                                @endif
                            </span>
                        </div>

                        @if ($timing)
                        <div class="d-flex align-items-start gap-2 mt-1 m-meta text-muted2">
                            <i class="bi bi-clock flex-shrink-0" style="width:14px"></i>
                            <span style="word-break:break-word">{{ $timing }}</span>
                        </div>
                        @endif

                        {{-- PRICE + REGISTER --}}
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-2" style="margin-left:22px">

                            @if ($isFull)

                            <span class="badge rounded-pill bg-danger-subtle text-danger-emphasis m-tiny">
                                Full
                            </span>

                            @elseif ($isClosed)

                            <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis m-tiny">
                                Closed
                            </span>

                            @elseif ($fee > 0)

                            <span class="fw-semibold text-small">
                                Rp {{ number_format($fee, 0, ',', '.') }}
                            </span>

                            @else

                            <span class="badge rounded-pill bg-success-subtle text-success-emphasis m-tiny">
                                Free
                            </span>

                            @endif

                            @if ($registerUrl && !$isFull && !$isClosed)

                            <a
                                href="{{ $registerUrl }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn btn-sm btn-success rounded-pill px-3 py-1 m-micro text-nowrap flex-shrink-0">
                                Register
                            </a>

                            @else

                            <span></span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

            @empty

            <div class="app-card text-center p-3">

                <i class="bi bi-calendar2-week text-muted2 fs-4"></i>

                <p class="mb-0 mt-1 small fw-semibold">
                    No Courses Available
                </p>

            </div>

            @endforelse

        </div>

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">Upcoming Events</h3>
        </div>

        <div class="d-flex gap-3 no-scrollbar mt-3 pb-1" id="eventList">

            @forelse($events as $event)

            <article class="app-card overflow-hidden flex-shrink-0"
                style="width:190px"
                data-bs-toggle="modal"
                data-bs-target="#eventModal{{ $event->uuid }}">

                <img src="{{ $event->gambar
                ? (Str::startsWith($event->gambar, 'http')
                    ? $event->gambar
                    : asset('storage/' . $event->gambar))
                : asset('dist/assets/images/event-placeholder.jpg') }}"
                    alt="{{ $event->judul }}"
                    loading="lazy"
                    style="height:120px;width:100%;object-fit:cover">

                <div class="p-3">

                    <span class="chip bg-terra-soft text-terra text-uppercase m-micro">
                        Event
                    </span>

                    <p class="mb-1 mt-2 small fw-semibold lh-sm text-truncate">
                        {{ $event->judul }}
                    </p>

                    <p class="mb-0 text-muted2 text-truncate m-meta">
                        <i class="bi bi-calendar3"></i>
                        {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}
                    </p>

                </div>

            </article>

            {{-- Event Modal --}}
            <div class="modal fade"
                id="eventModal{{ $event->uuid }}"
                tabindex="-1"
                aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4 overflow-hidden">

                        @if($event->gambar)
                        <img src="{{ Str::startsWith($event->gambar, 'http')
                            ? $event->gambar
                            : asset('storage/' . $event->gambar) }}"
                            alt="{{ $event->judul }}"
                            class="w-100"
                            style="height:200px;object-fit:cover">
                        @endif

                        <div class="modal-body p-4">

                            <span class="chip bg-terra-soft text-terra text-uppercase m-micro">
                                Event
                            </span>

                            <h5 class="fw-bold mt-2 mb-3">
                                {{ $event->judul }}
                            </h5>

                            @if($event->tanggal)
                            <p class="small text-muted2 mb-2">
                                <i class="bi bi-calendar3 me-2"></i>
                                {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}
                            </p>
                            @endif

                            @if($event->waktu_mulai)
                            <p class="small text-muted2 mb-2">
                                <i class="bi bi-clock me-2"></i>
                                {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}

                                @if($event->waktu_selesai)
                                - {{ \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') }}
                                @endif
                            </p>
                            @endif

                            @if($event->lokasi)
                            <p class="small text-muted2 mb-2">
                                <i class="bi bi-geo-alt me-2"></i>
                                {{ $event->lokasi }}
                            </p>
                            @endif

                            @if($event->kapasitas)
                            <p class="small text-muted2 mb-3">
                                <i class="bi bi-people me-2"></i>
                                Capacity: {{ $event->kapasitas }}
                            </p>
                            @endif

                            @if($event->excerpt)
                            <p class="small fw-semibold mb-2">
                                {{ $event->excerpt }}
                            </p>
                            @endif

                            @if($event->deskripsi)
                            <div class="small text-muted2 lh-lg event-description">
                                {!! $event->deskripsi !!}
                            </div>
                            @endif

                        </div>

                        <div class="modal-footer border-0 px-4 pb-4">
                            <button type="button"
                                class="btn btn-sage w-100"
                                data-bs-dismiss="modal">
                                Close
                            </button>
                        </div>

                    </div>
                </div>

            </div>

            @empty
            <div class="app-card text-center p-4">
                <i class="bi bi-calendar2-week text-muted2 fs-3"></i>

                <p class="mb-1 mt-2 fw-semibold">
                    No Upcoming Events
                </p>
                <p class="mb-0 text-muted2 small">
                    There are no upcoming events available at the moment.
                </p>
            </div>

            @endforelse

        </div>

        <div class="app-card p-4 mt-4 mb-2">

            <p class="eyebrow mb-1">Need Help?</p>
            <h3 class="h5 fw-semibold mb-2">
                We're here to help
            </h3>

            <p class="small text-muted2 mb-3">
                Have questions? Chat with us directly on WhatsApp.
            </p>

            <a href="https://api.whatsapp.com/send/?phone=6281321221270&text=Hi%2C%20I%20found%20you%20through%20your%20website%20and%20would%20like%20more%20information%20about%20your%20classes.%20Thank%20you%21&app_absent=0"
                target="_blank"
                class="btn btn-sage w-100 py-2">
                <i class="bi bi-whatsapp me-2"></i>
                Chat on WhatsApp
            </a>

        </div>
    </div>
</section>

@if (blank(Auth::user()->no_hp))

<div
    class="modal fade"
    id="completeProfileModal"
    tabindex="-1"
    aria-labelledby="completeProfileModalLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered px-3">
        <div class="modal-content border-0 rounded-4 overflow-hidden">

            <form
                action="{{ route('dashboard.submitSumber') }}"
                method="POST">
                @csrf

                {{-- Header --}}
                <div class="modal-header border-0 px-4 pt-4 pb-2">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div
                                class="d-flex align-items-center justify-content-center rounded-circle bg-sage-soft"
                                style="width:40px;height:40px;">
                                <i class="bi bi-person-check text-sage"></i>
                            </div>

                            <span class="small fw-semibold text-sage">
                                Almost There
                            </span>
                        </div>

                        <h5
                            class="modal-title fw-semibold mb-1"
                            id="completeProfileModalLabel">
                            Complete Your Profile
                        </h5>

                        <p class="small text-muted2 mb-0">
                            Just a few details before you continue.
                        </p>
                    </div>
                </div>

                {{-- Body --}}
                <div class="modal-body px-4 pt-3">

                    {{-- WhatsApp --}}
                    <div class="mb-3">
                        <label
                            for="mobile_no_hp"
                            class="form-label small fw-semibold">
                            WhatsApp Number
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-whatsapp text-sage"></i>
                            </span>

                            <input
                                type="text"
                                name="no_hp"
                                id="mobile_no_hp"
                                class="form-control @error('no_hp') is-invalid @enderror"
                                placeholder="08xxxxxxxxxx"
                                value="{{ old('no_hp') }}"
                                inputmode="tel"
                                required>
                        </div>

                        @error('no_hp')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Source --}}
                    <div class="mb-2">
                        <label
                            for="mobile_sumber_informasi"
                            class="form-label small fw-semibold">
                            How did you hear about us?
                        </label>

                        <select
                            name="sumber_informasi"
                            id="mobile_sumber_informasi"
                            class="form-select @error('sumber_informasi') is-invalid @enderror"
                            required>

                            <option value="">
                                Select an option
                            </option>

                            <option
                                value="google"
                                @selected(old('sumber_informasi')==='google' )>
                                Google Search
                            </option>

                            <option
                                value="sosmed"
                                @selected(old('sumber_informasi')==='sosmed' )>
                                Social Media
                            </option>

                            <option
                                value="friend"
                                @selected(old('sumber_informasi')==='friend' )>
                                Friend / Family
                            </option>

                            <option
                                value="community"
                                @selected(old('sumber_informasi')==='community' )>
                                Yoga Community
                            </option>

                            <option
                                value="event"
                                @selected(old('sumber_informasi')==='event' )>
                                Yoga Event / Workshop
                            </option>

                            <option
                                value="website"
                                @selected(old('sumber_informasi')==='website' )>
                                Website
                            </option>

                            <option
                                value="other"
                                @selected(old('sumber_informasi')==='other' )>
                                Other
                            </option>

                        </select>

                        @error('sumber_informasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer border-0 px-4 pt-2 pb-4">
                    <button
                        type="submit"
                        class="btn btn-warm w-100 py-2">
                        <i class="bi bi-check2 me-1"></i>
                        Save & Continue
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('completeProfileModal');

        if (!modalElement || typeof bootstrap === 'undefined') {
            return;
        }

        const modal = bootstrap.Modal.getOrCreateInstance(
            modalElement, {
                backdrop: 'static',
                keyboard: false
            }
        );

        modal.show();
    });
</script>

@endif

@endsection