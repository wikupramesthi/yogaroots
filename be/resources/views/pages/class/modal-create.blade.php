{{-- Modal Create Class --}}

<div
  id="modal-form-add-class"
  class="modal fade modal-form-class"
  tabindex="-1"
  aria-labelledby="modal-form-add-class-label"
  aria-hidden="true"
  style="display: none;">

  <div class="modal-dialog modal-dialog-centered modal-lg">

    <div class="modal-content border-0 shadow-lg">


      {{-- =========================
                HEADER
            ========================== --}}
      <div class="modal-header border-bottom">

        <div>

          <h5
            class="modal-title fw-semibold mb-1"
            id="modal-form-add-class-label">

            Add New Class

          </h5>

          <small class="text-muted">
            Tambahkan class yoga baru ke dalam sistem.
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
                FORM
            ========================== --}}
      <form
        action="{{ route('classes.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf


        {{-- =========================
                    BODY
                ========================== --}}
        <div class="modal-body p-4">

          {{-- =========================
                        BASIC INFORMATION
                    ========================== --}}
          <div class="mb-4">

            <div class="d-flex align-items-center gap-2 mb-3">

              <div
                class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                style="width: 36px; height: 36px;">

                <i class="bi bi-info-circle"></i>

              </div>

              <div>

                <h6 class="mb-0 fw-semibold">
                  Basic Information
                </h6>

                <small class="text-muted">
                  Informasi utama class
                </small>

              </div>

            </div>


            {{-- Nama Class --}}
            <div class="form-group mb-3">

              <label
                for="name"
                class="form-label fw-medium">

                Nama Class
                <span class="text-danger">*</span>

              </label>

              <input
                type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Contoh: Hatha Yoga"
                value="{{ old('name') }}"
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
                for="image"
                class="form-label fw-medium">

                Gambar Class

              </label>

              <input
                type="file"
                name="image"
                id="image"
                class="form-control @error('image') is-invalid @enderror"
                accept=".jpg,.jpeg,.png,.webp">

              <small class="text-muted">
                Format JPG, JPEG, PNG, atau WEBP. Maksimal 2MB.
              </small>

              @error('image')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>

          </div>


          {{-- =========================
                        CLASS DETAILS
                    ========================== --}}
          <div class="mb-4">

            <div class="d-flex align-items-center gap-2 mb-3">

              <div
                class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                style="width: 36px; height: 36px;">

                <i class="bi bi-bar-chart"></i>

              </div>

              <div>

                <h6 class="mb-0 fw-semibold">
                  Class Details
                </h6>

                <small class="text-muted">
                  Level dan durasi class
                </small>

              </div>

            </div>


            <div class="row">

              {{-- Level --}}
              <div class="col-md-6">

                <div class="form-group mb-3">

                  <label
                    for="level"
                    class="form-label fw-medium">

                    Level
                    <span class="text-danger">*</span>

                  </label>

                  <select
                    name="level"
                    id="level"
                    class="form-control @error('level') is-invalid @enderror"
                    required>

                    <option value="">
                      -- Pilih Level --
                    </option>

                    <option
                      value="pemula"
                      {{ old('level') == 'pemula' ? 'selected' : '' }}>
                      Pemula
                    </option>

                    <option
                      value="menengah"
                      {{ old('level') == 'menengah' ? 'selected' : '' }}>
                      Menengah
                    </option>

                    <option
                      value="advance"
                      {{ old('level') == 'advance' ? 'selected' : '' }}>
                      Advance
                    </option>

                    <option
                      value="semua_level"
                      {{ old('level') == 'semua_level' ? 'selected' : '' }}>
                      Semua Level
                    </option>

                  </select>

                  @error('level')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror

                </div>

              </div>


              {{-- Duration --}}
              <div class="col-md-6">

                <div class="form-group mb-3">

                  <label
                    for="duration"
                    class="form-label fw-medium">

                    Durasi
                    <span class="text-danger">*</span>

                  </label>

                  <div class="input-group">

                    <input
                      type="number"
                      name="duration"
                      id="duration"
                      class="form-control @error('duration') is-invalid @enderror"
                      placeholder="Contoh: 60"
                      value="{{ old('duration') }}"
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

              </div>

            </div>

          </div>


          {{-- =========================
                        INSTRUCTOR
                    ========================== --}}
          <div class="mb-4">

            <div class="d-flex align-items-center gap-2 mb-3">

              <div
                class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                style="width: 36px; height: 36px;">

                <i class="bi bi-person"></i>

              </div>

              <div>

                <h6 class="mb-0 fw-semibold">
                  Instructor
                </h6>

                <small class="text-muted">
                  Tentukan instructor untuk class ini
                </small>

              </div>

            </div>


            @if(
            auth()->user()->hasRole('admin') ||
            auth()->user()->hasRole('superadmin')
            )

            <div class="form-group">

              <label
                for="instructor_uuid"
                class="form-label fw-medium">

                Instructor
                <span class="text-danger">*</span>

              </label>

              <select
                name="instructor_uuid"
                id="instructor_uuid"
                class="form-control @error('instructor_uuid') is-invalid @enderror"
                required>

                <option value="">
                  -- Pilih Instructor --
                </option>

                @foreach($instructors as $instructor)

                <option
                  value="{{ $instructor->uuid }}"
                  {{ old('instructor_uuid') == $instructor->uuid ? 'selected' : '' }}>

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

            {{-- Instructor --}}
            <div class="form-group">

              <label class="form-label fw-medium">
                Instructor
              </label>

              <div
                class="form-control bg-light d-flex align-items-center">

                <i class="bi bi-person-circle me-2 text-primary"></i>

                {{ auth()->user()->name }}

              </div>

              <small class="text-muted">
                Class otomatis menggunakan akun instructor yang sedang login.
              </small>

            </div>

            @endif

          </div>


          {{-- =========================
                        PRICING & QUOTA
                    ========================== --}}
          <div class="mb-4">

            <div class="d-flex align-items-center gap-2 mb-3">

              <div
                class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                style="width: 36px; height: 36px;">

                <i class="bi bi-wallet2"></i>

              </div>

              <div>

                <h6 class="mb-0 fw-semibold">
                  Pricing & Quota
                </h6>

                <small class="text-muted">
                  Harga dan penggunaan quota membership
                </small>

              </div>

            </div>


            <div class="row">

              {{-- Price --}}
              <div class="col-md-6">

                <div class="form-group mb-3">

                  <label
                    for="price"
                    class="form-label fw-medium">

                    Harga
                    <span class="text-danger">*</span>

                  </label>

                  <div class="input-group">

                    <span class="input-group-text">
                      Rp
                    </span>

                    <input
                      type="number"
                      name="price"
                      id="price"
                      class="form-control @error('price') is-invalid @enderror"
                      placeholder="0"
                      value="{{ old('price', 0) }}"
                      min="0"
                      required>

                  </div>

                  @error('price')
                  <div class="text-danger small mt-1">
                    {{ $message }}
                  </div>
                  @enderror

                </div>

              </div>


              {{-- Quota Cost --}}
              <div class="col-md-6">

                <div class="form-group mb-3">

                  <label
                    for="quota_cost"
                    class="form-label fw-medium">

                    Quota Cost
                    <span class="text-danger">*</span>

                  </label>

                  <input
                    type="number"
                    name="quota_cost"
                    id="quota_cost"
                    class="form-control @error('quota_cost') is-invalid @enderror"
                    placeholder="Contoh: 1"
                    value="{{ old('quota_cost', 1) }}"
                    min="1"
                    required>

                  <small class="text-muted">
                    Quota yang digunakan saat member booking class.
                  </small>

                  @error('quota_cost')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror

                </div>

              </div>

            </div>

          </div>


          {{-- =========================
                        STATUS
                    ========================== --}}
          <div class="mb-4">

            <div class="d-flex align-items-center gap-2 mb-3">

              <div
                class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                style="width: 36px; height: 36px;">

                <i class="bi bi-toggle-on"></i>

              </div>

              <div>

                <h6 class="mb-0 fw-semibold">
                  Status
                </h6>

                <small class="text-muted">
                  Atur status class
                </small>

              </div>

            </div>


            <div class="form-group">

              <label
                for="is_active"
                class="form-label fw-medium">

                Status
                <span class="text-danger">*</span>

              </label>

              <select
                name="is_active"
                id="is_active"
                class="form-control @error('is_active') is-invalid @enderror"
                required>

                <option value="">
                  -- Pilih Status --
                </option>

                <option
                  value="active"
                  {{ old('is_active', 'active') == 'active' ? 'selected' : '' }}>
                  Aktif
                </option>

                <option
                  value="inactive"
                  {{ old('is_active') == 'inactive' ? 'selected' : '' }}>
                  Tidak Aktif
                </option>

              </select>

              @error('is_active')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>

          </div>


          {{-- =========================
                        DESCRIPTION
                    ========================== --}}
          <div>

            <div class="d-flex align-items-center gap-2 mb-3">

              <div
                class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary"
                style="width: 36px; height: 36px;">

                <i class="bi bi-text-paragraph"></i>

              </div>

              <div>

                <h6 class="mb-0 fw-semibold">
                  Description
                </h6>

                <small class="text-muted">
                  Jelaskan tentang class
                </small>

              </div>

            </div>


            <div class="form-group">

              <textarea
                name="description"
                id="description"
                rows="4"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Tulis deskripsi class...">{{ old('description') }}</textarea>

              @error('description')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>

          </div>

        </div>


        {{-- =========================
                    FOOTER
                ========================== --}}
        <div class="modal-footer bg-light border-top">

          <button
            type="button"
            class="btn btn-light"
            data-bs-dismiss="modal">

            Batal

          </button>

          <button
            type="submit"
            class="btn btn-primary px-4">

            <i class="bi bi-check-lg me-1"></i>

            Save Class

          </button>

        </div>

      </form>

    </div>

  </div>

</div>