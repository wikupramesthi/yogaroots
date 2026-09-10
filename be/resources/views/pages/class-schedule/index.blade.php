@extends('layouts.app')
@section('title', 'Schedule')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Schedule" page="Class" active="Schedule" route="{{ route('class-schedules.index') }}" />
@endsection

@section('content')

    <style>
        .schedule-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(150px, 1fr));
            gap: 4px;
            min-width: 1100px;
        }

        .schedule-column {
            min-height: 500px;
            background: #f8f8f8;
            border-radius: 10px;
            overflow: hidden;
        }

        .schedule-day {
            background: #566052;
            color: #fff;
            text-align: center;
            padding: 14px 8px;
            font-weight: 600;
            font-size: 14px;
            border-radius: 10px;
            margin-bottom: 5px;
        }

        .schedule-items {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .schedule-card {
            padding: 12px 8px;
            min-height: 105px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: .2s ease;
            border: 1px solid transparent;
        }

        .schedule-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        }

        .schedule-card.foundation {
            background: #e5dfd1;
            color: #444;
        }

        .schedule-card.intermediate {
            background: #a99c8c;
            color: #fff;
        }

        .schedule-card.advance {
            background: #bd5937;
            color: #fff;
        }

        .schedule-time {
            font-weight: 700;
            font-size: 13px;
        }

        .schedule-class {
            font-size: 13px;
            font-weight: 500;
            margin-top: 3px;
        }

        .schedule-duration {
            font-size: 12px;
            opacity: .85;
        }

        .schedule-instructor {
            font-size: 12px;
            margin-top: 2px;
        }

        .schedule-empty {
            text-align: center;
            color: #aaa;
            font-size: 12px;
            padding: 20px 5px;
        }

        .schedule-legend {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: inline-block;
        }

        .schedule-legend.foundation {
            background: #e5dfd1;
        }

        .schedule-legend.intermediate {
            background: #a99c8c;
        }

        .schedule-legend.advance {
            background: #bd5937;
        }
    </style>


    <section class="section">

        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="card-title mb-1">Class Schedule</h5>
                        <p class="text-muted mb-0">
                            Weekly class schedule
                        </p>
                    </div>

                    @can('class-schedules.store')
                        <div class="d-flex gap-2">
                            <!-- <a
                                href="{{ route('class-schedules.print') }}"
                                target="_blank"
                                class="btn btn-success">
                                Full Schedule
                            </a> -->

                            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                                data-bs-target="#modal-form-add-class-schedule">
                                <i class="bi bi-plus-lg"></i>
                                Add Schedule
                            </button>
                        </div>
                    @endcan

                </div>

                {{-- Level Legend --}}
                <div class="d-flex gap-4 mb-4 flex-wrap">

                    <div class="d-flex align-items-center gap-2">
                        <span class="schedule-legend foundation"></span>
                        <span>Foundation</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="schedule-legend intermediate"></span>
                        <span>Intermediate</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="schedule-legend advance"></span>
                        <span>Advance</span>
                    </div>

                </div>

                {{-- Schedule --}}
                <div class="schedule-wrapper">

                    @php
                        $days = [
                            'monday' => 'MONDAY',
                            'tuesday' => 'TUESDAY',
                            'wednesday' => 'WEDNESDAY',
                            'thursday' => 'THURSDAY',
                            'friday' => 'FRIDAY',
                            'saturday' => 'SATURDAY',
                            'sunday' => 'SUNDAY',
                        ];
                    @endphp

                    <div class="schedule-grid">

                        @foreach ($days as $day => $dayName)
                            <div class="schedule-column">

                                <div class="schedule-day">
                                    {{ $dayName }}
                                </div>

                                <div class="schedule-items">

                                    @php
                                        $daySchedules = $schedules->where('day', $day)->sortBy('start_time');
                                    @endphp

                                    @forelse ($daySchedules as $schedule)
                                        @php
                                            $level = $schedule->class->level ?? 'foundation';
                                        @endphp

                                        <div class="schedule-card {{ $level }}" data-bs-toggle="modal"
                                            data-bs-target="#modal-schedule-{{ $schedule->uuid }}">

                                            {{-- Time --}}
                                            <div class="schedule-time">
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H.i') }}

                                                @if ($schedule->end_time)
                                                    -
                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H.i') }}
                                                @endif
                                            </div>

                                            {{-- Class --}}
                                            <div class="schedule-class">
                                                {{ $schedule->class->name }}
                                            </div>

                                            {{-- Duration --}}
                                            <div class="schedule-duration">
                                                @if ($schedule->end_time)
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->diffInMinutes(\Carbon\Carbon::parse($schedule->end_time)) }}
                                                    min
                                                @endif
                                            </div>

                                            {{-- Instructor --}}
                                            <div class="schedule-instructor">
                                                {{ $schedule->class->instructor->name ?? '-' }}
                                            </div>

                                            {{-- Studio --}}
                                            <div class="schedule-studio">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $schedule->studio->name ?? '-' }}
                                            </div>

                                        </div>

                                    @empty

                                        <div class="schedule-empty">
                                            No class
                                        </div>
                                    @endforelse

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>
        </div>

    </section>

    @include('pages.class-schedule.modal-create')
    @include('pages.class-schedule.modal-detail')

@endsection
