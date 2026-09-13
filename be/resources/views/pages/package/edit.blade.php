@extends('layouts.app')

@section('title', 'Edit Package')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Edit Package
            </h4>

            <p class="text-muted mb-0">
                Update package information, pricing options, and features.
            </p>
        </div>

        <a href="{{ route('packages.index') }}"
            class="btn btn-secondary border">

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

    <div class="alert alert-danger border-0 shadow-sm mb-4">

        <div class="fw-semibold mb-2">
            Please check the following:
        </div>

        <ul class="mb-0 ps-3">

            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach

        </ul>

    </div>

    @endif


    <form action="{{ route('packages.update', $package->uuid) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- ========================================================= --}}
            {{-- LEFT --}}
            {{-- ========================================================= --}}
            <div class="col-lg-8">


                {{-- Package Information --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-transparent border-0 p-4 pb-2">

                        <div class="d-flex align-items-center gap-3">

                            <div class="package-section-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Package Information
                                </h5>

                                <p class="text-muted small mb-0">
                                    Basic information about the membership package.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        {{-- Name --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Package Name
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $package->name) }}"
                                placeholder="Example: Yoga Membership"
                                required>

                        </div>


                        {{-- Description --}}
                        <div>

                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description"
                                class="form-control"
                                rows="4"
                                placeholder="Describe this package...">{{ old('description', $package->description) }}</textarea>

                        </div>

                    </div>

                </div>



                {{-- ===================================================== --}}
                {{-- Package Options --}}
                {{-- ===================================================== --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-transparent border-0 p-4 pb-2">

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                            <div class="d-flex align-items-center gap-3">

                                <div class="package-section-icon">
                                    <i class="bi bi-tags"></i>
                                </div>

                                <div>

                                    <h5 class="fw-bold mb-1">
                                        Package Options
                                    </h5>

                                    <p class="text-muted small mb-0">
                                        Set class quota, pricing, and validity for each option.
                                    </p>

                                </div>

                            </div>


                            <button type="button"
                                id="btn-add-package-option"
                                class="btn btn-sm btn-outline-primary">

                                <i class="bi bi-plus-lg me-1"></i>
                                Add Option

                            </button>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        <div id="package-options-container">

                            @forelse ($package->options as $index => $option)

                            <div class="package-option-item border rounded-3 p-3 mb-3">

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <div>

                                        <span class="fw-semibold package-option-title">
                                            Option {{ $index + 1 }}
                                        </span>

                                        <span class="text-muted small ms-1">
                                            Pricing option
                                        </span>

                                    </div>


                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-remove-package-option">

                                        <i class="bi bi-trash3"></i>

                                    </button>

                                </div>


                                {{-- Option Name --}}
                                <div class="mb-3">

                                    <label class="form-label">
                                        Option Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="options[{{ $index }}][name]"
                                        class="form-control"
                                        value="{{ old("options.$index.name", $option->name) }}"
                                        placeholder="Example: 8 Classes"
                                        required>

                                </div>


                                <div class="row g-3">

                                    {{-- Quota --}}
                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Class Quota
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="number"
                                            name="options[{{ $index }}][quota]"
                                            class="form-control"
                                            value="{{ old("options.$index.quota", $option->quota) }}"
                                            placeholder="Example: 8"
                                            min="1"
                                            required>

                                        <small class="text-muted">
                                            Classes included.
                                        </small>

                                    </div>


                                    {{-- Regular Price --}}
                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Regular Price
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                Rp
                                            </span>

                                            <input type="number"
                                                name="options[{{ $index }}][price]"
                                                class="form-control"
                                                value="{{ old("options.$index.price", $option->price) }}"
                                                placeholder="0"
                                                min="0"
                                                required>

                                        </div>

                                    </div>


                                    {{-- Discount --}}
                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Discounted Price
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                Rp
                                            </span>

                                            <input type="number"
                                                name="options[{{ $index }}][discount_price]"
                                                class="form-control"
                                                value="{{ old("options.$index.discount_price", $option->discount_price) }}"
                                                placeholder="Optional"
                                                min="0">

                                        </div>

                                    </div>


                                    {{-- Duration --}}
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Duration
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="number"
                                            name="options[{{ $index }}][duration]"
                                            class="form-control"
                                            value="{{ old("options.$index.duration", $option->duration) }}"
                                            placeholder="Example: 1"
                                            min="1"
                                            required>

                                    </div>


                                    {{-- Duration Unit --}}
                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Duration Unit
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select name="options[{{ $index }}][duration_unit]"
                                            class="form-select"
                                            required>

                                            <option value="">
                                                -- Select --
                                            </option>

                                            <option value="day"
                                                {{ old("options.$index.duration_unit", $option->duration_unit) == 'day' ? 'selected' : '' }}>
                                                Days
                                            </option>

                                            <option value="week"
                                                {{ old("options.$index.duration_unit", $option->duration_unit) == 'week' ? 'selected' : '' }}>
                                                Weeks
                                            </option>

                                            <option value="month"
                                                {{ old("options.$index.duration_unit", $option->duration_unit) == 'month' ? 'selected' : '' }}>
                                                Months
                                            </option>

                                            <option value="year"
                                                {{ old("options.$index.duration_unit", $option->duration_unit) == 'year' ? 'selected' : '' }}>
                                                Years
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                            @empty

                            {{-- Default Option --}}
                            <div class="package-option-item border rounded-3 p-3 mb-3">

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <div>

                                        <span class="fw-semibold package-option-title">
                                            Option 1
                                        </span>

                                        <span class="text-muted small ms-1">
                                            Pricing option
                                        </span>

                                    </div>


                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-remove-package-option">

                                        <i class="bi bi-trash3"></i>

                                    </button>

                                </div>


                                <div class="mb-3">

                                    <label class="form-label">
                                        Option Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="options[0][name]"
                                        class="form-control"
                                        placeholder="Example: 8 Classes"
                                        required>

                                </div>


                                <div class="row g-3">

                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Class Quota
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="number"
                                            name="options[0][quota]"
                                            class="form-control"
                                            placeholder="Example: 8"
                                            min="1"
                                            required>

                                        <small class="text-muted">
                                            Classes included.
                                        </small>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Regular Price
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                Rp
                                            </span>

                                            <input type="number"
                                                name="options[0][price]"
                                                class="form-control"
                                                placeholder="0"
                                                min="0"
                                                required>

                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label">
                                            Discounted Price
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                Rp
                                            </span>

                                            <input type="number"
                                                name="options[0][discount_price]"
                                                class="form-control"
                                                placeholder="Optional"
                                                min="0">

                                        </div>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Duration
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input type="number"
                                            name="options[0][duration]"
                                            class="form-control"
                                            value="1"
                                            min="1"
                                            required>

                                    </div>


                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Duration Unit
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select name="options[0][duration_unit]"
                                            class="form-select"
                                            required>

                                            <option value="">
                                                -- Select --
                                            </option>

                                            <option value="day">
                                                Days
                                            </option>

                                            <option value="week">
                                                Weeks
                                            </option>

                                            <option value="month" selected>
                                                Months
                                            </option>

                                            <option value="year">
                                                Years
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                            @endforelse

                        </div>


                        <div class="package-option-info mt-3">

                            <i class="bi bi-info-circle me-1"></i>

                            You can add multiple pricing options to the same package.
                            Each option can have its own quota, price, and duration.

                        </div>

                    </div>

                </div>



                {{-- ===================================================== --}}
                {{-- Package Features --}}
                {{-- ===================================================== --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-transparent border-0 p-4 pb-2">

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                            <div class="d-flex align-items-center gap-3">

                                <div class="package-section-icon">
                                    <i class="bi bi-list-check"></i>
                                </div>

                                <div>

                                    <h5 class="fw-bold mb-1">
                                        Package Features
                                    </h5>

                                    <p class="text-muted small mb-0">
                                        Add benefits included in this package.
                                    </p>

                                </div>

                            </div>


                            <button type="button"
                                id="btn-add-package-feature"
                                class="btn btn-sm btn-outline-primary">

                                <i class="bi bi-plus-lg me-1"></i>
                                Add Feature

                            </button>

                        </div>

                    </div>


                    <div class="card-body p-4">

                        <div id="package-features-container">

                            @forelse ($package->features as $index => $feature)

                            <div class="input-group mb-2 package-feature-item">

                                <span class="input-group-text bg-transparent">
                                    <i class="bi bi-check2"></i>
                                </span>

                                <input type="text"
                                    name="features[]"
                                    class="form-control"
                                    value="{{ old("features.$index", $feature->feature) }}"
                                    placeholder="Example: Priority Booking">

                                <button type="button"
                                    class="btn btn-outline-danger btn-remove-package-feature">

                                    <i class="bi bi-x-lg"></i>

                                </button>

                            </div>

                            @empty

                            <div class="input-group mb-2 package-feature-item">

                                <span class="input-group-text bg-transparent">
                                    <i class="bi bi-check2"></i>
                                </span>

                                <input type="text"
                                    name="features[]"
                                    class="form-control"
                                    placeholder="Example: Priority Booking">

                                <button type="button"
                                    class="btn btn-outline-danger btn-remove-package-feature">

                                    <i class="bi bi-x-lg"></i>

                                </button>

                            </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </div>



            {{-- ========================================================= --}}
            {{-- RIGHT --}}
            {{-- ========================================================= --}}
            <div class="col-lg-4">


                {{-- Package Settings --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-header bg-transparent border-0 p-4 pb-2">

                        <h5 class="fw-bold mb-1">
                            Package Settings
                        </h5>

                        <p class="text-muted small mb-0">
                            Manage package visibility and popularity.
                        </p>

                    </div>


                    <div class="card-body p-4">

                        {{-- Status --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="is_active"
                                class="form-select"
                                required>

                                <option value="active"
                                    {{ old('is_active', $package->is_active) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive"
                                    {{ old('is_active', $package->is_active) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                        </div>


                        {{-- Popular --}}
                        <div class="package-popular-box">

                            <div class="form-check">

                                <input type="checkbox"
                                    name="is_popular"
                                    value="1"
                                    class="form-check-input"
                                    id="is_popular"
                                    {{ old('is_popular', $package->is_popular) ? 'checked' : '' }}>

                                <label class="form-check-label fw-semibold"
                                    for="is_popular">

                                    Mark as Popular

                                </label>

                            </div>

                            <div class="small text-muted mt-2">

                                Popular packages can be highlighted
                                on the membership page.

                            </div>

                        </div>

                    </div>

                </div>



                {{-- Tips --}}
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-start gap-3">

                            <div class="package-section-icon">

                                <i class="bi bi-lightbulb"></i>

                            </div>


                            <div>

                                <h6 class="fw-bold mb-2">
                                    Tips
                                </h6>

                                <ul class="small text-muted mb-0 ps-3">

                                    <li class="mb-2">
                                        Add at least one package option.
                                    </li>

                                    <li class="mb-2">
                                        Use clear option names such as 1 Class or 8 Classes.
                                    </li>

                                    <li class="mb-2">
                                        Discounted price should be lower than regular price.
                                    </li>

                                    <li>
                                        Add useful benefits to the feature list.
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- Update --}}
                <div class="d-flex gap-2 mt-4 w-100">

                    <a
                        href="{{ route('packages.index') }}"
                        class="btn btn-light flex-fill">

                        Cancel

                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary flex-fill">

                        <i class="bi bi-check-lg me-1"></i>
                        Update Package

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>



<style>
    .package-section-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(75, 107, 82, 0.08);
        color: var(--bs-primary);
        flex-shrink: 0;
    }

    .package-option-item {
        background: var(--bs-body-bg);
    }

    .package-option-info {
        font-size: 13px;
        color: var(--bs-secondary-color);
        background: var(--bs-tertiary-bg);
        border-radius: 8px;
        padding: 10px 12px;
    }

    .package-popular-box {
        padding: 14px;
        border: 1px solid var(--bs-border-color);
        border-radius: 10px;
        background: var(--bs-tertiary-bg);
    }

    .package-feature-item .form-control {
        min-height: 42px;
    }

    .package-option-item .form-control,
    .package-option-item .form-select {
        min-height: 42px;
    }

    @media (max-width: 767.98px) {

        .package-option-item {
            padding: 14px !important;
        }

        .package-option-item .row>div {
            margin-bottom: 12px;
        }

    }
</style>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ==========================================================
           PACKAGE OPTIONS
        ========================================================== */

        const optionContainer =
            document.getElementById('package-options-container');

        const addOptionButton =
            document.getElementById('btn-add-package-option');

        let optionIndex = optionContainer ?
            optionContainer.querySelectorAll('.package-option-item').length :
            0;


        function updateOptionTitles() {

            if (!optionContainer) {
                return;
            }

            const items =
                optionContainer.querySelectorAll('.package-option-item');

            items.forEach(function(item, index) {

                const title =
                    item.querySelector('.package-option-title');

                if (title) {
                    title.textContent = 'Option ' + (index + 1);
                }

            });

        }


        function createOption(index) {

            return `
            <div class="package-option-item border rounded-3 p-3 mb-3">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <span class="fw-semibold package-option-title">
                            Option ${index + 1}
                        </span>

                        <span class="text-muted small ms-1">
                            Pricing option
                        </span>

                    </div>

                    <button type="button"
                            class="btn btn-sm btn-outline-danger btn-remove-package-option">

                        <i class="bi bi-trash3"></i>

                    </button>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Option Name
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="options[${index}][name]"
                           class="form-control"
                           placeholder="Example: 8 Classes"
                           required>

                </div>


                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label">
                            Class Quota
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number"
                               name="options[${index}][quota]"
                               class="form-control"
                               placeholder="Example: 8"
                               min="1"
                               required>

                        <small class="text-muted">
                            Classes included.
                        </small>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Regular Price
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input type="number"
                                   name="options[${index}][price]"
                                   class="form-control"
                                   placeholder="0"
                                   min="0"
                                   required>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Discounted Price
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input type="number"
                                   name="options[${index}][discount_price]"
                                   class="form-control"
                                   placeholder="Optional"
                                   min="0">

                        </div>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Duration
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number"
                               name="options[${index}][duration]"
                               class="form-control"
                               value="1"
                               min="1"
                               placeholder="Example: 1"
                               required>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Duration Unit
                            <span class="text-danger">*</span>
                        </label>

                        <select name="options[${index}][duration_unit]"
                                class="form-select"
                                required>

                            <option value="">
                                -- Select --
                            </option>

                            <option value="day">
                                Days
                            </option>

                            <option value="week">
                                Weeks
                            </option>

                            <option value="month" selected>
                                Months
                            </option>

                            <option value="year">
                                Years
                            </option>

                        </select>

                    </div>

                </div>

            </div>
        `;
        }


        if (addOptionButton && optionContainer) {

            addOptionButton.addEventListener('click', function() {

                optionContainer.insertAdjacentHTML(
                    'beforeend',
                    createOption(optionIndex)
                );

                optionIndex++;

                updateOptionTitles();

            });

        }


        if (optionContainer) {

            optionContainer.addEventListener('click', function(event) {

                const removeButton =
                    event.target.closest('.btn-remove-package-option');

                if (!removeButton) {
                    return;
                }

                const items =
                    optionContainer.querySelectorAll('.package-option-item');

                if (items.length <= 1) {
                    return;
                }

                const item =
                    removeButton.closest('.package-option-item');

                if (item) {
                    item.remove();
                }

                updateOptionTitles();

            });

        }



        /* ==========================================================
           PACKAGE FEATURES
        ========================================================== */

        const featureContainer =
            document.getElementById('package-features-container');

        const addFeatureButton =
            document.getElementById('btn-add-package-feature');


        function createFeature() {

            return `
            <div class="input-group mb-2 package-feature-item">

                <span class="input-group-text bg-transparent">
                    <i class="bi bi-check2"></i>
                </span>

                <input type="text"
                       name="features[]"
                       class="form-control"
                       placeholder="Example: Priority Booking">

                <button type="button"
                        class="btn btn-outline-danger btn-remove-package-feature">

                    <i class="bi bi-x-lg"></i>

                </button>

            </div>
        `;

        }


        if (addFeatureButton && featureContainer) {

            addFeatureButton.addEventListener('click', function() {

                featureContainer.insertAdjacentHTML(
                    'beforeend',
                    createFeature()
                );

            });

        }


        if (featureContainer) {

            featureContainer.addEventListener('click', function(event) {

                const removeButton =
                    event.target.closest('.btn-remove-package-feature');

                if (!removeButton) {
                    return;
                }

                const items =
                    featureContainer.querySelectorAll('.package-feature-item');

                const item =
                    removeButton.closest('.package-feature-item');

                if (!item) {
                    return;
                }


                if (items.length <= 1) {

                    const input =
                        item.querySelector('input');

                    if (input) {
                        input.value = '';
                    }

                    return;
                }


                item.remove();

            });

        }


        /* ==========================================================
           INITIALIZE
        ========================================================== */

        updateOptionTitles();

    });
</script>

@endsection