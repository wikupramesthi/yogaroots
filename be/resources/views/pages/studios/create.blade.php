@extends('layouts.app')
@section('title', 'Add Studio')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Add Studio" page="Studios" active="Add Studio" route="{{ route('studios.index') }}" />
@endsection

<section class="section">
    <form action="{{ route('studios.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="row g-4">

            {{-- Main Information --}}
            <div class="col-12 col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-1">
                            Studio Information
                        </h5>

                        <p class="text-muted small mb-4">
                            Enter the basic information about this studio.
                        </p>


                        {{-- Name --}}
                        <div class="mb-4">

                            <label for="name" class="form-label fw-semibold">
                                Studio Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                id="name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="e.g. YogaRoots Jakarta"
                                required>

                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>


                        {{-- Slug --}}
                        <div class="mb-4">

                            <label for="slug" class="form-label fw-semibold">
                                Slug
                            </label>

                            <input type="text"
                                id="slug"
                                name="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug') }}"
                                placeholder="yogaroots-jakarta">

                            <div class="form-text">
                                Leave blank to generate automatically from the studio name.
                            </div>

                            @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>


                        {{-- Excerpt --}}
                        <div class="mb-4">

                            <label for="excerpt" class="form-label fw-semibold">
                                Excerpt
                            </label>

                            <textarea id="excerpt"
                                name="excerpt"
                                rows="3"
                                class="form-control @error('excerpt') is-invalid @enderror"
                                placeholder="A short description of the studio...">{{ old('excerpt') }}</textarea>

                            @error('excerpt')
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

                            <textarea id="description"
                                name="description"
                                rows="7"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Describe the studio, facilities, atmosphere, and other information...">{{ old('description') }}</textarea>

                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Location & Contact --}}
                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-1">
                            Location & Contact
                        </h5>

                        <p class="text-muted small mb-4">
                            Provide the studio's location and contact details.
                        </p>


                        {{-- Address --}}
                        <div class="mb-4">

                            <label for="address" class="form-label fw-semibold">
                                Address <span class="text-danger">*</span>
                            </label>

                            <textarea id="address"
                                name="address"
                                rows="4"
                                class="form-control @error('address') is-invalid @enderror"
                                placeholder="Enter the complete studio address..."
                                required>{{ old('address') }}</textarea>

                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>


                        <div class="row g-3">

                            {{-- Phone --}}
                            <div class="col-md-6">

                                <label for="phone" class="form-label fw-semibold">
                                    Phone
                                </label>

                                <input type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
                                    placeholder="+62 812 3456 7890">

                                @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>


                            {{-- Email --}}
                            <div class="col-md-6">

                                <label for="email" class="form-label fw-semibold">
                                    Email
                                </label>

                                <input type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="studio@yogaroots.com">

                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                        </div>


                        {{-- Google Maps --}}
                        <div class="mt-4">

                            <label for="google_maps_url" class="form-label fw-semibold">
                                Google Maps URL
                            </label>

                            <input type="url"
                                id="google_maps_url"
                                name="google_maps_url"
                                class="form-control @error('google_maps_url') is-invalid @enderror"
                                value="{{ old('google_maps_url') }}"
                                placeholder="https://maps.google.com/...">

                            <div class="form-text">
                                Paste the Google Maps location link for this studio.
                            </div>

                            @error('google_maps_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- Sidebar --}}
            <div class="col-12 col-lg-4">

                {{-- Studio Image --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-1">
                            Studio Image
                        </h5>

                        <p class="text-muted small mb-4">
                            Upload a representative image of the studio.
                        </p>


                        <div class="mb-3">

                            <div id="imagePreview"
                                class="rounded overflow-hidden bg-light d-flex align-items-center justify-content-center mb-3"
                                style="height: 220px;">

                                <div class="text-center text-muted">

                                    <i class="bi bi-image fs-1 d-block mb-2"></i>

                                    <small>
                                        No image selected
                                    </small>

                                </div>

                            </div>


                            <input type="file"
                                id="image"
                                name="image"
                                class="form-control @error('image') is-invalid @enderror"
                                accept=".jpg,.jpeg,.png,.webp">

                            <div class="form-text">
                                JPG, JPEG, PNG, or WEBP. Maximum 2 MB.
                            </div>

                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Status --}}
                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-1">
                            Status
                        </h5>

                        <p class="text-muted small mb-4">
                            Set the visibility of this studio.
                        </p>


                        <div class="mb-3">

                            <label for="status" class="form-label fw-semibold">
                                Status <span class="text-danger">*</span>
                            </label>

                            <select id="status"
                                name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>

                                <option value="active"
                                    {{ old('status', 'active') === 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive"
                                    {{ old('status') === 'inactive' ? 'selected' : '' }}>
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

                </div>


                {{-- Actions --}}
                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-body p-4">

                        <button type="submit"
                            class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-check-lg me-1"></i>
                            Save Studio
                        </button>

                        <a href="{{ route('studios.index') }}"
                            class="btn btn-light w-100">
                            Cancel
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

</section>

{{-- Image Preview --}}
<script>
    document.getElementById('image').addEventListener('change', function(event) {

        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');

        if (!file) {
            preview.innerHTML = `
                <div class="text-center text-muted">
                    <i class="bi bi-image fs-1 d-block mb-2"></i>
                    <small>No image selected</small>
                </div>
            `;
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}"
                    alt="Studio Preview"
                    class="w-100 h-100"
                    style="object-fit: cover;">
            `;
        };

        reader.readAsDataURL(file);
    });
</script>

@endsection