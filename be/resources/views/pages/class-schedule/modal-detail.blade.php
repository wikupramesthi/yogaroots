@foreach ($schedules as $schedule)

<div
    class="modal fade"
    id="modal-schedule-{{ $schedule->uuid }}"
    tabindex="-1"
    aria-labelledby="modal-schedule-label-{{ $schedule->uuid }}"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg overflow-hidden"
            style="border-radius: 24px;">

            {{-- =========================
                HERO
            ========================== --}}
            <div class="position-relative">

                @if ($schedule->class->image)

                <img
                    src="{{ asset('storage/' . $schedule->class->image) }}"
                    alt="{{ $schedule->class->name }}"
                    class="w-100"
                    style="
                            height: 300px;
                            object-fit: cover;
                        ">

                @else

                <div
                    class="w-100 d-flex align-items-center justify-content-center bg-light"
                    style="height: 300px;">

                    <div class="text-center text-muted">
                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                        <span>No Image Available</span>
                    </div>

                </div>

                @endif


                {{-- Gradient --}}
                <div
                    class="position-absolute bottom-0 start-0 w-100"
                    style="
                        height: 55%;
                        background: linear-gradient(
                            to top,
                            rgba(0,0,0,.75),
                            rgba(0,0,0,0)
                        );
                    ">
                </div>


                {{-- Close --}}
                <button
                    type="button"
                    class="btn btn-light position-absolute top-0 end-0 m-3 rounded-circle shadow-sm"
                    data-bs-dismiss="modal"
                    style="
                        width: 40px;
                        height: 40px;
                        padding: 0;
                    ">

                    <i class="bi bi-x-lg"></i>

                </button>


                {{-- Hero Content --}}
                <div
                    class="position-absolute bottom-0 start-0 w-100 p-4 text-white">

                    @if ($schedule->class->category)

                    <span
                        class="badge rounded-pill px-3 py-2 mb-2"
                        style="
                                background: rgba(255,255,255,.18);
                                backdrop-filter: blur(8px);
                            ">

                        {{ $schedule->class->category->name }}

                    </span>

                    @endif


                    <h2
                        class="fw-bold mb-1"
                        id="modal-schedule-label-{{ $schedule->uuid }}">

                        {{ $schedule->class->name ?? '-' }}

                    </h2>


                    <div class="d-flex align-items-center gap-2 opacity-75">

                        <i class="bi bi-calendar3"></i>

                        <span>
                            {{ ucfirst($schedule->day) }}
                        </span>

                        <span>•</span>

                        <i class="bi bi-clock"></i>

                        <span>
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                        </span>

                    </div>

                </div>

            </div>


            {{-- =========================
                BODY
            ========================== --}}
            <div class="modal-body p-4 p-md-5">


                {{-- Description --}}
                @if ($schedule->class->description)

                <div class="mb-4">

                    <p
                        class="text-muted mb-0"
                        style="line-height: 1.7;">

                        {{ $schedule->class->description }}

                    </p>

                </div>

                @endif


                {{-- =========================
                    SCHEDULE HIGHLIGHT
                ========================== --}}
                <div
                    class="p-3 p-md-4 mb-4 rounded-4"
                    style="
                        background: #f8f9fa;
                        border: 1px solid #eee;
                    ">

                    <div class="d-flex align-items-center justify-content-between">

                        <div class="d-flex align-items-center gap-3">

                            <div
                                class="rounded-3 d-flex align-items-center justify-content-center bg-white shadow-sm"
                                style="
                                    width: 48px;
                                    height: 48px;
                                ">

                                <i class="bi bi-calendar3 fs-5"></i>

                            </div>

                            <div>

                                <div class="small text-muted">
                                    Class Schedule
                                </div>

                                <div class="fw-semibold">
                                    {{ ucfirst($schedule->day) }}
                                </div>

                            </div>

                        </div>


                        <div class="text-end">

                            <div class="small text-muted">
                                Time
                            </div>

                            <div class="fw-semibold">

                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}

                                <span class="text-muted mx-1">
                                    —
                                </span>

                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =========================
                    INSTRUCTOR
                ========================== --}}
                <div class="mb-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h6 class="fw-semibold mb-0">
                            Instructor
                        </h6>

                    </div>


                    @if ($schedule->class->instructor)

                    <div
                        class="d-flex align-items-center p-3 rounded-4"
                        style="
                                background: #fafafa;
                                border: 1px solid #eee;
                            ">


                        {{-- Avatar --}}
                        @if ($schedule->class->instructor->avatar)

                        <img
                            src="{{ asset('storage/' . $schedule->class->instructor->avatar) }}"
                            alt="{{ $schedule->class->instructor->name }}"
                            class="rounded-circle me-3"
                            style="
                                        width: 58px;
                                        height: 58px;
                                        object-fit: cover;
                                    ">

                        @else

                        <div
                            class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center me-3"
                            style="
                                        width: 58px;
                                        height: 58px;
                                    ">

                            <i class="bi bi-person fs-4 text-muted"></i>

                        </div>

                        @endif


                        {{-- Info --}}
                        <div class="flex-grow-1">

                            <div class="fw-semibold">
                                {{ $schedule->class->instructor->name }}
                            </div>


                            @if (
                            $schedule->class->instructor->specializations &&
                            $schedule->class->instructor->specializations->count()
                            )

                            <div class="small text-muted mt-1">

                                {{ $schedule->class->instructor->specializations
                                            ->pluck('name')
                                            ->join(' · ') }}

                            </div>

                            @else

                            <div class="small text-muted mt-1">
                                Yoga Instructor
                            </div>

                            @endif

                        </div>


                        <i class="bi bi-chevron-right text-muted"></i>

                    </div>

                    @else

                    <div
                        class="p-3 rounded-4 bg-light text-muted">

                        <i class="bi bi-person-x me-2"></i>
                        No instructor assigned

                    </div>

                    @endif

                </div>


                {{-- =========================
                    STATS
                ========================== --}}
                <div class="row g-3">

                    {{-- Capacity --}}
                    <div class="col-md-4">

                        <div
                            class="h-100 p-3 rounded-4"
                            style="
                                background: #fafafa;
                                border: 1px solid #eee;
                            ">

                            <div class="text-muted small mb-2">
                                Capacity
                            </div>

                            <div class="d-flex align-items-center gap-2">

                                <i class="bi bi-people fs-5"></i>

                                <span class="fw-semibold fs-5">
                                    {{ $schedule->capacity }}
                                </span>

                                <span class="small text-muted">
                                    people
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Duration --}}
                    <div class="col-md-4">

                        @php

                        $start = \Carbon\Carbon::parse($schedule->start_time);
                        $end = \Carbon\Carbon::parse($schedule->end_time);

                        $duration = $start->diffInMinutes($end);

                        @endphp

                        <div
                            class="h-100 p-3 rounded-4"
                            style="
                                background: #fafafa;
                                border: 1px solid #eee;
                            ">

                            <div class="text-muted small mb-2">
                                Duration
                            </div>

                            <div class="d-flex align-items-center gap-2">

                                <i class="bi bi-hourglass-split fs-5"></i>

                                <span class="fw-semibold fs-5">

                                    @if ($duration >= 60)

                                    {{ floor($duration / 60) }}h

                                    @if ($duration % 60 > 0)
                                    {{ $duration % 60 }}m
                                    @endif

                                    @else

                                    {{ $duration }} min

                                    @endif

                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-4">

                        <div
                            class="h-100 p-3 rounded-4"
                            style="
                                background: #fafafa;
                                border: 1px solid #eee;
                            ">

                            <div class="text-muted small mb-2">
                                Status
                            </div>


                            @if ($schedule->status === 'active')

                            <span
                                class="badge rounded-pill px-3 py-2"
                                style="
                                        background: #eaf7ef;
                                        color: #198754;
                                    ">

                                <span class="me-1">●</span>
                                Active

                            </span>

                            @else

                            <span
                                class="badge rounded-pill px-3 py-2"
                                style="
                                        background: #f1f1f1;
                                        color: #6c757d;
                                    ">

                                <span class="me-1">●</span>
                                Inactive

                            </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================
                FOOTER
            ========================== --}}
            <div
                class="modal-footer border-0 px-4 px-md-5 pb-4 pt-0">


                {{-- Delete --}}
                <form
                    action="{{ route('class-schedules.destroy', $schedule->uuid) }}"
                    method="POST"
                    class="me-auto"
                    onsubmit="return confirm('Are you sure you want to delete this schedule?')">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-link text-danger text-decoration-none px-0">

                        <i class="bi bi-trash me-1"></i>
                        Delete

                    </button>

                </form>


                {{-- Close --}}
                <button
                    type="button"
                    class="btn btn-light rounded-3 px-4"
                    data-bs-dismiss="modal">

                    Close

                </button>


                {{-- Edit --}}
                <a
                    href="{{ route('class-schedules.edit', $schedule->uuid) }}"
                    class="btn btn-dark rounded-3 px-4">

                    <i class="bi bi-pencil me-1"></i>
                    Edit Schedule

                </a>

            </div>

        </div>
    </div>
</div>

@endforeach