@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Dashboard" page="Dashboard" active="" route="{{ route('dashboard.index') }}" />
@endsection

<div class="page-content">
    <section class="row">
        <div class="col-12">

            @role('user')
            @include('pages.dashboard.member')
            @else
            @include('pages.dashboard.card')
            @endif

        </div>

    </section>
</div>

@if (blank(Auth::user()->no_hp))
<div class="modal fade"
    id="completeProfileModal"
    tabindex="-1"
    aria-labelledby="completeProfileModalLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('dashboard.submitSumber') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="completeProfileModalLabel">
                        Complete Your Information
                    </h5>
                </div>

                <div class="modal-body">

                    <p class="text-secondary">
                        Please complete the following information
                        before continuing.
                    </p>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">
                            WhatsApp Number
                        </label>

                        <input type="text"
                            name="no_hp"
                            id="no_hp"
                            class="form-control @error('no_hp') is-invalid @enderror"
                            placeholder="08xxxxxxxxxx"
                            value="{{ old('no_hp') }}"
                            required>

                        @error('no_hp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sumber_informasi" class="form-label">
                            How did you hear about us?
                        </label>

                        <select name="sumber_informasi"
                            id="sumber_informasi"
                            class="form-select @error('sumber_informasi') is-invalid @enderror"
                            required>
                            <option value="">Select an option</option>
                            <option value="google">Google Search</option>
                            <option value="sosmed">Social Media</option>
                            <option value="friend">Friend / Family</option>
                            <option value="community">Yoga Community</option>
                            <option value="event">Yoga Event / Workshop</option>
                            <option value="website">Website</option>
                            <option value="other">Other</option>

                        </select>

                        @error('sumber_informasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        Save Information
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endif

@if (empty($user->no_hp))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('completeProfileModal');

        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement, {
                backdrop: 'static',
                keyboard: false
            });

            modal.show();
        }
    });
</script>
@endif

@endsection