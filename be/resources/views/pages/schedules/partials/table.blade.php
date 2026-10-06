{{-- Baris jadwal member desktop. Variabel: $schedules, $bookingDate.
    Mengandalkan dari parent: $myBookings, $activePackage. --}}
<div class="table-responsive">
    <table class="table security-table">
        <thead>
            <tr>
                <th>Time</th>
                <th>Class</th>
                <th>Instructor</th>
                <th>Studio</th>
                <th class="text-center">Slots</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schedules as $schedule)
                @php
                    $booked = $schedule->bookings_count ?? 0;
                    $remaining = max(0, ($schedule->capacity ?? 0) - $booked);
                    $myBooking = ($myBookings ?? collect())->get($schedule->uuid . '|' . $bookingDate);
                    $isToday = $bookingDate === now()->format('Y-m-d');
                @endphp
                <tr>
                    <td class="fw-semibold text-nowrap">
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                    </td>
                    <td>
                        <span class="d-block fw-semibold">{{ $schedule->class?->name ?? '-' }}</span>
                        @if ($schedule->class?->level)
                            <small class="log-muted">{{ ucfirst($schedule->class->level) }}</small>
                        @endif
                    </td>
                    <td>{{ $schedule->class?->instructor?->name ?? '-' }}</td>
                    <td>{{ $schedule->studio?->name ?? '-' }}</td>
                    <td class="text-center">
                        @if ($remaining <= 0 && empty($myBooking))
                            <span class="badge bg-danger-subtle text-danger">Full</span>
                        @elseif ($remaining <= 3)
                            <span class="badge bg-warning-subtle text-warning">{{ $remaining }} left</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">{{ $remaining }} left</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if ($myBooking && $myBooking->status === 'attended')
                            <span class="badge bg-success-subtle text-success">Done</span>
                        @elseif ($myBooking && $myBooking->status === 'waiting_list')
                            <span class="badge bg-warning-subtle text-warning">Waiting</span>
                        @elseif ($myBooking && $myBooking->status === 'confirmed')
                            @if ($isToday)
                                <form action="{{ route('class-bookings.checkin', $myBooking->uuid) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Check In</button>
                                </form>
                            @else
                                <span class="badge bg-primary-subtle text-primary">Booked</span>
                            @endif
                        @elseif (!empty($activePackage))
                            <form action="{{ route('class-bookings.store') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="class_schedule_uuid" value="{{ $schedule->uuid }}">
                                <input type="hidden" name="booking_date" value="{{ $bookingDate }}">
                                @if ($isToday)
                                    <input type="hidden" name="checkin" value="1">
                                    <button type="submit" class="btn btn-sm btn-primary">{{ $remaining <= 0 ? 'Waitlist' : 'Book & In' }}</button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-primary">{{ $remaining <= 0 ? 'Waitlist' : 'Book' }}</button>
                                @endif
                            </form>
                        @else
                            <a href="{{ route('packages.member') }}" class="btn btn-sm btn-outline-secondary">View Plans</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No classes scheduled.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
