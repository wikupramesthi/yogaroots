@extends('layouts.app')

@section('title', 'Add Package')

@section('content')

<div class="container-fluid">

  {{-- Page Header --}}
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
      <h4 class="mb-1 fw-bold">
        Add Package
      </h4>
      <p class="text-muted mb-0">
        Create a new membership package.
      </p>
    </div>

    <a href="{{ route('packages.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left me-1"></i>
      Back
    </a>
  </div>


  {{-- Validation Error --}}
  @if ($errors->any())
  <div class="alert alert-danger border-0 mb-4">
    <div class="d-flex align-items-start gap-2">
      <i class="bi bi-exclamation-circle-fill mt-1"></i>

      <div>
        <strong>Please check the following errors:</strong>

        <ul class="mb-0 mt-2 ps-3">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  @endif


  <form action="{{ route('packages.store') }}" method="POST">
    @csrf

    <div class="row g-4">

      {{-- =========================================================
                MAIN CONTENT
            ========================================================== --}}
      <div class="col-lg-8">

        {{-- Package Information --}}
        <div class="card border-0 shadow-sm">

          <div class="card-header bg-transparent border-0 pt-4 px-4">
            <div class="d-flex align-items-center gap-2">

              <div class="package-section-icon">
                <i class="bi bi-box-seam"></i>
              </div>

              <div>
                <h5 class="mb-1 fw-semibold">
                  Package Information
                </h5>

                <p class="text-muted small mb-0">
                  Basic information about the membership package.
                </p>
              </div>

            </div>
          </div>


          <div class="card-body p-4">

            {{-- Package Name --}}
            <div class="mb-4">

              <label for="name" class="form-label fw-semibold">
                Package Name
                <span class="text-danger">*</span>
              </label>

              <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                placeholder="Example: Silver"
                required>

              @error('name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>


            {{-- Description --}}
            <div class="mb-0">

              <label for="description" class="form-label fw-semibold">
                Description
              </label>

              <textarea
                id="description"
                name="description"
                rows="4"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Describe what this package offers...">{{ old('description') }}</textarea>

              @error('description')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>

          </div>
        </div>


        {{-- Package Options --}}
        <div class="card border-0 shadow-sm mt-4">

          <div class="card-header bg-transparent border-0 pt-4 px-4">

            <div class="d-flex justify-content-between align-items-start gap-3">

              <div class="d-flex align-items-center gap-2">

                <div class="package-section-icon">
                  <i class="bi bi-tags"></i>
                </div>

                <div>
                  <h5 class="mb-1 fw-semibold">
                    Package Options
                  </h5>

                  <p class="text-muted small mb-0">
                    Set class quota, pricing, and validity for each option.
                  </p>
                </div>

              </div>


              <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                onclick="addPackageOption()">

                <i class="bi bi-plus-lg me-1"></i>
                Add Option

              </button>

            </div>

          </div>


          <div class="card-body p-4">

            <div id="package-options-container">

              {{-- First Option --}}
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

                  <button
                    type="button"
                    class="btn btn-sm btn-outline-danger package-remove-option"
                    onclick="removePackageOption(this)">

                    <i class="bi bi-trash3"></i>

                  </button>

                </div>


                {{-- Option Name --}}
                <div class="mb-3">

                  <label class="form-label">
                    Option Name
                    <span class="text-danger">*</span>
                  </label>

                  <input
                    type="text"
                    name="options[0][name]"
                    class="form-control @error('options.0.name') is-invalid @enderror"
                    value="{{ old('options.0.name') }}"
                    placeholder="Example: 4 Classes"
                    required>

                  @error('options.0.name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror

                </div>


                <div class="row g-3">

                  {{-- Class Quota --}}
                  <div class="col-md-4">

                    <label class="form-label">
                      Class Quota
                      <span class="text-danger">*</span>
                    </label>

                    <input
                      type="number"
                      name="options[0][quota]"
                      class="form-control"
                      value="{{ old('options.0.quota') }}"
                      min="1"
                      placeholder="Example: 4"
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

                      <input
                        type="number"
                        name="options[0][price]"
                        class="form-control"
                        value="{{ old('options.0.price') }}"
                        min="0"
                        placeholder="0"
                        required>

                    </div>

                  </div>


                  {{-- Discounted Price --}}
                  <div class="col-md-4">

                    <label class="form-label">
                      Discounted Price
                    </label>

                    <div class="input-group">

                      <span class="input-group-text">
                        Rp
                      </span>

                      <input
                        type="number"
                        name="options[0][discount_price]"
                        class="form-control"
                        value="{{ old('options.0.discount_price') }}"
                        min="0"
                        placeholder="Optional">

                    </div>

                  </div>


                  {{-- Duration --}}
                  <div class="col-md-6">

                    <label class="form-label">
                      Duration
                      <span class="text-danger">*</span>
                    </label>

                    <input
                      type="number"
                      name="options[0][duration]"
                      class="form-control"
                      value="{{ old('options.0.duration', 1) }}"
                      min="1"
                      placeholder="Example: 1"
                      required>

                  </div>


                  {{-- Duration Unit --}}
                  <div class="col-md-6">

                    <label class="form-label">
                      Duration Unit
                      <span class="text-danger">*</span>
                    </label>

                    <select
                      name="options[0][duration_unit]"
                      class="form-select"
                      required>

                      <option value="">
                        -- Select --
                      </option>

                      <option
                        value="day"
                        {{ old('options.0.duration_unit', 'month') === 'day' ? 'selected' : '' }}>
                        Days
                      </option>

                      <option
                        value="week"
                        {{ old('options.0.duration_unit', 'month') === 'week' ? 'selected' : '' }}>
                        Weeks
                      </option>

                      <option
                        value="month"
                        {{ old('options.0.duration_unit', 'month') === 'month' ? 'selected' : '' }}>
                        Months
                      </option>

                      <option
                        value="year"
                        {{ old('options.0.duration_unit', 'month') === 'year' ? 'selected' : '' }}>
                        Years
                      </option>

                    </select>

                  </div>

                </div>

              </div>

            </div>


            <div class="package-option-info">
              <i class="bi bi-info-circle me-1"></i>
              Each option can have its own price, class quota, and validity period.
            </div>

          </div>
        </div>


        {{-- Package Features --}}
        <div class="card border-0 shadow-sm mt-4">

          <div class="card-header bg-transparent border-0 pt-4 px-4">

            <div class="d-flex justify-content-between align-items-start gap-3">

              <div class="d-flex align-items-center gap-2">

                <div class="package-section-icon">
                  <i class="bi bi-list-check"></i>
                </div>

                <div>
                  <h5 class="mb-1 fw-semibold">
                    Package Features
                  </h5>

                  <p class="text-muted small mb-0">
                    Add benefits included in this package.
                  </p>
                </div>

              </div>


              <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                onclick="addPackageFeature()">

                <i class="bi bi-plus-lg me-1"></i>
                Add Feature

              </button>

            </div>

          </div>


          <div class="card-body p-4">

            <div id="package-features-container">

              <div class="input-group mb-2 package-feature-item">

                <span class="input-group-text bg-transparent">
                  <i class="bi bi-check2"></i>
                </span>

                <input
                  type="text"
                  name="features[]"
                  class="form-control"
                  placeholder="Example: Free Mat Rental">

                <button
                  type="button"
                  class="btn btn-outline-danger"
                  onclick="removePackageFeature(this)">

                  <i class="bi bi-x-lg"></i>

                </button>

              </div>

            </div>


            @error('features.*')
            <div class="text-danger small mt-2">
              {{ $message }}
            </div>
            @enderror

          </div>
        </div>

      </div>


      {{-- =========================================================
                SIDEBAR
            ========================================================== --}}
      <div class="col-lg-4">

        {{-- Package Settings --}}
        <div class="card border-0 shadow-sm">

          <div class="card-header bg-transparent border-0 pt-4 px-4">

            <h5 class="mb-1 fw-semibold">
              Package Settings
            </h5>

            <p class="text-muted small mb-0">
              Manage package visibility and popularity.
            </p>

          </div>


          <div class="card-body p-4">

            {{-- Status --}}
            <div class="mb-4">

              <label for="is_active" class="form-label fw-semibold">
                Status
                <span class="text-danger">*</span>
              </label>

              <select
                name="is_active"
                id="is_active"
                class="form-select @error('is_active') is-invalid @enderror"
                required>

                <option value="">
                  -- Select Status --
                </option>

                <option
                  value="active"
                  {{ old('is_active', 'active') === 'active' ? 'selected' : '' }}>
                  Active
                </option>

                <option
                  value="inactive"
                  {{ old('is_active') === 'inactive' ? 'selected' : '' }}>
                  Inactive
                </option>

              </select>

              @error('is_active')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror

            </div>


            {{-- Popular --}}
            <div class="package-popular-box">

              <div class="form-check">

                <input
                  type="checkbox"
                  class="form-check-input"
                  id="is_popular"
                  name="is_popular"
                  value="1"
                  {{ old('is_popular') ? 'checked' : '' }}>

                <label
                  class="form-check-label fw-semibold"
                  for="is_popular">

                  Mark as Popular

                </label>

              </div>

              <small class="text-muted d-block mt-1">
                Popular packages can be highlighted
                on the membership page.
              </small>

            </div>

          </div>
        </div>


        {{-- Package Tips --}}
        <div class="card border-0 shadow-sm mt-4">

          <div class="card-body p-4">

            <div class="d-flex align-items-center gap-2 mb-3">

              <i class="bi bi-lightbulb text-warning"></i>

              <h6 class="fw-semibold mb-0">
                Package Tips
              </h6>

            </div>

            <ul class="text-muted small mb-0 ps-3">

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

        {{-- Form Actions --}}
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
            Save Package

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
  let packageOptionIndex = 1;


  /*
  |--------------------------------------------------------------------------
  | Package Options
  |--------------------------------------------------------------------------
  */

  function addPackageOption() {

    const container = document.getElementById(
      'package-options-container'
    );

    const index = packageOptionIndex++;

    const html = `
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

                    <button
                        type="button"
                        class="btn btn-sm btn-outline-danger"
                        onclick="removePackageOption(this)">

                        <i class="bi bi-trash3"></i>

                    </button>

                </div>


                <div class="mb-3">

                    <label class="form-label">
                        Option Name
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
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

                        <input
                            type="number"
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

                            <input
                                type="number"
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

                            <input
                                type="number"
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

                        <input
                            type="number"
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

                        <select
                            name="options[${index}][duration_unit]"
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

    container.insertAdjacentHTML(
      'beforeend',
      html
    );

    updatePackageOptionTitles();
  }


  function removePackageOption(button) {

    const items = document.querySelectorAll(
      '#package-options-container .package-option-item'
    );

    if (items.length <= 1) {
      return;
    }

    button
      .closest('.package-option-item')
      .remove();

    updatePackageOptionTitles();
  }


  function updatePackageOptionTitles() {

    const items = document.querySelectorAll(
      '#package-options-container .package-option-item'
    );

    items.forEach((item, index) => {

      const title = item.querySelector(
        '.package-option-title'
      );

      if (title) {
        title.textContent = `Option ${index + 1}`;
      }

    });
  }


  /*
  |--------------------------------------------------------------------------
  | Package Features
  |--------------------------------------------------------------------------
  */

  function addPackageFeature() {

    const container = document.getElementById(
      'package-features-container'
    );

    const html = `
            <div class="input-group mb-2 package-feature-item">

                <span class="input-group-text bg-transparent">
                    <i class="bi bi-check2"></i>
                </span>

                <input
                    type="text"
                    name="features[]"
                    class="form-control"
                    placeholder="Example: Priority Booking">

                <button
                    type="button"
                    class="btn btn-outline-danger"
                    onclick="removePackageFeature(this)">

                    <i class="bi bi-x-lg"></i>

                </button>

            </div>
        `;

    container.insertAdjacentHTML(
      'beforeend',
      html
    );
  }


  function removePackageFeature(button) {

    const items = document.querySelectorAll(
      '#package-features-container .package-feature-item'
    );

    if (items.length <= 1) {

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

@endsection