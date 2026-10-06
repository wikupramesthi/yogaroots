@extends('layouts.mobile')
@section('title', __('mobile.profile'))
@section('content')

<section
    class="screen {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
    id="profil">

    <div class="px-4 pt-4">

        {{-- Header --}}
        <p class="eyebrow mb-1">{{ __('mobile.my_account') }}</p>

        <h1 class="fw-semibold m-h1">{{ __('mobile.profile') }}</h1>

        {{-- ================================================= --}}
        {{-- PROFILE CARD --}}
        {{-- ================================================= --}}

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

            <div class="d-flex align-items-center gap-3">

                <img
                    src="{{ $avatar }}"
                    alt="{{ $user->name }}"
                    class="rounded-circle flex-shrink-0"
                    loading="lazy"
                    decoding="async"
                    style="
                        width:72px;
                        height:72px;
                        object-fit:cover;
                    ">

                <div class="flex-fill">

                    <h2 class="h5 fw-semibold mb-1">
                        {{ $user->name }}
                    </h2>

                    <p class="small text-muted2 mb-0">
                        {{ $user->email }}
                    </p>

                </div>

            </div>


            <a
                href="{{ route('account.index') }}"
                class="btn btn-warm w-100 py-2 mt-4">

                <i class="bi bi-pencil-square me-1"></i>{{ __('mobile.edit_profile') }}</a>

        </div>

        {{-- ================================================= --}}
        {{-- MY ORDERS --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">{{ __('mobile.my_orders') }}</h3>
            <a href="{{ route('orders.index') }}"
                class="btn btn-link p-0 text-terra fw-semibold text-small text-decoration-none">{{ __('mobile.view_all') }}</a>
        </div>

        <div class="app-card overflow-hidden gap-3 mt-3">

            @forelse ($orders as $order)

                @php
                    $badge = match ($order->status) {
                        'paid' => 'bg-success-subtle text-success',
                        'pending' => 'bg-warning-subtle text-warning',
                        'failed' => 'bg-danger-subtle text-danger',
                        default => 'bg-secondary-subtle text-secondary',
                    };
                @endphp

                <a href="{{ route('orders.show', $order->uuid) }}"
                    class="px-4 py-3 {{ !$loop->last ? 'border-bottom' : '' }} d-block text-decoration-none text-dark">

                    <div class="d-flex align-items-start gap-3">

                        <div
                            class="rounded-3 d-flex align-items-center justify-content-center bg-sage-soft text-sage flex-shrink-0"
                            style="width:42px;height:42px;">
                            <i class="bi {{ $order->type === 'package' ? 'bi-flower1' : 'bi-calendar-event' }}"></i>
                        </div>

                        <div class="flex-fill">

                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <p class="small fw-semibold mb-1">
                                        {{ $order->package?->name ?? 'Single Class' }}
                                        @if ($order->packageOption?->name)
                                            <small class="d-block text-muted2 fw-normal">{{ $order->packageOption->name }}</small>
                                        @endif
                                    </p>
                                    <p class="text-muted2 mb-0 m-meta">
                                        #{{ $order->order_number }}
                                    </p>
                                </div>

                                <span class="badge rounded-pill {{ $badge }}">
                                    {{ __('mobile.order_status.' . $order->status) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center gap-2 mt-2">
                                <p class="small text-muted2 mb-0">
                                    {{ $order->created_at?->format('d M Y') }}
                                </p>
                                <p class="small fw-semibold mb-0">
                                    Rp {{ number_format($order->amount, 0, ',', '.') }}
                                </p>
                            </div>

                        </div>

                    </div>

                </a>

            @empty

                <div class="px-4 py-4 text-center">
                    <i class="bi bi-bag-x text-muted2 fs-3"></i>
                    <p class="small fw-semibold mt-2 mb-0">{{ __('mobile.no_orders') }}</p>
                    <p class="text-muted2 mb-0 text-small">
                        {{ __('mobile.no_orders_desc') }}
                    </p>
                </div>

            @endforelse

        </div>

        {{-- ================================================= --}}
        {{-- MY BOOKINGS --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">{{ __('mobile.my_bookings') }}</h3>
            <a href="{{ route('bookings.my') }}"
                class="btn btn-link p-0 text-terra fw-semibold text-small text-decoration-none">{{ __('mobile.view_all') }}</a>
        </div>

        <div class="app-card overflow-hidden gap-3 mt-3">
            <a href="{{ route('bookings.my') }}"
                class="d-flex align-items-center gap-3 px-4 py-3 text-decoration-none text-dark">
                <i class="bi bi-calendar-check text-sage"></i>
                <div class="flex-fill">
                    <p class="small fw-semibold mb-0">{{ __('mobile.manage_bookings') }}</p>
                    <p class="mb-0 m-micro text-muted2">{{ __('mobile.manage_bookings_desc') }}</p>
                </div>
                <i class="bi bi-chevron-right text-muted2"></i>
            </a>
        </div>

        {{-- ================================================= --}}
        {{-- TEACHER --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">{{ __('mobile.teacher') }}</h3>
            <a href="{{ route('instruktur.mobile') }}"
                class="btn btn-link p-0 text-terra fw-semibold text-small text-decoration-none">{{ __('mobile.view_all') }}</a>
        </div>

        <div class="app-card overflow-hidden gap-3 mt-3">
            <a href="{{ route('instruktur.mobile') }}"
                class="d-flex align-items-center gap-3 px-4 py-3 text-decoration-none text-dark">
                <i class="bi bi-easel2 text-sage"></i>
                <div class="flex-fill">
                    <p class="small fw-semibold mb-0">{{ __('mobile.meet_teachers') }}</p>
                    <p class="mb-0 m-micro text-muted2">{{ __('mobile.meet_teachers_desc') }}</p>
                </div>
                <i class="bi bi-chevron-right text-muted2"></i>
            </a>
        </div>

        {{-- ================================================= --}}
        {{-- PERSONAL INFORMATION --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">{{ __('mobile.personal_info') }}</h3>
        </div>

        <div class="app-card overflow-hidden gap-3 mt-3">

            {{-- Name --}}
            <div
                class="
                    d-flex
                    align-items-center
                    gap-3
                    px-4
                    py-3
                    border-bottom
                ">

                <i class="bi bi-person text-sage"></i>

                <div class="flex-fill">

                    <p class="small text-muted2 mb-1">
                        {{ __('mobile.full_name') }}
                    </p>

                    <p class="small fw-medium mb-0">
                        {{ $user->name ?: '-' }}
                    </p>

                </div>

            </div>


            {{-- Email --}}

            <div
                class="
                    d-flex
                    align-items-center
                    gap-3
                    px-4
                    py-3
                    border-bottom
                ">

                <i class="bi bi-envelope text-sage"></i>

                <div class="flex-fill">

                    <p class="small text-muted2 mb-1">{{ __('mobile.email') }}</p>

                    <p class="small fw-medium mb-0">
                        {{ $user->email ?: '-' }}
                    </p>

                </div>

            </div>


            {{-- Phone --}}

            <div
                class="
                    d-flex
                    align-items-center
                    gap-3
                    px-4
                    py-3
                    border-bottom
                ">

                <i class="bi bi-phone text-sage"></i>

                <div class="flex-fill">

                    <p class="small text-muted2 mb-1">
                        {{ __('mobile.phone') }}
                    </p>

                    <p class="small fw-medium mb-0">
                        {{ $user->no_hp ?: '-' }}
                    </p>

                </div>

            </div>


            {{-- {{ __('mobile.birth_date') }} --}}

            <div
                class="
                    d-flex
                    align-items-center
                    gap-3
                    px-4
                    py-3
                    border-bottom
                ">

                <i class="bi bi-calendar3 text-sage"></i>

                <div class="flex-fill">

                    <p class="small text-muted2 mb-1">
                        {{ __('mobile.birth_date') }}
                    </p>

                    <p class="small fw-medium mb-0">

                        @if($user->tanggal_lahir)

                        {{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') }}

                        @else

                        -

                        @endif

                    </p>

                </div>

            </div>


            {{-- Gender --}}

            <div
                class="
                    d-flex
                    align-items-center
                    gap-3
                    px-4
                    py-3
                ">

                <i class="bi bi-person-vcard text-sage"></i>

                <div class="flex-fill">

                    <p class="small text-muted2 mb-1">
                        Gender
                    </p>

                    <p class="small fw-medium mb-0">

                        @if($user->jenis_kelamin === 'L')

                        Male

                        @elseif($user->jenis_kelamin === 'P')

                        Female

                        @else

                        -

                        @endif

                    </p>

                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- SOCIAL MEDIA --}}
        {{-- ================================================= --}}

        @if(
        $user->facebook ||
        $user->instagram ||
        $user->tiktok ||
        $user->youtube
        )

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">{{ __('mobile.social_media') }}</h3>
        </div>

        <div class="app-card overflow-hidden gap-3 mt-3">

            @if($user->instagram)
            <a
                href="{{ $user->instagram }}"
                target="_blank"
                rel="noopener noreferrer"
                class="text-decoration-none text-dark d-flex align-items-center gap-3 px-4 py-3 border-bottom">

                <i class="bi bi-instagram text-sage"></i>

                <span class="small fw-medium flex-fill">
                    Instagram
                </span>

                <i class="bi bi-box-arrow-up-right text-muted2"></i>

            </a>
            @endif


            @if($user->facebook)
            <a
                href="{{ $user->facebook }}"
                target="_blank"
                rel="noopener noreferrer"
                class="text-decoration-none text-dark d-flex align-items-center gap-3 px-4 py-3 border-bottom">

                <i class="bi bi-facebook text-sage"></i>

                <span class="small fw-medium flex-fill">
                    Facebook
                </span>

                <i class="bi bi-box-arrow-up-right text-muted2"></i>

            </a>
            @endif


            @if($user->tiktok)
            <a
                href="{{ $user->tiktok }}"
                target="_blank"
                rel="noopener noreferrer"
                class="text-decoration-none text-dark d-flex align-items-center gap-3 px-4 py-3 border-bottom">

                <i class="bi bi-tiktok text-sage"></i>

                <span class="small fw-medium flex-fill">
                    TikTok
                </span>

                <i class="bi bi-box-arrow-up-right text-muted2"></i>

            </a>
            @endif


            @if($user->youtube)
            <a
                href="{{ $user->youtube }}"
                target="_blank"
                rel="noopener noreferrer"
                class="text-decoration-none text-dark d-flex align-items-center gap-3 px-4 py-3">

                <i class="bi bi-youtube text-sage"></i>

                <span class="small fw-medium flex-fill">
                    YouTube
                </span>

                <i class="bi bi-box-arrow-up-right text-muted2"></i>

            </a>
            @endif

        </div>

        @endif

        {{-- ================================================= --}}
        {{-- ACCOUNT --}}
        {{-- ================================================= --}}


        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">{{ __('mobile.account') }}</h3>
        </div>

        <div class="app-card overflow-hidden gap-3 mt-3">

            {{-- My Membership --}}

            <a
                href="{{ route('memberships.index') }}"
                class="
        text-decoration-none
        text-dark
        d-flex
        align-items-center
        gap-3
        px-4
        py-3
        border-bottom
    ">
                <i class="bi bi-award text-sage"></i>

                <span class="small fw-medium flex-fill">{{ __('mobile.my_membership') }}</span>

                <i class="bi bi-chevron-right text-muted2"></i>
            </a>

            <a
                href="{{ route('orders.index') }}"
                class="
        text-decoration-none
        text-dark
        d-flex
        align-items-center
        gap-3
        px-4
        py-3
        border-bottom
    ">
                <i class="bi bi-receipt text-sage"></i>

                <span class="small fw-medium flex-fill">{{ __('mobile.my_orders') }}</span>

                <i class="bi bi-chevron-right text-muted2"></i>
            </a>

            <button
                type="button"
                id="pwa-install"
                class="
        d-none
        w-100
        text-start
        d-flex
        align-items-center
        gap-3
        px-4
        py-3
        border-bottom
        btn
    ">
                <i class="bi bi-phone-download text-sage"></i>

                <span class="small fw-medium flex-fill text-dark">
                    Install App
                </span>

                <i class="bi bi-chevron-right text-muted2"></i>
            </button>

            {{-- Change Password --}}

            <div
                class="
        text-decoration-none
        text-dark
        d-flex
        align-items-center
        gap-3
        px-4
        py-3
        border-bottom
    ">
                <i class="bi bi-translate text-sage"></i>

                <span class="small fw-medium flex-fill">
                    {{ __('mobile.language') }}
                </span>

                <span class="d-flex gap-1">
                    <a href="{{ route('locale', 'id') }}"
                        class="btn btn-sm rounded-pill px-3 {{ app()->getLocale() === 'id' ? 'btn-sage text-white' : 'btn-light border' }}">ID</a>
                    <a href="{{ route('locale', 'en') }}"
                        class="btn btn-sm rounded-pill px-3 {{ app()->getLocale() !== 'id' ? 'btn-sage text-white' : 'btn-light border' }}">EN</a>
                </span>
            </div>

            <a
                href="{{ route('packages.member') }}"
                class="
        text-decoration-none
        text-dark
        d-flex
        align-items-center
        gap-3
        px-4
        py-3
        border-bottom
    ">
                <i class="bi bi-box-seam text-sage"></i>

                <span class="small fw-medium flex-fill">{{ __('mobile.choose_package') }}</span>

                <i class="bi bi-chevron-right text-muted2"></i>
            </a>

            <a
                href="#"
                class="
        text-decoration-none
        text-dark
        d-flex
        align-items-center
        gap-3
        px-4
        py-3
        border-bottom
    "
                data-bs-toggle="modal"
                data-bs-target="#changePasswordModal">

                <i class="bi bi-shield-lock text-sage"></i>

                <span class="small fw-medium flex-fill">{{ __('mobile.change_password') }}</span>

                <i class="bi bi-chevron-right text-muted2"></i>

            </a>


            {{-- Logout --}}

            <form
                method="POST"
                action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="
                        btn
                        w-100
                        text-start
                        d-flex
                        align-items-center
                        gap-3
                        px-4
                        py-3
                    ">

                    <i class="bi bi-box-arrow-right text-danger"></i>

                    <span
                        class="
                            small
                            fw-medium
                            flex-fill
                            text-danger
                        ">{{ __('mobile.logout') }}</span>

                    <i class="bi bi-chevron-right text-muted2"></i>

                </button>

            </form>

        </div>

    </div>

</section>

{{-- CHANGE PASSWORD MODAL --}}
<div
    class="modal fade"
    id="changePasswordModal"
    tabindex="-1"
    aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            {{-- HEADER --}}
            <div class="modal-header border-0 px-4 pt-4 pb-2">
                <div>
                    <p class="eyebrow mb-1">{{ __('mobile.security') }}</p>

                    <h5
                        class="modal-title fw-semibold"
                        id="changePasswordModalLabel">{{ __('mobile.change_password') }}</h5>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            {{-- BODY --}}
            <div class="modal-body px-4 pb-4">

                <p class="small text-muted2 mb-4">
                    {{ __('mobile.change_password_desc') }}
                </p>

                <form
                    action="{{ route('password.update') }}"
                    method="POST">

                    @csrf
                    @method('PUT')

                    {{-- CURRENT PASSWORD --}}
                    <div class="mb-3">
                        <label
                            for="current_password"
                            class="form-label small fw-semibold">{{ __('mobile.current_password') }}</label>

                        <input
                            type="password"
                            class="form-control"
                            id="current_password"
                            name="current_password"
                            placeholder="{{ __('mobile.current_password_placeholder') }}"
                            required>
                    </div>

                    {{-- NEW PASSWORD --}}
                    <div class="mb-3">
                        <label
                            for="password"
                            class="form-label small fw-semibold">{{ __('mobile.new_password') }}</label>

                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="{{ __('mobile.new_password_placeholder') }}"
                            required>
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="mb-4">
                        <label
                            for="password_confirmation"
                            class="form-label small fw-semibold">{{ __('mobile.confirm_password') }}</label>

                        <input
                            type="password"
                            class="form-control"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="{{ __('mobile.confirm_password_placeholder') }}"
                            required>
                    </div>

                    {{-- ACTION --}}
                    <div class="d-flex gap-2">

                        <button
                            type="button"
                            class="btn btn-light border flex-fill"
                            data-bs-dismiss="modal">{{ __('mobile.cancel') }}</button>

                        <button
                            type="submit"
                            class="btn btn-warm flex-fill">{{ __('mobile.update_password') }}</button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection
