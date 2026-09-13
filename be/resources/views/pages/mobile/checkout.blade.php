@extends('layouts.mobile')

@section('title', 'Checkout')

@section('content')

<section class="screen active" id="checkout">

    <div class="px-4 pt-4">

        {{-- HEADER --}}
        <div class="mb-4">

            <a
                href="{{ route('packages.member') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center mb-3">

                <i class="bi bi-arrow-left fs-5"></i>

            </a>

            <p class="eyebrow mb-1">
                Membership
            </p>

            <h1
                class="fw-semibold"
                style="font-size:28px">
                Checkout Package
            </h1>

        </div>


        {{-- =====================================================
             PACKAGE
        ====================================================== --}}

        <div class="app-card p-4 mb-4">

            <div class="d-flex align-items-start gap-3">

                <div
                    class="rounded-3 bg-sage-soft text-sage d-flex align-items-center justify-content-center flex-shrink-0"
                    style="width:46px;height:46px">

                    <i class="bi bi-box-seam"></i>

                </div>


                <div class="flex-fill">

                    <h2 class="h5 fw-semibold mb-1">
                        {{ $package->name }}
                    </h2>

                    @if($package->description)
                    <p class="small text-muted2 mb-0"
                        style="line-height:1.6">
                        {{ $package->description }}
                    </p>
                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
             CHOOSE OPTION
        ====================================================== --}}

        <div class="d-flex justify-content-between align-items-end mb-2">

            <div>
                <h3 class="h5 fw-semibold mb-1">
                    Choose your option
                </h3>

                <p class="small text-muted2 mb-0">
                    Select the option that suits your practice.
                </p>
            </div>

        </div>


        <div class="d-flex flex-column gap-2 mt-3">

            @foreach($package->options as $index => $option)

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
                    class="package-option {{ $index === 0 ? 'selected' : '' }}"
                    data-option-uuid="{{ $option->uuid }}"
                    data-option-name="{{ $option->name }}"
                    data-option-price="{{ $finalPrice }}"
                    data-option-regular-price="{{ $option->price }}"
                    data-option-quota="{{ $option->quota ?? '' }}"
                    data-option-duration="{{ $option->duration }}"
                    data-option-duration-unit="{{ $option->duration_unit }}">

                    <div class="d-flex align-items-start gap-3">

                        {{-- RADIO --}}
                        <div class="option-radio flex-shrink-0">
                            <span></span>
                        </div>


                        <div class="flex-fill">

                            <div class="d-flex justify-content-between align-items-start gap-2">

                                <div>

                                    <p class="small fw-semibold mb-1">
                                        {{ $option->name }}
                                    </p>

                                    <div class="option-meta">

                                        <span>
                                            <i class="bi bi-calendar3"></i>

                                            {{ $option->duration }}
                                            {{ ucfirst($option->duration_unit) }}
                                        </span>

                                        <span>
                                            <i class="bi bi-person-check"></i>

                                            @if($option->quota === null)
                                            Unlimited
                                            @else
                                            {{ $option->quota }} Classes
                                            @endif
                                        </span>

                                    </div>

                                </div>


                                <div class="text-end">

                                    @if($hasDiscount)

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

                    </div>

                </button>

                @endforeach

        </div>


        {{-- =====================================================
             INCLUDED
        ====================================================== --}}

        @if($package->features->count())

        <div class="d-flex justify-content-between align-items-end mt-4 mb-2">

            <div>
                <h3 class="h5 fw-semibold mb-1">
                    What's included
                </h3>

                <p class="small text-muted2 mb-0">
                    Your membership benefits.
                </p>
            </div>

        </div>


        <div class="app-card overflow-hidden mt-3 mb-4">

            @foreach($package->features as $index => $feature)

            <div
                class="d-flex align-items-center gap-3 px-4 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">

                <div class="feature-check">
                    <i class="bi bi-check2"></i>
                </div>

                <span class="small">
                    {{ $feature->feature }}
                </span>

            </div>

            @endforeach

        </div>

        @endif

        <div class="mt-4 mb-2">

            <h3 class="h5 fw-semibold mb-1">
                Refund Policy
            </h3>

            <p class="small text-muted2 mb-0">
                Please review before payment.
            </p>

        </div>

        <div class="app-card p-4 mb-4">

            <p class="small text-muted2 mb-3">
                All payments are
                <strong class="text-dark">
                    final and non-refundable
                </strong>
                once your purchase is completed.
            </p>

            <p class="small text-muted2 mb-0">
                Class credits are
                <strong class="text-dark">
                    non-transferable, non-extendable, and non-exchangeable.
                </strong>
            </p>

        </div>


        {{-- =====================================================
             BOTTOM SPACE
        ====================================================== --}}

        <div style="height:100px"></div>

    </div>


    {{-- =========================================================
         BOTTOM CHECKOUT BAR
    ========================================================== --}}

    <div class="checkout-bottom-bar">

        <div class="d-flex align-items-center gap-3">

            <div class="flex-fill">

                <p class="mb-1 text-muted2"
                    style="font-size:9px;letter-spacing:.08em">
                    TOTAL
                </p>

                <div
                    id="summaryPrice"
                    class="summary-price">

                    @if($package->options->first())

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

                <div
                    id="summaryOption"
                    class="summary-option">

                    {{ $package->options->first()?->name ?? '-' }}

                </div>

            </div>


            <button
                type="button"
                id="continuePayment"
                class="btn btn-warm checkout-button">

                Continue

                <i class="bi bi-arrow-right ms-1"></i>

            </button>

        </div>

    </div>

</section>


<style>
    /* =========================================================
   CHECKOUT MOBILE
========================================================= */

    #checkout {
        background: var(--bg, #faf8f2);
    }


    /* =========================================================
   PACKAGE OPTION
========================================================= */

    .package-option {

        position: relative;

        width: 100%;

        border: 1px solid rgba(75, 107, 82, .10);

        border-radius: 14px;

        padding: 15px;

        background: var(--card, #fffdf8);

        color: var(--fg, #31392f);

        text-align: left;

        cursor: pointer;

        transition:
            border-color .2s ease,
            box-shadow .2s ease,
            background .2s ease;

    }


    .package-option.selected {

        border-color: #4b6b52;

        background: rgba(75, 107, 82, .035);

        box-shadow:
            0 0 0 2px rgba(75, 107, 82, .07);

    }


    /* =========================================================
   RADIO
========================================================= */

    .option-radio {

        width: 19px;
        height: 19px;

        margin-top: 1px;

        border: 2px solid #cfd5cd;

        border-radius: 50%;

        display: flex;

        align-items: center;
        justify-content: center;

    }


    .package-option.selected .option-radio {

        border-color: #4b6b52;

    }


    .package-option.selected .option-radio span {

        width: 9px;
        height: 9px;

        border-radius: 50%;

        background: #4b6b52;

    }


    /* =========================================================
   OPTION PRICE
========================================================= */

    .option-price {

        color: #c4703c;

        font-size: 15px;

        font-weight: 800;

        white-space: nowrap;

    }


    .option-old-price {

        color: #999;

        font-size: 9px;

        text-decoration: line-through;

    }


    .option-meta {

        display: flex;

        flex-wrap: wrap;

        gap: 9px;

        color: #858d83;

        font-size: 9px;

    }


    .option-meta span {

        display: inline-flex;

        align-items: center;

        gap: 4px;

    }


    .option-meta i {

        font-size: 10px;

    }


    /* =========================================================
   CHECK ICON
========================================================= */

    .option-check {

        position: absolute;

        top: 10px;
        right: 10px;

        width: 20px;
        height: 20px;

        display: none;

        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: #4b6b52;

        color: #fff;

        font-size: 10px;

    }


    .package-option.selected .option-check {

        display: flex;

    }


    /* =========================================================
   FEATURES
========================================================= */

    .feature-check {

        width: 23px;
        height: 23px;

        flex-shrink: 0;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: rgba(75, 107, 82, .09);

        color: #4b6b52;

        font-size: 12px;

    }


    /* =========================================================
   BOTTOM BAR
========================================================= */

    .checkout-bottom-bar {

        position: fixed;

        left: 50%;

        bottom: 0;

        width: 100%;

        max-width: 430px;

        transform: translateX(-50%);

        padding: 12px 16px;

        background: rgba(255, 253, 248, .96);

        border-top: 1px solid rgba(75, 107, 82, .10);

        box-shadow:
            0 -6px 25px rgba(0, 0, 0, .06);

        backdrop-filter: blur(12px);

        z-index: 1000;

    }


    .summary-price {

        color: #c4703c;

        font-size: 18px;

        font-weight: 800;

        line-height: 1.2;

    }


    .summary-option {

        overflow: hidden;

        margin-top: 2px;

        color: #858d83;

        font-size: 9px;

        text-overflow: ellipsis;

        white-space: nowrap;

    }


    .checkout-button {

        min-width: 118px;

        min-height: 44px;

        border-radius: 11px;

        font-size: 12px;

        font-weight: 700;

    }


    /* =========================================================
   SMALL SCREEN
========================================================= */

    @media (max-width: 360px) {

        .package-option {

            padding: 13px;

        }

        .option-price {

            font-size: 14px;

        }

        .checkout-button {

            min-width: 105px;

        }

    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const options =
            document.querySelectorAll('.package-option');

        const summaryPrice =
            document.getElementById('summaryPrice');

        const summaryOption =
            document.getElementById('summaryOption');

        const continuePayment =
            document.getElementById('continuePayment');


        function formatRupiah(value) {

            return 'Rp ' +
                Number(value).toLocaleString('id-ID');

        }


        function selectOption(option) {

            options.forEach(item => {

                item.classList.remove('selected');

            });


            option.classList.add('selected');


            const price =
                Number(option.dataset.optionPrice);

            const name =
                option.dataset.optionName;


            summaryPrice.textContent =
                formatRupiah(price);

            summaryOption.textContent =
                name;

        }


        options.forEach(option => {

            option.addEventListener('click', function() {

                selectOption(this);

            });

        });


        if (options.length) {

            selectOption(
                document.querySelector('.package-option.selected') ||
                options[0]
            );

        }


        continuePayment.addEventListener('click', function() {

            const selected =
                document.querySelector('.package-option.selected');

            if (!selected) {
                return;
            }


            const optionUuid =
                selected.dataset.optionUuid;


            console.log(
                'Selected package option:',
                optionUuid
            );


            /*
             * Nanti disambungkan ke:
             *
             * POST checkout
             * -> create Order
             * -> Midtrans
             */

        });

    });
</script>

@endsection