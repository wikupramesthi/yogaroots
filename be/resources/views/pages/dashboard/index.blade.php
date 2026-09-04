@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Dashboard" page="Dashboard" active="" route="{{ route('dashboard.index') }}" />
@endsection

<div class="page-content">
    <section class="row">
        <div class="col-12">

            @if (auth()->user()->role === 'user')
            @include('pages.dashboard.card')
            @else
            @include('pages.dashboard.member')
            @endif

        </div>

    </section>
</div>

@if (empty($user->no_hp))
<div class="modal fade"
    id="completeProfileModal"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('submit.sumber') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">
                        Complete Your Profile
                    </h5>
                </div>

                <div class="modal-body">

                    <p class="text-secondary mb-4">
                        Please provide your WhatsApp number and let us know
                        how you heard about us.
                    </p>

                    {{-- WhatsApp Number --}}
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">
                            WhatsApp Number
                        </label>

                        <input type="text"
                            name="no_hp"
                            id="no_hp"
                            class="form-control @error('no_hp') is-invalid @enderror"
                            placeholder="08xxxxxxxxxx"
                            value="{{ old('no_hp') }}">

                        @error('no_hp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Sumber Informasi --}}
                    <div class="mb-3">
                        <label for="sumber_informasi" class="form-label">
                            How did you hear about us?
                        </label>

                        <select name="sumber_informasi"
                            id="sumber_informasi"
                            class="form-select @error('sumber_informasi') is-invalid @enderror">

                            <option value="">
                                Select an option
                            </option>

                            <option value="google">Google Search</option>
                            <option value="instagram">Instagram</option>
                            <option value="facebook">Facebook</option>
                            <option value="tiktok">TikTok</option>
                            <option value="google_maps">Google Maps</option>
                            <option value="friend_family">Friend / Family</option>
                            <option value="yoga_community">Yoga Community</option>
                            <option value="member_referral">Member Referral</option>
                            <option value="yoga_event">Yoga Event / Workshop</option>
                            <option value="whatsapp">WhatsApp</option>
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

@endsection