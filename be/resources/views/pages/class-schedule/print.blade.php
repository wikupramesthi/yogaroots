<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Class Schedule</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 20px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            color: #444;
        }

        .header {
            width: 100%;
            margin-bottom: 12px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .legend {
            font-size: 11px;
        }

        .legend-item {
            display: inline-block;
            margin-right: 20px;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            display: inline-block;
            border-radius: 50%;
            margin-right: 4px;
        }

        .foundation {
            background: #e5dfd1;
        }

        .intermediate {
            background: #a99c8c;
        }

        .advance {
            background: #bd5937;
        }

        .schedule-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 3px;
            table-layout: fixed;
        }

        .day-header {
            background: #566052;
            color: #ffffff;
            text-align: center;
            padding: 10px 4px;
            font-size: 11px;
            font-weight: bold;
            border-radius: 8px;
        }

        .day-column {
            vertical-align: top;
            width: 14.28%;
        }

        .schedule-card {
            border-radius: 8px;
            padding: 8px 4px;
            margin-bottom: 4px;
            text-align: center;
            min-height: 75px;
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

        .time {
            font-size: 10px;
            font-weight: bold;
        }

        .class-name {
            font-size: 10px;
            font-weight: bold;
            margin-top: 3px;
        }

        .duration {
            font-size: 9px;
        }

        .instructor {
            font-size: 9px;
            margin-top: 2px;
        }

        .empty {
            text-align: center;
            color: #aaa;
            font-size: 9px;
            padding: 15px 2px;
        }

        .footer {
            margin-top: 10px;
            font-size: 9px;
            color: #888;
            text-align: right;
        }
    </style>

</head>

<body>

    <div class="header">

        <div class="title">
            Yogaroots Class Schedule
        </div>

        <div class="legend">

            <span class="legend-item">
                <span class="legend-dot foundation"></span>
                Foundation
            </span>

            <span class="legend-item">
                <span class="legend-dot intermediate"></span>
                Intermediate
            </span>

            <span class="legend-item">
                <span class="legend-dot advance"></span>
                Advance
            </span>

        </div>

    </div>

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

    <table class="schedule-table">

        <thead>
            <tr>

                @foreach ($days as $dayName)
                <th class="day-header">
                    {{ $dayName }}
                </th>
                @endforeach

            </tr>
        </thead>

        <tbody>

            <tr>

                @foreach ($days as $day => $dayName)

                <td class="day-column">

                    @php
                    $daySchedules = $schedules
                    ->where('day', $day)
                    ->sortBy('start_time');
                    @endphp

                    @forelse ($daySchedules as $schedule)

                    @php
                    $level = $schedule->class->level ?? 'foundation';

                    $start = \Carbon\Carbon::parse(
                    $schedule->start_time
                    );

                    $end = $schedule->end_time
                    ? \Carbon\Carbon::parse($schedule->end_time)
                    : null;

                    $duration = $end
                    ? $start->diffInMinutes($end)
                    : null;
                    @endphp

                    <div class="schedule-card {{ $level }}">

                        <div class="time">
                            {{ $start->format('H.i') }}

                            @if ($end)
                            - {{ $end->format('H.i') }}
                            @endif
                        </div>

                        <div class="class-name">
                            {{ $schedule->class->name }}
                        </div>

                        @if ($duration)
                        <div class="duration">
                            ({{ $duration }} min)
                        </div>
                        @endif

                        <div class="instructor">
                            {{ $schedule->class->instructor->name ?? '-' }}
                        </div>

                    </div>

                    @empty

                    <div class="empty">
                        -
                    </div>

                    @endforelse

                </td>

                @endforeach

            </tr>

        </tbody>

    </table>

    <div class="footer">
        Yogaroots — Weekly Class Schedule
    </div>

</body>

</html>