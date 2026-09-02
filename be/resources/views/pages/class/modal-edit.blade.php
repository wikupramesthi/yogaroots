{{-- Modal Edit Class --}}

<div
    id="modal-form-edit-class-{{ $class->uuid }}"
    class="modal fade modal-form-class-edit"
    tabindex="-1"
    aria-labelledby="modal-form-edit-class-{{ $class->uuid }}-label"
    aria-hidden="true"
    style="display: none;">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <form
                action="{{ route('classes.update', $class->uuid) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')


                {{-- =========================
                    HEADER
                ========================== --}}
                <div class="modal-header">

                    <div>
                        <h5
                            class="modal-title mb-1"
                            id="modal-form-edit-class-{{ $class->uuid }}-label">

                            Edit Class

                        </h5>

                        <small class="text-muted">
                            {{ $class->name }}
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>

                </div>


                {{-- =========================
                    BODY
                ========================== --}}
                <div class="modal-body">


                    {{-- Nama Class --}}
                    <div class="form-group mb-3">

                        <label
                            for="name_{{ $class->uuid }}"
                            class="mb-2">

                            Nama Class
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name_{{ $class->uuid }}"
                            name="name"
                            placeholder="Contoh: Hatha Yoga"
                            value="{{ old('name', $class->name) }}"
                            required>

                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Image --}}
                    <div class="form-group mb-3">

                        <label
                            for="image_{{ $class->uuid }}"
                            class="mb-2">

                            Gambar Class

                        </label>

                        @if($class->image)

                        <div class="mb-2">

                            <img
                                src="{{ asset('storage/' . $class->image) }}"
                                alt="{{ $class->name }}"
                                class="rounded"
                                style="width: 120px; height: 80px; object-fit: cover;">

                        </div>

                        @endif

                        <input
                            type="file"
                            class="form-control @error('image') is-invalid @enderror"
                            id="image_{{ $class->uuid }}"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp">

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti gambar.
                        </small>

                        @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Level --}}
                    <div class="form-group mb-3">

                        <label
                            for="level_{{ $class->uuid }}"
                            class="mb-2">

                            Level
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="level"
                            id="level_{{ $class->uuid }}"
                            class="form-control @error('level') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Pilih Level --
                            </option>

                            <option
                                value="pemula"
                                {{ old('level', $class->level) == 'pemula' ? 'selected' : '' }}>
                                Pemula
                            </option>

                            <option
                                value="menengah"
                                {{ old('level', $class->level) == 'menengah' ? 'selected' : '' }}>
                                Menengah
                            </option>

                            <option
                                value="advance"
                                {{ old('level', $class->level) == 'advance' ? 'selected' : '' }}>
                                Advance
                            </option>

                            <option
                                value="semua_level"
                                {{ old('level', $class->level) == 'semua_level' ? 'selected' : '' }}>
                                Semua Level
                            </option>

                        </select>

                        @error('level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Durasi --}}
                    <div class="form-group mb-3">

                        <label
                            for="duration_{{ $class->uuid }}"
                            class="mb-2">

                            Durasi
                            <span class="text-danger">*</span>

                        </label>

                        <div class="input-group">

                            <input
                                type="number"
                                class="form-control @error('duration') is-invalid @enderror"
                                id="duration_{{ $class->uuid }}"
                                name="duration"
                                placeholder="Contoh: 60"
                                value="{{ old('duration', $class->duration) }}"
                                min="1"
                                required>

                            <span class="input-group-text">
                                Menit
                            </span>

                        </div>

                        @error('duration')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- =========================
                        INSTRUCTOR
                    ========================== --}}

                    @if(
                    auth()->user()->hasRole('admin') ||
                    auth()->user()->hasRole('superadmin')
                    )

                    <div class="form-group mb-3">

                        <label
                            for="instructor_uuid_{{ $class->uuid }}"
                            class="mb-2">

                            Instructor
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="instructor_uuid"
                            id="instructor_uuid_{{ $class->uuid }}"
                            class="form-control @error('instructor_uuid') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Pilih Instructor --
                            </option>

                            @foreach($instructors as $instructor)

                            <option
                                value="{{ $instructor->uuid }}"
                                {{ old('instructor_uuid', $class->instructor_uuid) == $instructor->uuid ? 'selected' : '' }}>

                                {{ $instructor->name }}

                            </option>

                            @endforeach

                        </select>

                        @error('instructor_uuid')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    @else

                    {{-- Instructor otomatis --}}
                    <div class="form-group mb-3">

                        <label class="mb-2">
                            Instructor
                        </label>

                        <div class="form-control bg-light">

                            {{ auth()->user()->name }}

                        </div>

                        <small class="text-muted">
                            Class ini akan menggunakan akun instructor yang sedang login.
                        </small>

                    </div>

                    @endif


                    {{-- Harga --}}
                    <div class="form-group mb-3">

                        <label
                            for="price_{{ $class->uuid }}"
                            class="mb-2">

                            Harga
                            <span class="text-danger">*</span>

                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="number"
                                class="form-control @error('price') is-invalid @enderror"
                                id="price_{{ $class->uuid }}"
                                name="price"
                                placeholder="0"
                                value="{{ old('price', $class->price) }}"
                                min="0"
                                required>

                        </div>

                        @error('price')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Quota Cost --}}
                    <div class="form-group mb-3">

                        <label
                            for="quota_cost_{{ $class->uuid }}"
                            class="mb-2">

                            Quota Cost
                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="number"
                            class="form-control @error('quota_cost') is-invalid @enderror"
                            id="quota_cost_{{ $class->uuid }}"
                            name="quota_cost"
                            placeholder="Contoh: 1"
                            value="{{ old('quota_cost', $class->quota_cost) }}"
                            min="1"
                            required>

                        <small class="text-muted">
                            Jumlah quota membership yang digunakan untuk mengikuti class ini.
                        </small>

                        @error('quota_cost')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Status --}}
                    <div class="form-group mb-3">

                        <label
                            for="is_active_{{ $class->uuid }}"
                            class="mb-2">

                            Status
                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="is_active"
                            id="is_active_{{ $class->uuid }}"
                            class="form-control @error('is_active') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Pilih Status --
                            </option>

                            <option
                                value="active"
                                {{ old('is_active', $class->is_active) == 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option
                                value="inactive"
                                {{ old('is_active', $class->is_active) == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>

                        </select>

                        @error('is_active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Deskripsi --}}
                    <div class="form-group mb-3">

                        <label
                            for="description_{{ $class->uuid }}"
                            class="mb-2">

                            Deskripsi

                        </label>

                        <textarea
                            class="form-control @error('description') is-invalid @enderror"
                            id="description_{{ $class->uuid }}"
                            name="description"
                            placeholder="Deskripsi class"
                            rows="4">{{ old('description', $class->description) }}</textarea>

                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>


                {{-- =========================
                    FOOTER
                ========================== --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>
</div>