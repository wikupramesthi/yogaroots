@extends('layouts.mobile')

@section('title', __('mobile.edit_profile'))

@section('content')

<section
    class="screen active"
    id="profil">


    <div class="px-4 pt-4 pb-5">

        {{-- HEADER --}}
        <div class="mb-4">

            <a
                href="{{ route('profile.edit') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center mb-3" onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="ms-2 small fw-semibold">{{ __('mobile.back') }}</span>
            </a>

            <p class="eyebrow mb-1">{{ __('mobile.my_account') }}</p>

            <h1
                class="fw-semibold m-h1">{{ __('mobile.edit_profile') }}</h1>

        </div>


        {{-- PROFILE PHOTO --}}
        @php
        $avatar = $user->avatar;

        if ($avatar) {
        $avatar = Str::startsWith(
        $avatar,
        ['http://', 'https://']
        )
        ? $avatar
        : asset('storage/' . $avatar);
        } else {
        $avatar = asset('dist/assets/images/avatar.jpg');
        }
        @endphp

        <div class="app-card p-4 mb-4">

            <div class="text-center">

                <div class="position-relative d-inline-block">

                    <img
                        src="{{ $avatar }}"
                        alt="{{ $user->name }}"
                        id="profilePreview"
                        class="rounded-circle"
                        decoding="async"
                        style="
                            width:96px;
                            height:96px;
                            object-fit:cover;
                        ">

                    <label
                        for="avatar"
                        class="
                            position-absolute
                            bottom-0
                            end-0
                            rounded-circle
                            bg-sage-soft
                            text-sage
                            d-flex
                            align-items-center
                            justify-content-center
                        "
                        style="
                            width:32px;
                            height:32px;
                            cursor:pointer;
                        ">

                        <i class="bi bi-camera-fill"></i>

                    </label>

                </div>

                <p class="small text-muted2 mb-0 mt-2">
                    {{ __('mobile.change_photo') }}
                </p>

            </div>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('account.update', $user->uuid) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')


            {{-- Hidden avatar input --}}
            <input
                type="file"
                name="avatar"
                id="avatar"
                accept="image/jpeg,image/png,image/webp"
                class="d-none">


            {{-- PERSONAL INFORMATION --}}
            <div class="d-flex justify-content-between align-items-end mt-4">
                <h3 class="h5 fw-semibold mb-0">{{ __('mobile.personal_info') }}</h3>
            </div>

            <div class="app-card overflow-hidden gap-3 p-4 mt-3">

                {{-- NAME --}}
                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label small fw-semibold">{{ __('mobile.full_name') }}</label>

                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        placeholder="{{ __('mobile.name_placeholder') }}"
                        required>

                    @error('name')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- EMAIL --}}
                <div class="mb-3">

                    <label
                        for="email"
                        class="form-label small fw-semibold">{{ __('mobile.email') }}</label>

                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        disabled>

                </div>


                {{-- PHONE --}}
                <div class="mb-3">

                    <label
                        for="no_hp"
                        class="form-label small fw-semibold">{{ __('mobile.phone') }}</label>

                    <input
                        type="text"
                        class="form-control"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp', $user->no_hp) }}"
                        placeholder="{{ __('mobile.phone_placeholder') }}">

                    @error('no_hp')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- PLACE OF BIRTH --}}
                <div class="mb-3">

                    <label
                        for="tempat_lahir"
                        class="form-label small fw-semibold">{{ __('mobile.birth_place') }}</label>

                    <input
                        type="text"
                        class="form-control"
                        id="tempat_lahir"
                        name="tempat_lahir"
                        value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                        placeholder="{{ __('mobile.birth_place_placeholder') }}">

                    @error('tempat_lahir')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- DATE OF BIRTH --}}
                <div class="mb-3">

                    <label
                        for="tanggal_lahir"
                        class="form-label small fw-semibold">{{ __('mobile.birth_date') }}</label>

                    <input
                        type="date"
                        class="form-control"
                        id="tanggal_lahir"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">

                    @error('tanggal_lahir')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- GENDER --}}
                <div class="mb-3">

                    <label
                        for="jenis_kelamin"
                        class="form-label small fw-semibold">{{ __('mobile.gender') }}</label>

                    <select
                        class="form-control"
                        id="jenis_kelamin"
                        name="jenis_kelamin">

                        <option value="">{{ __('mobile.select_gender') }}</option>

                        <option
                            value="L"
                            @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'L')>{{ __('mobile.male') }}</option>

                        <option
                            value="P"
                            @selected(old('jenis_kelamin', $user->jenis_kelamin) === 'P')>{{ __('mobile.female') }}</option>

                    </select>

                    @error('jenis_kelamin')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- RELIGION --}}
                <div>

                    <label
                        for="agama"
                        class="form-label small fw-semibold">{{ __('mobile.religion') }}</label>

                    <input
                        type="text"
                        class="form-control"
                        id="agama"
                        name="agama"
                        value="{{ old('agama', $user->agama) }}"
                        placeholder="{{ __('mobile.religion_placeholder') }}">

                    @error('agama')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

            </div>


            {{-- ADDRESS --}}

            <div class="d-flex justify-content-between align-items-end mt-4">
                <h3 class="h5 fw-semibold mb-0">{{ __('mobile.address') }}</h3>
            </div>

            <div class="app-card overflow-hidden gap-3 p-4 mt-3">

                <div>

                    <label
                        for="alamat"
                        class="form-label small fw-semibold">{{ __('mobile.address') }}</label>

                    <textarea
                        class="form-control"
                        id="alamat"
                        name="alamat"
                        rows="4"
                        placeholder="{{ __('mobile.address_placeholder') }}">{{ old('alamat', $user->alamat) }}</textarea>

                    @error('alamat')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

            </div>


            {{-- SOCIAL MEDIA --}}
            <div class="d-flex justify-content-between align-items-end mt-4">
                <h3 class="h5 fw-semibold mb-0">{{ __('mobile.social_media') }}</h3>
            </div>

            <div class="app-card overflow-hidden gap-3 p-4 mt-3">

                {{-- INSTAGRAM --}}
                <div class="mb-3">

                    <label
                        for="instagram"
                        class="form-label small fw-semibold">Instagram</label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-instagram text-sage"></i>
                        </span>

                        <input
                            type="url"
                            class="form-control"
                            id="instagram"
                            name="instagram"
                            value="{{ old('instagram', $user->instagram) }}"
                            placeholder="https://instagram.com/...">

                    </div>

                    @error('instagram')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- FACEBOOK --}}
                <div class="mb-3">

                    <label
                        for="facebook"
                        class="form-label small fw-semibold">
                        Facebook
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-facebook text-sage"></i>
                        </span>

                        <input
                            type="url"
                            class="form-control"
                            id="facebook"
                            name="facebook"
                            value="{{ old('facebook', $user->facebook) }}"
                            placeholder="https://facebook.com/...">

                    </div>

                    @error('facebook')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                {{-- TIKTOK --}}
                <div class="mb-3">

                    <label
                        for="tiktok"
                        class="form-label small fw-semibold">
                        TikTok
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-tiktok text-sage"></i>
                        </span>

                        <input
                            type="url"
                            class="form-control"
                            id="tiktok"
                            name="tiktok"
                            value="{{ old('tiktok', $user->tiktok) }}"
                            placeholder="https://tiktok.com/@...">

                    </div>

                    @error('tiktok')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- YOUTUBE --}}
                <div>

                    <label
                        for="youtube"
                        class="form-label small fw-semibold">
                        YouTube
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-youtube text-sage"></i>
                        </span>

                        <input
                            type="url"
                            class="form-control"
                            id="youtube"
                            name="youtube"
                            value="{{ old('youtube', $user->youtube) }}"
                            placeholder="https://youtube.com/...">

                    </div>

                    @error('youtube')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

            </div>


            {{-- ACTION --}}
            <div class="text-center mt-4">

                <button
                    type="submit"
                    class="btn btn-warm w-100 py-2">

                    <i class="bi bi-check2 me-1"></i>{{ __('mobile.save_changes') }}</button>

            </div>

        </form>

    </div>

</section>


{{-- AVATAR PREVIEW --}}
<script>
    document.getElementById('avatar')?.addEventListener('change', function(event) {

        const file = event.target.files[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        };

        reader.readAsDataURL(file);

    });
</script>

@endsection
