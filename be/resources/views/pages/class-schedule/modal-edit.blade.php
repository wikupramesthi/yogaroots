<div
    id="modal-form-edit-class-schedule-{{ $schedule->uuid }}"
    class="modal fade"
    tabindex="-1"
    aria-labelledby="modal-form-edit-class-schedule-{{ $schedule->uuid }}-label"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                action="{{ route('class-schedules.update', $schedule->uuid) }}"
                method="POST">

                @csrf
                @method('PUT')


                {{-- Header --}}
                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="modal-form-edit-class-schedule-{{ $schedule->uuid }}-label">

                        Edit Class Schedule

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>


                {{-- Body --}}
                <div class="modal-body">

                    {{-- Class --}}
                    <div class="mb-3">

                        <label
                            for="edit-class-{{ $schedule->uuid }}"
                            class="form-label">

                            Class
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="class_uuid"
                            id="edit-class-{{ $schedule->uuid }}"
                            class="form-select @error('class_uuid') is-invalid @enderror"
                            required>

                            <option value="">
                                Select Class
                            </option>

                            @foreach ($classes as $class)

                            <option
                                value="{{ $class->uuid }}"
                                {{ old('class_uuid', $schedule->class_uuid) == $class->uuid ? 'selected' : '' }}>

                                {{ $class->name }}

                            </option>

                            @endforeach

                        </select>

                        @error('class_uuid')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Day --}}
                    <div class="mb-3">

                        <label
                            for="edit-day-{{ $schedule->uuid }}"
                            class="form-label">

                            Day
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="day"
                            id="edit-day-{{ $schedule->uuid }}"
                            class="form-select @error('day') is-invalid @enderror"
                            required>

                            <option value="">
                                Select Day
                            </option>

                            @foreach ([
                            'monday' => 'Monday',
                            'tuesday' => 'Tuesday',
                            'wednesday' => 'Wednesday',
                            'thursday' => 'Thursday',
                            'friday' => 'Friday',
                            'saturday' => 'Saturday',
                            'sunday' => 'Sunday'
                            ] as $value => $label)

                            <option
                                value="{{ $value }}"
                                {{ old('day', $schedule->day) == $value ? 'selected' : '' }}>

                                {{ $label }}

                            </option>

                            @endforeach

                        </select>

                        @error('day')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Time --}}
                    <div class="row">

                        {{-- Start --}}
                        <div class="col-md-6 mb-3">

                            <label
                                for="edit-start-time-{{ $schedule->uuid }}"
                                class="form-label">

                                Start Time
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="time"
                                name="start_time"
                                id="edit-start-time-{{ $schedule->uuid }}"
                                class="form-control @error('start_time') is-invalid @enderror"
                                value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}"
                                required>

                            @error('start_time')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>


                        {{-- End --}}
                        <div class="col-md-6 mb-3">

                            <label
                                for="edit-end-time-{{ $schedule->uuid }}"
                                class="form-label">

                                End Time
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="time"
                                name="end_time"
                                id="edit-end-time-{{ $schedule->uuid }}"
                                class="form-control @error('end_time') is-invalid @enderror"
                                value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}"
                                required>

                            @error('end_time')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Capacity --}}
                    <div class="mb-3">

                        <label
                            for="edit-capacity-{{ $schedule->uuid }}"
                            class="form-label">

                            Capacity
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="number"
                            name="capacity"
                            id="edit-capacity-{{ $schedule->uuid }}"
                            class="form-control @error('capacity') is-invalid @enderror"
                            placeholder="Enter class capacity"
                            value="{{ old('capacity', $schedule->capacity) }}"
                            min="1"
                            required>

                        @error('capacity')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Status --}}
                    <div class="mb-3">

                        <label
                            for="edit-status-{{ $schedule->uuid }}"
                            class="form-label">

                            Status
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="status"
                            id="edit-status-{{ $schedule->uuid }}"
                            class="form-select @error('status') is-invalid @enderror"
                            required>

                            <option
                                value="active"
                                {{ old('status', $schedule->status) == 'active' ? 'selected' : '' }}>

                                Active

                            </option>

                            <option
                                value="inactive"
                                {{ old('status', $schedule->status) == 'inactive' ? 'selected' : '' }}>

                                Inactive

                            </option>

                        </select>

                        @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>


                {{-- Footer --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-check-lg me-1"></i>

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>