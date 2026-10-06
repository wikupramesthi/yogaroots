@extends('layouts.mobile')
@section('title', 'Profile')
@section('content')

<section
    class="screen {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
    id="profil">

    <div class="px-4 pt-4">

        {{-- Header --}}
        <p class="eyebrow mb-1">My Account</p>

        <h1 class="fw-semibold m-h1">
            Profile
        </h1>

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

                <i class="bi bi-pencil-square me-1"></i>
                Edit Profile

            </a>

        </div>

        {{-- ================================================= --}}
        {{-- MY ORDERS --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">My Orders</h3>
            <a href="{{ route('orders.index') }}"
                class="btn btn-link p-0 text-terra fw-semibold text-small text-decoration-none">
                View all
            </a>
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
                                    {{ ucfirst($order->status) }}
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
                    <p class="small fw-semibold mt-2 mb-0">No orders yet</p>
                    <p class="text-muted2 mb-0 text-small">
                        Your membership orders will appear here.
                    </p>
                </div>

            @endforelse

        </div>

        {{-- ================================================= --}}
        {{-- MY BOOKINGS --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">My Bookings</h3>
            <a href="{{ route('bookings.my') }}"
                class="btn btn-link p-0 text-terra fw-semibold text-small text-decoration-none">
                View all
            </a>
        </div>

        <div class="app-card overflow-hidden gap-3 mt-3">
            <a href="{{ route('bookings.my') }}"
                class="d-flex align-items-center gap-3 px-4 py-3 text-decoration-none text-dark">
                <i class="bi bi-calendar-check text-sage"></i>
                <div class="flex-fill">
                    <p class="small fw-semibold mb-0">Manage your class bookings</p>
                    <p class="mb-0 m-micro text-muted2">Check-in, cancel, view past classes</p>
                </div>
                <i class="bi bi-chevron-right text-muted2"></i>
            </a>
        </div>

        {{-- ================================================= --}}
        {{-- PERSONAL INFORMATION --}}
        {{-- ================================================= --}}

        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">Personal Information</h3>
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
                        Full Name
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

                    <p class="small text-muted2 mb-1">
                        Email
                    </p>

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
                        Phone Number
                    </p>

                    <p class="small fw-medium mb-0">
                        {{ $user->no_hp ?: '-' }}
                    </p>

                </div>

            </div>


            {{-- Date of Birth --}}

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
                        Date of Birth
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
            <h3 class="h5 fw-semibold mb-0">Social Media</h3>
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
            <h3 class="h5 fw-semibold mb-0">Account</h3>
        </div>

        <div class="app-card overflow-hidden gap-3 mt-3">

            {{-- Change Password --}}

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

                <span class="small fw-medium flex-fill">
                    Choose Package
                </span>

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

                <span class="small fw-medium flex-fill">
                    Change Password
                </span>

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
                        ">
                        Logout
                    </span>

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
                    <p class="eyebrow mb-1">Security</p>

                    <h5
                        class="modal-title fw-semibold"
                        id="changePasswordModalLabel">
                        Change Password
                    </h5>
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
                    Update your password to keep your account secure.
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
                            class="form-label small fw-semibold">
                            Current Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="current_password"
                            name="current_password"
                            placeholder="Enter current password"
                            required>
                    </div>

                    {{-- NEW PASSWORD --}}
                    <div class="mb-3">
                        <label
                            for="password"
                            class="form-label small fw-semibold">
                            New Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="Enter new password"
                            required>
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="mb-4">
                        <label
                            for="password_confirmation"
                            class="form-label small fw-semibold">
                            Confirm New Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Confirm new password"
                            required>
                    </div>

                    {{-- ACTION --}}
                    <div class="d-flex gap-2">

                        <button
                            type="button"
                            class="btn btn-light border flex-fill"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="btn btn-warm flex-fill">
                            Update Password
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection
