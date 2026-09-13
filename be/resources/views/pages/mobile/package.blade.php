@extends('layouts.mobile')

@section('title', 'Membership')

@section('content')

<style>
    .mobile-membership {
        padding: 18px 16px 100px;
        background: var(--bg, #faf8f2);
        min-height: 100vh;
    }

    .membership-top {
        margin-bottom: 20px;
    }

    .membership-note {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 14px;
        padding: 10px 12px;
        border-radius: 12px;
        background: rgba(107, 143, 111, .08);
        color: #5d745f;
        font-size: 11px;
        font-weight: 600;
    }

    .membership-note i {
        font-size: 14px;
    }

    /* FILTER */

    .mobile-package-filter {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 4px;
        margin-bottom: 18px;
        scrollbar-width: none;
    }

    .mobile-package-filter::-webkit-scrollbar {
        display: none;
    }

    .mobile-filter-btn {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 13px;
        border-radius: 30px;
        border: 1px solid #e7e3d9;
        background: #fffdf8;
        color: #737a70;
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
        transition: .2s ease;
    }

    .mobile-filter-btn.active {
        background: var(--fg, #31392f);
        border-color: var(--fg, #31392f);
        color: #fff;
    }

    /* CARD */

    .mobile-package-card {
        position: relative;
        background: var(--card, #fffdf8);
        border: 1px solid #ebe7dd;
        border-radius: 22px;
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: 0 8px 25px rgba(49, 57, 47, .05);
        overflow: hidden;
    }

    .mobile-package-card.popular {
        border-color: #8b6fa8;
        box-shadow: 0 10px 28px rgba(91, 67, 112, .12);
    }

    .popular-label {
        position: absolute;
        top: 0;
        right: 0;
        padding: 7px 13px;
        border-radius: 0 0 0 13px;
        background: #74558e;
        color: #fff;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .08em;
    }

    .package-card-header {
        padding-right: 55px;
    }

    .package-name {
        font-family: "Cormorant Garamond", serif;
        font-size: 27px;
        line-height: 1.05;
        font-weight: 600;
        color: var(--fg, #31392f);
        margin-bottom: 7px;
    }

    .package-description {
        font-size: 12px;
        line-height: 1.6;
        color: #7d857b;
    }

    /* PRICE */

    .package-price-box {
        margin-top: 17px;
        padding: 14px 15px;
        border-radius: 15px;
        background: rgba(107, 143, 111, .07);
        border: 1px solid rgba(107, 143, 111, .10);
    }

    .package-price-label {
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: .1em;
        font-weight: 700;
        color: #7c877b;
        margin-bottom: 3px;
    }

    .package-price span {
        color: #9b9f97;
        font-size: 16px;
        margin: 0 2px;
    }

    /* OPTIONS */

    .options-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 19px 0 10px;
    }

    .options-heading span:first-child {
        font-size: 11px;
        font-weight: 800;
        color: var(--fg, #31392f);
    }

    .options-heading span:last-child {
        font-size: 10px;
        color: #9a9e96;
    }

    .package-option {
        padding: 13px;
        border: 1px solid #e9e5db;
        border-radius: 14px;
        background: #fff;
        margin-bottom: 8px;
    }

    .option-name {
        font-size: 12px;
        font-weight: 700;
        color: var(--fg, #31392f);
        margin-bottom: 8px;
    }

    .option-info {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .option-info span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 8px;
        border-radius: 8px;
        background: #f7f5ef;
        color: #737a70;
        font-size: 9px;
        font-weight: 600;
    }

    .option-info i {
        font-size: 10px;
    }

    /* FEATURES */

    .features-heading {
        font-size: 11px;
        font-weight: 800;
        color: var(--fg, #31392f);
        margin: 19px 0 9px;
    }

    .package-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .package-features li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 7px;
        color: #6f766c;
        font-size: 11px;
        line-height: 1.4;
    }

    .package-features i {
        color: var(--sage, #6b8f6f);
        font-size: 12px;
        margin-top: 1px;
    }

    /* BUTTON */

    .choose-package {
        width: 100%;
        border: 0;
        border-radius: 13px;
        padding: 12px 15px;
        margin-top: 17px;
        background: var(--fg, #31392f);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        transition: .2s ease;
    }

    .choose-package:active {
        transform: scale(.98);
    }

    .choose-package i {
        margin-left: 5px;
    }

    .package-empty {
        text-align: center;
        padding: 45px 20px;
        background: var(--card, #fffdf8);
        border: 1px solid #ebe7dd;
        border-radius: 20px;
    }

    .package-empty i {
        font-size: 30px;
        color: #a1a69e;
        margin-bottom: 10px;
    }

    .package-empty h6 {
        font-weight: 700;
        color: var(--fg, #31392f);
        margin-bottom: 5px;
    }

    .package-empty p {
        font-size: 11px;
        color: #858b82;
        margin: 0;
    }

    @media (min-width: 500px) {
        .mobile-membership {
            max-width: 430px;
            margin: 0 auto;
        }
    }
</style>


<div class="mobile-membership">

    {{-- HEADER --}}
    <div class="membership-top">

        {{-- Header --}}
        <p class="eyebrow mb-1">Membership</p>

        <h1 class="fw-semibold" style="font-size: 28px">
            Your yoga journey starts here.
        </h1>

        <div class="membership-note">
            <i class="bi bi-stars"></i>
            <span>All packages can be used for Yogaroots classes</span>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="mobile-package-filter">

        <a href="{{ route('packages.member') }}"
            class="mobile-filter-btn {{ !request('filter') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            All
        </a>

        <a href="{{ route('packages.member', [
                'filter' => 'popular',
                'sort' => request('sort')
            ]) }}"
            class="mobile-filter-btn {{ request('filter') === 'popular' ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i>
            Popular
        </a>

        @if (request('filter') === 'unlimited')
        <a href="{{ route('packages.member.mobile', [
                    'filter' => 'unlimited',
                    'sort' => request('sort')
                ]) }}"
            class="mobile-filter-btn active">
            <i class="bi bi-infinity"></i>
            Unlimited
        </a>
        @endif

    </div>


    {{-- PACKAGES --}}
    @forelse ($packages as $package)

    @php

    $isPopular = $package->is_popular;

    $prices = $package->options->map(function ($option) {
    return $option->discount_price ?? $option->price;
    });

    $minPrice = $prices->min();
    $maxPrice = $prices->max();

    @endphp


    <div class="mobile-package-card {{ $isPopular ? 'popular' : '' }}">

        {{-- POPULAR --}}
        @if ($isPopular)

        <div class="popular-label">
            POPULAR
        </div>

        @endif


        {{-- HEADER --}}
        <div class="package-card-header">

            <div class="package-name">
                {{ $package->name }}
            </div>

            <div class="package-description">
                {{ $package->description ?: 'Start your yoga journey with Yogaroots.' }}
            </div>

        </div>


        {{-- PRICE RANGE --}}
        <div class="package-price-box">

            <div class="package-price-label">
                Membership from
            </div>

            @php
            $regularPrices = $package->options->pluck('price');

            $finalPrices = $package->options->map(function ($option) {
            return $option->discount_price !== null
            && $option->discount_price < $option->price
                ? $option->discount_price
                : $option->price;
                });

                $minRegular = $regularPrices->min();
                $maxRegular = $regularPrices->max();

                $minFinal = $finalPrices->min();
                $maxFinal = $finalPrices->max();

                $hasDiscount = $package->options->contains(function ($option) {
                return $option->discount_price !== null
                && $option->discount_price < $option->price;
                    });
                    @endphp

                    <div class="package-price-box">

                        @if ($hasDiscount)
                        <div class="package-price-badge">
                            SPECIAL PRICE
                        </div>

                        <div class="package-old-price">
                            Rp {{ number_format($minRegular, 0, ',', '.') }}

                            @if ($minRegular !== $maxRegular)
                            - Rp {{ number_format($maxRegular, 0, ',', '.') }}
                            @endif
                        </div>
                        @endif

                        <div class="package-price">
                            Rp {{ number_format($minFinal, 0, ',', '.') }}

                            @if ($minFinal !== $maxFinal)
                            <span>-</span>
                            Rp {{ number_format($maxFinal, 0, ',', '.') }}
                            @endif
                        </div>

                    </div>

        </div>


        {{-- OPTIONS --}}
        @if ($package->options->count())

        <div class="options-heading">

            <span>
                Membership Options
            </span>

            <span>
                {{ $package->options->count() }}
                {{ $package->options->count() > 1 ? 'options' : 'option' }}
            </span>

        </div>


        @foreach ($package->options as $option)

        @php
        $hasDiscount =
        !is_null($option->discount_price) &&
        $option->discount_price < $option->price;

            $finalPrice =
            $option->discount_price ?? $option->price;
            @endphp

            <div class="package-option">

                <div class="option-name">
                    {{ $option->name }}
                </div>

                <div class="option-info">

                    <span>
                        <i class="bi bi-wallet2"></i>

                        Rp {{ number_format($finalPrice, 0, ',', '.') }}
                    </span>

                    @if ($option->quota === null)

                    <span>
                        <i class="bi bi-infinity"></i>
                        Unlimited
                    </span>

                    @else

                    <span>
                        <i class="bi bi-calendar-check"></i>
                        {{ $option->name }}
                    </span>

                    @endif

                    <span>
                        <i class="bi bi-clock"></i>

                        {{ $option->duration }}
                        {{ ucfirst($option->duration_unit) }}
                    </span>

                </div>

            </div>

            @endforeach

            @endif


            {{-- FEATURES --}}
            <div class="features-heading">
                What's included
            </div>

            <ul class="package-features">

                @forelse ($package->features as $feature)

                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    <span>
                        {{ $feature->feature }}
                    </span>
                </li>

                @empty

                <li>
                    <i class="bi bi-check-circle-fill"></i>
                    <span>
                        Access to Yogaroots classes
                    </span>
                </li>

                @endforelse

            </ul>


            {{-- CTA --}}
            <button
                type="button"
                class="choose-package"
                onclick="window.location.href='{{ route('checkout.package', $package->uuid) }}'">

                Choose Package
                <i class="bi bi-arrow-right"></i>

            </button>

    </div>

    @empty

    <div class="package-empty">

        <i class="bi bi-box-seam"></i>

        <h6>
            No Packages Available
        </h6>

        <p>
            Membership packages are currently unavailable.
        </p>

    </div>

    @endforelse

</div>


<script>
    function choosePackage(uuid) {
        window.location.href = '/packages/' + uuid + '/checkout';
    }
</script>

@endsection