@extends('layouts.app')
@section('title', 'Checkout')
@section('content')

<div class="container-fluid package-checkout">

    {{-- Page Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">
                Complete your membership
            </h4>
            <p class="text-muted mb-0">
                Choose the option that works best for your practice.
            </p>
        </div>

        <a href="{{ route('packages.member') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>
    </div>


    <div class="row g-4">

        {{-- =====================================================
             LEFT
        ====================================================== --}}
        <div class="col-lg-8">

            {{-- Package Information --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-transparent border-0 pt-4 px-4">

                    <div class="d-flex justify-content-between align-items-start gap-3">

                        <div class="d-flex align-items-center gap-3">

                            <div class="package-section-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>

                            <div>
                                <h5 class="fw-bold mb-1">
                                    {{ $package->name }}
                                </h5>

                                <p class="text-muted small mb-0">
                                    Membership Package
                                </p>
                            </div>

                        </div>

                        @if ($package->is_popular)
                        <span class="popular-label">
                            <i class="bi bi-star-fill me-1"></i>
                            Popular
                        </span>
                        @endif

                    </div>

                </div>


                <div class="card-body px-4 pb-4">

                    @if ($package->description)
                    <p class="text-muted mb-0 package-description">
                        {{ $package->description }}
                    </p>
                    @endif

                </div>

            </div>


            {{-- Choose Option --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-transparent border-0 pt-4 px-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="package-section-icon">
                            <i class="bi bi-tags"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">
                                Choose your option
                            </h5>

                            <p class="text-muted small mb-0">
                                Select your preferred duration and class quota.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="card-body p-4">

                    <div class="membership-options">

                        @foreach ($package->options as $index => $option)

                        @php
                        $hasDiscount =
                        $option->discount_price !== null &&
                        $option->discount_price < $option->price;

                            $finalPrice = $hasDiscount
                            ? $option->discount_price
                            : $option->price;
                            @endphp

                            <button
                                type="button"
                                class="membership-option {{ $index === 0 ? 'selected' : '' }}"
                                data-option-uuid="{{ $option->uuid }}"
                                data-option-name="{{ $option->name }}"
                                data-option-price="{{ $finalPrice }}"
                                data-option-regular-price="{{ $option->price }}"
                                data-option-quota="{{ $option->quota ?? '' }}"
                                data-option-duration="{{ $option->duration }}"
                                data-option-duration-unit="{{ $option->duration_unit }}">

                                <div class="option-radio">
                                    <span></span>
                                </div>


                                <div class="option-main">

                                    <div class="d-flex justify-content-between align-items-start gap-3">

                                        <div>

                                            <h6 class="fw-bold mb-1">
                                                {{ $option->name }}
                                            </h6>

                                            <div class="option-meta">

                                                <span>
                                                    <i class="bi bi-calendar3"></i>
                                                    {{ $option->duration }}
                                                    {{ ucfirst($option->duration_unit) }}
                                                </span>

                                                <span>
                                                    <i class="bi bi-person-check"></i>

                                                    @if ($option->quota === null)
                                                    Unlimited Classes
                                                    @else
                                                    {{ $option->quota }} Classes
                                                    @endif
                                                </span>

                                            </div>

                                        </div>


                                        <div class="option-price-wrapper text-end">

                                            @if ($hasDiscount)
                                            <div class="option-old-price">
                                                Rp {{ number_format($option->price, 0, ',', '.') }}
                                            </div>
                                            @endif

                                            <div class="option-price">
                                                Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <div class="option-check">
                                    <i class="bi bi-check-lg"></i>
                                </div>

                            </button>

                            @endforeach

                    </div>

                </div>

            </div>


            {{-- Features --}}
            @if ($package->features->count())

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-transparent border-0 pt-4 px-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="package-section-icon">
                            <i class="bi bi-list-check"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">
                                What's included
                            </h5>

                            <p class="text-muted small mb-0">
                                Everything included in your membership.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="card-body p-4">

                    <div class="row g-3">

                        @foreach ($package->features as $feature)

                        <div class="col-md-6">

                            <div class="feature-item">

                                <div class="feature-icon">
                                    <i class="bi bi-check2"></i>
                                </div>

                                <span>
                                    {{ $feature->feature }}
                                </span>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>

            </div>

            @endif

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-transparent border-0 pt-4 px-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="package-section-icon">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">
                                Refund Policy
                            </h5>

                            <p class="text-muted small mb-0">
                                Please review before payment
                            </p>
                        </div>

                    </div>

                </div>

                <div class="card-body px-4 pb-4">

                    <p class="text-muted mb-3">
                        All payments are
                        <strong class="text-dark">final and non-refundable</strong>
                        once your purchase has been completed.
                    </p>

                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-check-circle-fill text-success mt-1"></i>

                        <p class="text-muted mb-0">
                            Class credits are
                            <strong class="text-dark">
                                non-transferable, non-extendable, and non-exchangeable.
                            </strong>
                        </p>
                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             RIGHT
        ====================================================== --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm checkout-summary">

                <div class="card-header bg-transparent border-0 pt-4 px-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="summary-icon">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">
                                Order Summary
                            </h5>

                            <p class="text-muted small mb-0">
                                Review your membership
                            </p>
                        </div>

                    </div>

                </div>


                <div class="card-body p-4">

                    {{-- Package --}}
                    <div class="summary-package">

                        <div class="summary-label">
                            MEMBERSHIP
                        </div>

                        <div class="summary-package-name">
                            {{ $package->name }}
                        </div>

                    </div>


                    {{-- Option --}}
                    <div class="summary-selected">

                        <div class="summary-label mb-1">
                            SELECTED OPTION
                        </div>

                        <div
                            id="summaryOptionName"
                            class="fw-bold">
                            {{ $package->options->first()?->name ?? '-' }}
                        </div>


                        <div class="summary-details">

                            <div class="summary-detail">

                                <span>
                                    <i class="bi bi-calendar3"></i>
                                    Duration
                                </span>

                                <strong id="summaryDuration">
                                    @if ($package->options->first())
                                    {{ $package->options->first()->duration }}
                                    {{ ucfirst($package->options->first()->duration_unit) }}
                                    @else
                                    -
                                    @endif
                                </strong>

                            </div>


                            <div class="summary-detail">

                                <span>
                                    <i class="bi bi-person-check"></i>
                                    Class Quota
                                </span>

                                <strong id="summaryQuota">

                                    @if ($package->options->first())

                                    @if ($package->options->first()->quota === null)
                                    Unlimited
                                    @else
                                    {{ $package->options->first()->quota }} Classes
                                    @endif

                                    @else
                                    -
                                    @endif

                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- Price --}}
                    <div class="summary-pricing">

                        <div class="d-flex justify-content-between align-items-end">

                            <span class="text-muted small">
                                Membership
                            </span>

                            <div class="text-end">

                                <div
                                    id="summaryOldPrice"
                                    class="summary-old-price">
                                </div>

                                <div
                                    id="summaryPrice"
                                    class="summary-price">
                                    @if ($package->options->first())

                                    @php
                                    $firstOption = $package->options->first();

                                    $firstHasDiscount =
                                    $firstOption->discount_price !== null &&
                                    $firstOption->discount_price < $firstOption->price;

                                        $firstFinalPrice = $firstHasDiscount
                                        ? $firstOption->discount_price
                                        : $firstOption->price;
                                        @endphp

                                        Rp {{ number_format($firstFinalPrice, 0, ',', '.') }}

                                        @else
                                        Rp 0
                                        @endif
                                </div>

                            </div>

                        </div>


                        <div class="summary-divider"></div>


                        <div class="d-flex justify-content-between align-items-end">

                            <span class="fw-bold">
                                Total
                            </span>

                            <strong
                                id="summaryTotal"
                                class="summary-total">

                                @if ($package->options->first())
                                Rp {{ number_format($firstFinalPrice, 0, ',', '.') }}
                                @else
                                Rp 0
                                @endif

                            </strong>

                        </div>

                    </div>


                    {{-- CTA --}}

                    <form
                        action="{{ route('orders.store') }}"
                        method="POST"
                        id="checkoutForm">
                        @csrf

                        <input
                            type="hidden"
                            name="type"
                            value="package">

                        <input
                            type="hidden"
                            name="package_option_uuid"
                            id="packageOptionUuid">

                        <button
                            type="submit"
                            id="continuePayment"
                            class="btn btn-primary w-100 continue-payment">
                            Continue to Payment
                            <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </form>

                    <p class="text-muted text-center small mb-0 mt-3">
                        You will review your order before payment.
                    </p>

                </div>

            </div>


            {{-- Secure Checkout --}}
            <div class="secure-checkout">

                <div class="secure-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div>
                    <div class="fw-semibold small">
                        Secure checkout
                    </div>

                    <div class="text-muted">
                        Your payment information is handled securely.
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>


<style>
    /* =========================================================
   CHECKOUT
========================================================= */

    .package-checkout {
        padding-bottom: 40px;
    }


    /* =========================================================
   SECTION ICON
========================================================= */

    .package-section-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(75, 107, 82, .08);
        color: var(--bs-primary);

        font-size: 17px;
        flex-shrink: 0;
    }


    /* =========================================================
   PACKAGE
========================================================= */

    .package-description {
        font-size: 14px;
        line-height: 1.7;
        max-width: 850px;
    }


    .popular-label {
        display: inline-flex;
        align-items: center;

        padding: 7px 11px;

        border-radius: 999px;

        background: rgba(196, 112, 60, .10);
        color: #c4703c;

        font-size: 11px;
        font-weight: 700;

        white-space: nowrap;
    }


    /* =========================================================
   OPTIONS
========================================================= */

    .membership-options {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }


    .membership-option {
        width: 100%;

        position: relative;

        display: flex;
        align-items: center;

        gap: 15px;

        padding: 18px;

        border: 1px solid var(--bs-border-color);
        border-radius: 12px;

        background: var(--bs-body-bg);
        color: inherit;

        text-align: left;

        cursor: pointer;

        transition:
            border-color .2s ease,
            background .2s ease,
            box-shadow .2s ease,
            transform .2s ease;
    }


    .membership-option:hover {
        border-color: rgba(75, 107, 82, .45);
        transform: translateY(-1px);
    }


    .membership-option.selected {
        border-color: var(--bs-primary);
        background: rgba(75, 107, 82, .035);
        box-shadow: 0 0 0 3px rgba(75, 107, 82, .07);
    }


    .option-radio {
        width: 20px;
        height: 20px;

        border: 2px solid var(--bs-border-color);
        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;
    }


    .membership-option.selected .option-radio {
        border-color: var(--bs-primary);
    }

    .bi-check-lg {
        width: auto;
        height: auto;
    }


    .membership-option.selected .option-radio span {
        width: 10px;
        height: 10px;

        border-radius: 50%;

        background: var(--bs-primary);
    }


    .option-main {
        flex: 1;
        min-width: 0;
    }


    .option-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;

        margin-top: 7px;

        color: var(--bs-secondary-color);
        font-size: 12px;
    }


    .option-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }


    .option-meta i {
        font-size: 13px;
    }


    .option-price-wrapper {
        padding-right: 22px;
    }


    .option-price {
        color: #c4703c;
        font-size: 19px;
        font-weight: 800;
        white-space: nowrap;
    }


    .option-old-price {
        color: var(--bs-secondary-color);
        font-size: 11px;
        text-decoration: line-through;
    }


    .option-check {
        position: absolute;

        top: 12px;
        right: 12px;

        width: 21px;
        height: 21px;

        border-radius: 50%;

        display: none;
        align-items: center;
        justify-content: center;

        background: var(--bs-primary);
        color: #fff;

        font-size: 11px;
    }


    .membership-option.selected .option-check {
        display: flex;
    }


    /* =========================================================
   FEATURES
========================================================= */

    .feature-item {
        min-height: 42px;

        display: flex;
        align-items: center;

        gap: 10px;

        padding: 9px 12px;

        border-radius: 10px;

        background: var(--bs-tertiary-bg);

        font-size: 13px;
    }


    .feature-icon {
        width: 24px;
        height: 24px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 50%;

        background: rgba(75, 107, 82, .10);
        color: var(--bs-primary);

        font-size: 13px;
    }


    /* =========================================================
   SUMMARY
========================================================= */

    .checkout-summary {
        position: sticky;
        top: 20px;
    }


    .summary-icon {
        width: 40px;
        height: 40px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: rgba(196, 112, 60, .10);
        color: #c4703c;

        font-size: 17px;
    }


    .summary-label {
        color: var(--bs-secondary-color);

        font-size: 10px;
        font-weight: 800;

        letter-spacing: .08em;
    }


    .summary-package {
        padding-bottom: 18px;

        border-bottom: 1px solid var(--bs-border-color);
    }


    .summary-package-name {
        margin-top: 4px;

        font-size: 18px;
        font-weight: 800;
    }


    .summary-selected {
        margin-top: 18px;

        padding: 15px;

        border-radius: 11px;

        background: var(--bs-tertiary-bg);
    }


    .summary-details {
        margin-top: 13px;

        padding-top: 12px;

        border-top: 1px solid var(--bs-border-color);
    }


    .summary-detail {
        display: flex;
        justify-content: space-between;
        align-items: center;

        gap: 12px;

        margin-bottom: 9px;

        font-size: 12px;
    }


    .summary-detail:last-child {
        margin-bottom: 0;
    }


    .summary-detail span {
        display: flex;
        align-items: center;
        gap: 6px;

        color: var(--bs-secondary-color);
    }


    .summary-pricing {
        padding: 20px 0;
    }


    .summary-old-price {
        color: var(--bs-secondary-color);

        font-size: 11px;

        text-decoration: line-through;
    }


    .summary-price {
        color: #c4703c;

        font-size: 18px;
        font-weight: 800;
    }


    .summary-divider {
        height: 1px;

        margin: 17px 0;

        background: var(--bs-border-color);
    }


    .summary-total {
        color: var(--bs-primary);

        font-size: 24px;
        font-weight: 800;
    }


    .continue-payment {
        min-height: 48px;

        border-radius: 10px;

        font-weight: 700;
    }


    .secure-checkout {
        display: flex;
        align-items: flex-start;

        gap: 11px;

        margin-top: 14px;

        padding: 13px;

        border-radius: 11px;

        background: var(--bs-tertiary-bg);
    }


    .secure-icon {
        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 9px;

        background: rgba(75, 107, 82, .08);
        color: var(--bs-primary);
    }


    .secure-checkout .text-muted {
        font-size: 11px;
        line-height: 1.5;
    }


    /* =========================================================
   RESPONSIVE
========================================================= */

    @media (max-width: 991.98px) {

        .checkout-summary {
            position: static;
        }

    }


    @media (max-width: 767.98px) {

        .membership-option {
            align-items: flex-start;
        }

        .option-price-wrapper {
            padding-right: 18px;
        }

        .option-price {
            font-size: 17px;
        }

        .option-meta {
            gap: 8px;
            flex-direction: column;
        }

    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const options =
            document.querySelectorAll('.membership-option');

        const packageOptionUuid =
            document.getElementById('packageOptionUuid');

        const summaryOptionName =
            document.getElementById('summaryOptionName');

        const summaryDuration =
            document.getElementById('summaryDuration');

        const summaryQuota =
            document.getElementById('summaryQuota');

        const summaryPrice =
            document.getElementById('summaryPrice');

        const summaryTotal =
            document.getElementById('summaryTotal');

        const summaryOldPrice =
            document.getElementById('summaryOldPrice');

        const checkoutForm =
            document.getElementById('checkoutForm');


        /*
        |--------------------------------------------------------------------------
        | Format Rupiah
        |--------------------------------------------------------------------------
        */

        function formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }


        /*
        |--------------------------------------------------------------------------
        | Select Package Option
        |--------------------------------------------------------------------------
        */

        function selectOption(option) {

            /*
            |--------------------------------------------------------------------------
            | Remove Selected State
            |--------------------------------------------------------------------------
            */

            options.forEach(item => {
                item.classList.remove('selected');
            });


            /*
            |--------------------------------------------------------------------------
            | Add Selected State
            |--------------------------------------------------------------------------
            */

            option.classList.add('selected');


            /*
            |--------------------------------------------------------------------------
            | Set Package Option UUID
            |--------------------------------------------------------------------------
            */

            packageOptionUuid.value =
                option.dataset.optionUuid;


            /*
            |--------------------------------------------------------------------------
            | Get Option Data
            |--------------------------------------------------------------------------
            */

            const name =
                option.dataset.optionName;

            const price =
                Number(option.dataset.optionPrice);

            const regularPrice =
                Number(option.dataset.optionRegularPrice);

            const quota =
                option.dataset.optionQuota;

            const duration =
                option.dataset.optionDuration;

            const durationUnit =
                option.dataset.optionDurationUnit;


            /*
            |--------------------------------------------------------------------------
            | Update Option Name
            |--------------------------------------------------------------------------
            */

            summaryOptionName.textContent =
                name;


            /*
            |--------------------------------------------------------------------------
            | Update Duration
            |--------------------------------------------------------------------------
            */

            summaryDuration.textContent =
                `${duration} ${durationUnit}`;


            /*
            |--------------------------------------------------------------------------
            | Update Class Quota
            |--------------------------------------------------------------------------
            */

            summaryQuota.textContent =
                quota === '' ?
                'Unlimited' :
                `${quota} Classes`;


            /*
            |--------------------------------------------------------------------------
            | Update Price
            |--------------------------------------------------------------------------
            */

            summaryPrice.textContent =
                formatRupiah(price);


            /*
            |--------------------------------------------------------------------------
            | Update Total
            |--------------------------------------------------------------------------
            */

            summaryTotal.textContent =
                formatRupiah(price);


            /*
            |--------------------------------------------------------------------------
            | Update Old Price
            |--------------------------------------------------------------------------
            */

            if (regularPrice > price) {

                summaryOldPrice.textContent =
                    formatRupiah(regularPrice);

            } else {

                summaryOldPrice.textContent =
                    '';

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Click Package Option
        |--------------------------------------------------------------------------
        */

        options.forEach(option => {

            option.addEventListener('click', function() {

                selectOption(this);

            });

        });


        /*
        |--------------------------------------------------------------------------
        | Select First Option
        |--------------------------------------------------------------------------
        */

        if (options.length) {

            const defaultOption =
                document.querySelector(
                    '.membership-option.selected'
                ) || options[0];

            selectOption(defaultOption);
        }


        /*
        |--------------------------------------------------------------------------
        | Submit Checkout
        |--------------------------------------------------------------------------
        */

        if (checkoutForm) {

            checkoutForm.addEventListener(
                'submit',
                function(event) {

                    const selected =
                        document.querySelector(
                            '.membership-option.selected'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Validate Selected Option
                    |--------------------------------------------------------------------------
                    */

                    if (!selected) {

                        event.preventDefault();

                        alert(
                            'Please select a package option.'
                        );

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Make Sure UUID Is Set
                    |--------------------------------------------------------------------------
                    */

                    packageOptionUuid.value =
                        selected.dataset.optionUuid;


                    /*
                    |--------------------------------------------------------------------------
                    | Debug
                    |--------------------------------------------------------------------------
                    */

                    console.log(
                        'Creating order for package option:',
                        packageOptionUuid.value
                    );

                }
            );

        }

    });
</script>

@endsection