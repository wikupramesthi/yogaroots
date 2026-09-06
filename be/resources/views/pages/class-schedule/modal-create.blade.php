<!-- Add Class Schedule Modal -->
<div id="modal-form-add-class-schedule"
    class="modal fade"
    tabindex="-1"
    aria-labelledby="modal-form-add-class-schedule-label"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('class-schedules.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-add-class-schedule-label">
                        Add Class Schedule
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">

                    <!-- Class -->
                    <div class="mb-3">
                        <label for="class_uuid" class="form-label">
                            Class <span class="text-danger">*</span>
                        </label>

                        <select
                            name="class_uuid"
                            id="class_uuid"
                            class="form-select @error('class_uuid') is-invalid @enderror"
                            required>
                            <option value="">Select Class</option>

                            @foreach ($classes as $class)
                            <option value="{{ $class->uuid }}"
                                {{ old('class_uuid') == $class->uuid ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                            @endforeach
                        </select>

                        @error('class_uuid')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Day -->
                    <div class="mb-3">
                        <label for="day" class="form-label">
                            Day <span class="text-danger">*</span>
                        </label>

                        <select
                            name="day"
                            id="day"
                            class="form-select @error('day') is-invalid @enderror"
                            required>
                            <option value="">Select Day</option>
                            <option value="monday" {{ old('day') == 'monday' ? 'selected' : '' }}>Monday</option>
                            <option value="tuesday" {{ old('day') == 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="wednesday" {{ old('day') == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="thursday" {{ old('day') == 'thursday' ? 'selected' : '' }}>Thursday</option>
                            <option value="friday" {{ old('day') == 'friday' ? 'selected' : '' }}>Friday</option>
                            <option value="saturday" {{ old('day') == 'saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="sunday" {{ old('day') == 'sunday' ? 'selected' : '' }}>Sunday</option>
                        </select>

                        @error('day')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Time -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">
                                Start Time <span class="text-danger">*</span>
                            </label>

                            <input
                                type="time"
                                name="start_time"
                                id="start_time"
                                class="form-control @error('start_time') is-invalid @enderror"
                                value="{{ old('start_time') }}"
                                required>

                            @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">
                                End Time <span class="text-danger">*</span>
                            </label>

                            <input
                                type="time"
                                name="end_time"
                                id="end_time"
                                class="form-control @error('end_time') is-invalid @enderror"
                                value="{{ old('end_time') }}"
                                required>

                            @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Capacity -->
                    <div class="mb-3">
                        <label for="capacity" class="form-label">
                            Capacity <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            name="capacity"
                            id="capacity"
                            class="form-control @error('capacity') is-invalid @enderror"
                            placeholder="Enter class capacity"
                            value="{{ old('capacity') }}"
                            min="1"
                            required>

                        @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required>
                            <option value="active"
                                {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive"
                                {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>

                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                        class="btn btn-primary">
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>