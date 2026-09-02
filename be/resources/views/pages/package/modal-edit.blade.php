<!-- Modal Edit Package -->

<div
    id="modal-form-edit-package-{{ $package->uuid }}"
    class="modal fade modal-form-package-edit"
    tabindex="-1"
    aria-labelledby="modal-form-edit-package-{{ $package->uuid }}-label"
    aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <form
                action="{{ route('packages.update', $package->uuid) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="modal-form-edit-package-{{ $package->uuid }}-label">
                        Edit Package ({{ $package->name }})
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    {{-- Nama Package --}}
                    <div class="form-group mb-3">

                        <label for="name_{{ $package->uuid }}" class="mb-2">
                            Nama Package
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name_{{ $package->uuid }}"
                            placeholder="Nama Package"
                            name="name"
                            value="{{ $package->name ?? old('name') }}"
                            required>

                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Deskripsi --}}
                    <div class="form-group mb-3">

                        <label for="description_{{ $package->uuid }}" class="mb-2">
                            Deskripsi
                        </label>

                        <textarea
                            class="form-control @error('description') is-invalid @enderror"
                            id="description_{{ $package->uuid }}"
                            name="description"
                            placeholder="Deskripsi Package"
                            rows="3">{{ $package->description ?? old('description') }}</textarea>

                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Harga --}}
                    <div class="form-group mb-3">

                        <label for="price_{{ $package->uuid }}" class="mb-2">
                            Harga Normal
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="number"
                                class="form-control @error('price') is-invalid @enderror"
                                id="price_{{ $package->uuid }}"
                                name="price"
                                placeholder="0"
                                value="{{ old('price', $package->price) }}"
                                min="0"
                                required>

                        </div>

                        @error('price')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    <div class="form-group mb-3">

                        <label for="discount_price_{{ $package->uuid }}" class="mb-2">
                            Harga Diskon
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="number"
                                class="form-control @error('discount_price') is-invalid @enderror"
                                id="discount_price_{{ $package->uuid }}"
                                name="discount_price"
                                placeholder="0"
                                value="{{ old('discount_price', $package->discount_price) }}"
                                min="0">

                        </div>

                        <small class="text-muted">
                            Kosongkan jika paket tidak memiliki diskon.
                        </small>

                        @error('discount_price')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    {{-- Quota --}}
                    <div class="form-group mb-3">

                        <label for="quota_{{ $package->uuid }}" class="mb-2">
                            Quota
                        </label>

                        <input
                            type="number"
                            class="form-control @error('quota') is-invalid @enderror"
                            id="quota_{{ $package->uuid }}"
                            name="quota"
                            placeholder="Kosongkan jika Unlimited"
                            value="{{ $package->quota ?? old('quota') }}"
                            min="1">

                        <small class="text-muted">
                            Kosongkan jika package memiliki quota unlimited.
                        </small>

                        @error('quota')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Durasi --}}
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label for="duration_{{ $package->uuid }}" class="mb-2">
                                    Durasi
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    class="form-control @error('duration') is-invalid @enderror"
                                    id="duration_{{ $package->uuid }}"
                                    name="duration"
                                    placeholder="Contoh: 1"
                                    value="{{ $package->duration ?? old('duration') }}"
                                    min="1"
                                    required>

                                @error('duration')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group mb-3">

                                <label for="duration_unit_{{ $package->uuid }}" class="mb-2">
                                    Satuan Durasi
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="duration_unit"
                                    id="duration_unit_{{ $package->uuid }}"
                                    class="form-control @error('duration_unit') is-invalid @enderror"
                                    required>

                                    <option value="">
                                        -- Pilih --
                                    </option>

                                    <option
                                        value="day"
                                        {{ $package->duration_unit == 'day' ? 'selected' : '' }}>
                                        Hari
                                    </option>

                                    <option
                                        value="week"
                                        {{ $package->duration_unit == 'week' ? 'selected' : '' }}>
                                        Minggu
                                    </option>

                                    <option
                                        value="month"
                                        {{ $package->duration_unit == 'month' ? 'selected' : '' }}>
                                        Bulan
                                    </option>

                                    <option
                                        value="year"
                                        {{ $package->duration_unit == 'year' ? 'selected' : '' }}>
                                        Tahun
                                    </option>

                                </select>

                                @error('duration_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="form-group mb-3">

                        <label for="is_active_{{ $package->uuid }}" class="mb-2">
                            Status
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="is_active"
                            id="is_active_{{ $package->uuid }}"
                            class="form-control @error('is_active') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Pilih --
                            </option>

                            <option
                                value="active"
                                {{ $package->is_active == 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option
                                value="inactive"
                                {{ $package->is_active == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>

                        </select>

                        @error('is_active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>


                    {{-- Popular --}}
                    <div class="form-group mb-3">

                        <div class="form-check">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="is_popular_{{ $package->uuid }}"
                                name="is_popular"
                                value="1"
                                {{ $package->is_popular ? 'checked' : '' }}>

                            <label
                                class="form-check-label"
                                for="is_popular_{{ $package->uuid }}">
                                Tandai sebagai package populer
                            </label>

                        </div>

                    </div>


                    {{-- Features --}}
                    <div class="form-group mb-3">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <label class="mb-0">
                                Features
                            </label>

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-primary"
                                onclick="addEditPackageFeature('{{ $package->uuid }}')">
                                <i class="bi bi-plus-lg"></i>
                                Tambah Feature
                            </button>

                        </div>


                        <div id="package-features-container-{{ $package->uuid }}">

                            @forelse ($package->features as $feature)

                            <div class="input-group mb-2 package-feature-item">

                                <input
                                    type="text"
                                    name="features[]"
                                    class="form-control"
                                    value="{{ $feature->feature }}"
                                    placeholder="Contoh: 4x Yoga Class">

                                <button
                                    type="button"
                                    class="btn btn-outline-danger"
                                    onclick="removeEditPackageFeature(this)">
                                    <i class="bi bi-x-lg"></i>
                                </button>

                            </div>

                            @empty

                            <div class="input-group mb-2 package-feature-item">

                                <input
                                    type="text"
                                    name="features[]"
                                    class="form-control"
                                    placeholder="Contoh: 4x Yoga Class">

                                <button
                                    type="button"
                                    class="btn btn-outline-danger"
                                    onclick="removeEditPackageFeature(this)">
                                    <i class="bi bi-x-lg"></i>
                                </button>

                            </div>

                            @endforelse

                        </div>

                        @error('features.*')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>


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


<script>
    function addEditPackageFeature(uuid) {

        const container = document.getElementById(
            'package-features-container-' + uuid
        );

        const html = `
            <div class="input-group mb-2 package-feature-item">

                <input
                    type="text"
                    name="features[]"
                    class="form-control"
                    placeholder="Contoh: Free Mat"
                >

                <button
                    type="button"
                    class="btn btn-outline-danger"
                    onclick="removeEditPackageFeature(this)"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
    }


    function removeEditPackageFeature(button) {

        const items = button
            .closest('[id^="package-features-container-"]')
            ?.querySelectorAll('.package-feature-item');

        if (items && items.length <= 1) {

            button
                .closest('.package-feature-item')
                .querySelector('input')
                .value = '';

            return;
        }

        button
            .closest('.package-feature-item')
            .remove();
    }
</script>