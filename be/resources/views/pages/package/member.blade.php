@extends('layouts.app')
@section('title', 'Browse Packages')
@section('content')

<style>
.membership-page { min-height: 100vh; padding: 40px 0 70px; }

/* Filter */
.package-filter { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 30px; padding: 6px; background: #fff; border: 1px solid #ece9e4; border-radius: 14px; box-shadow: 0 4px 18px rgba(0, 0, 0, .035); }
.package-filter-left { display: flex; align-items: center; gap: 4px; }
.package-filter-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 15px; border-radius: 9px; color: #777; background: transparent; text-decoration: none; font-size: 13px; font-weight: 600; transition: all .2s ease; }
.package-filter-btn:hover { color: #6d4aff; background: #f7f5ff; }
.package-filter-btn.active { color: #6d4aff; background: #f1edff; }
.package-filter-btn i { font-size: 16px; margin-top: 1px; }

/* Sort */
.package-sort { display: flex; align-items: center; gap: 9px; padding-right: 4px; }
.sort-label { color: #888; font-size: 13px; white-space: nowrap; }
.package-sort .form-select { width: 175px; border-color: #e7e4df; border-radius: 9px; color: #444; font-size: 13px; cursor: pointer; }
.package-sort .form-select:focus { border-color: #6d4aff; box-shadow: 0 0 0 .15rem rgba(109, 74, 255, .10); }

/* Card */
.membership-card { position: relative; height: 100%; background: #fff; border: 1px solid #ece9e4; border-radius: 24px; padding: 30px; display: flex; flex-direction: column; box-shadow: 0 8px 30px rgba(0, 0, 0, .045); transition: transform .3s ease, box-shadow .3s ease; }
.membership-card:hover { transform: translateY(-7px); box-shadow: 0 18px 45px rgba(0, 0, 0, .10); }
.membership-card.popular { background: linear-gradient(145deg, #32165f 0%, #47217d 50%, #29205d 100%); border: 2px solid #7047e8; color: #fff; box-shadow: 0 20px 45px rgba(73, 37, 126, .25); transform: translateY(-10px); }
.membership-card.popular:hover { transform: translateY(-16px); }
.popular-badge { position: absolute; top: -14px; left: 50%; transform: translateX(-50%); background: #7047e8; color: #fff; padding: 7px 18px; border-radius: 50px; font-size: 12px; font-weight: 700; white-space: nowrap; box-shadow: 0 6px 18px rgba(112, 71, 232, .35); }

.package-name { font-size: 25px; font-weight: 700; color: #202020; margin-bottom: 7px; }
.popular .package-name { color: #fff; }
.package-description { color: #6b7280; font-size: 14px; line-height: 1.6; min-height: 45px; margin-bottom: 22px; }
.popular .package-description { color: rgba(255, 255, 255, .78); }
.package-divider { border-top: 1px solid #eee; margin-bottom: 22px; }
.popular .package-divider { border-color: rgba(255, 255, 255, .16); }

/* Price */
.package-price-box { margin-bottom: 22px; padding-bottom: 20px; border-bottom: 1px solid #f0ede8; }
.popular .package-price-box { border-color: rgba(255, 255, 255, .12); }
.package-price-label { font-size: 11px; font-weight: 600; color: #8b8f87; margin-bottom: 5px; }
.package-price-range { font-size: 24px; line-height: 1.2; font-weight: 800; letter-spacing: -0.5px; color: #202020; }
.package-price-range.discounted { color: #c4703c; }
.popular .package-price-range { color: #fff; }
.popular .package-price-range span { color: rgba(255, 255, 255, .6); }
.popular .package-price-original { color: rgba(255, 255, 255, .55); }
.popular .package-price-label { color: rgba(255, 255, 255, .7); }
.package-price-range span { font-size: 16px; font-weight: 500; color: #9b9d97; margin: 0 3px; }
.package-price-original { margin-top: 4px; font-size: 11px; color: #9b9d97; }
.package-price-original span { text-decoration: line-through; }

/* Features */
.features-title { font-size: 13px; font-weight: 700; color: #444; margin-bottom: 14px; }
.popular .features-title { color: #fff; }
.package-features { list-style: none; padding: 0; margin: 0 0 28px; flex-grow: 1; }
.package-features li { display: flex; align-items: flex-start; gap: 10px; color: #555; font-size: 14px; line-height: 1.5; margin-bottom: 11px; }
.package-features li:last-child { margin-bottom: 0; }
.package-features li i { color: #39a66b; font-size: 18px; flex-shrink: 0; }
.popular .package-features li { color: rgba(255, 255, 255, .86); }
.popular .package-features li i { color: #b49aff; }

/* Button */
.choose-package { width: 100%; border-radius: 12px; padding: 12px 20px; font-size: 14px; font-weight: 700; border: 1.5px solid #6d4aff; background: transparent; color: #6d4aff; transition: all .25s ease; }
.choose-package:hover { background: #6d4aff; color: #fff; }
.popular .choose-package { background: #7047e8; border-color: #7047e8; color: #fff; }
.popular .choose-package:hover { background: #805cf0; border-color: #805cf0; }
.saving-text { text-align: center; margin-top: 17px; color: #6d4aff; font-size: 13px; font-weight: 700; }
.popular .saving-text { color: rgba(255, 255, 255, .75); }

/* Empty state */
.package-empty { background: #fff; border: 1px solid #ece9e4; border-radius: 20px; padding: 60px 30px; box-shadow: 0 8px 30px rgba(0, 0, 0, .035); }
.package-empty-icon { width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; background: #f5f2ff; border-radius: 50%; color: #6d4aff; font-size: 28px; }
.package-empty h5 { color: #333; margin-bottom: 8px; }
.package-empty p { color: #888; margin-bottom: 0; font-size: 14px; }

@media (max-width: 1199px) {
    .membership-card.popular { transform: none; }
    .membership-card.popular:hover { transform: translateY(-7px); }
}

@media (max-width: 767px) {
    .membership-page { padding: 30px 0 50px; }
    .package-filter { flex-direction: column; align-items: stretch; padding: 8px; gap: 8px; }
    .package-filter-left { width: 100%; overflow-x: auto; scrollbar-width: none; }
    .package-filter-left::-webkit-scrollbar { display: none; }
    .package-filter-btn { white-space: nowrap; padding: 8px 12px; }
    .package-sort { width: 100%; padding: 4px 2px 0; }
    .package-sort .form-select { flex: 1; width: auto; }
    .membership-card { padding: 25px; }
    .membership-card.popular { transform: none; }
    .membership-card.popular:hover { transform: translateY(-5px); }
}
</style>

<div class="membership-page">
    <div class="container">

        <div class="package-filter">
            <div class="package-filter-left">
                <a href="{{ route('packages.member') }}" class="package-filter-btn {{ !request('filter') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap"></i> All Packages
                </a>
                <a href="{{ route('packages.member', ['filter' => 'popular', 'sort' => request('sort')]) }}" class="package-filter-btn {{ request('filter') === 'popular' ? 'active' : '' }}">
                    <i class="bi bi-star-fill"></i> Popular
                </a>
                <a href="{{ route('packages.member', ['filter' => 'unlimited', 'sort' => request('sort')]) }}" class="package-filter-btn {{ request('filter') === 'unlimited' ? 'active' : '' }}">
                    <i class="bi bi-infinity"></i> Unlimited
                </a>
            </div>

            <div class="package-sort">
                <span class="sort-label">Sort by</span>
                <select id="packageSort" class="form-select form-select-sm" onchange="sortPackages(this.value)">
                    <option value="" {{ !request('sort') ? 'selected' : '' }}>Recommended</option>
                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Lowest Price</option>
                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Highest Price</option>
                    <option value="duration_short" {{ request('sort') === 'duration_short' ? 'selected' : '' }}>Shortest Duration</option>
                    <option value="duration_long" {{ request('sort') === 'duration_long' ? 'selected' : '' }}>Longest Duration</option>
                </select>
            </div>
        </div>

        <div class="row g-4 align-items-stretch">
            @forelse ($packages as $package)
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="membership-card {{ $package->is_popular ? 'popular' : '' }}">

                    @if ($package->is_popular)
                    <div class="popular-badge"><i class="bi bi-star-fill me-1"></i>POPULAR</div>
                    @endif

                    <div class="package-name">{{ $package->name }}</div>
                    <div class="package-description">{{ $package->description ?: 'Start your yoga journey with a membership designed for you.' }}</div>
                    <div class="package-divider"></div>

                    @php
                        $regularPrices = $package->options->pluck('price');
                        $finalPrices = $package->options->map(fn ($o) => $o->discount_price !== null && $o->discount_price < $o->price ? $o->discount_price : $o->price);
                        $minRegular = $regularPrices->min();
                        $maxRegular = $regularPrices->max();
                        $minFinal = $finalPrices->min();
                        $maxFinal = $finalPrices->max();
                        $hasDiscount = $package->options->contains(fn ($o) => $o->discount_price !== null && $o->discount_price < $o->price);
                    @endphp

                    <div class="package-price-box">
                        <div class="package-price-label">Membership from</div>
                        <div class="package-price-range {{ $hasDiscount ? 'discounted' : '' }}">
                            Rp {{ number_format($minFinal, 0, ',', '.') }}
                            @if ($minFinal != $maxFinal)
                            <span>-</span> Rp {{ number_format($maxFinal, 0, ',', '.') }}
                            @endif
                        </div>
                        @if ($hasDiscount)
                        <div class="package-price-original">
                            from <span>Rp {{ number_format($minRegular, 0, ',', '.') }}@if ($minRegular != $maxRegular) - Rp {{ number_format($maxRegular, 0, ',', '.') }}@endif</span>
                        </div>
                        @endif
                    </div>

                    <div class="features-title">What's included</div>
                    <ul class="package-features">
                        @forelse ($package->features as $feature)
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ $feature->feature }}</span>
                        </li>
                        @empty
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Access to Yogaroots classes</span>
                        </li>
                        @endforelse
                    </ul>

                    <div class="mt-auto">
                        <button type="button" class="choose-package w-100" onclick="window.location.href='{{ route('checkout.package', $package->uuid) }}'">
                            Choose Package <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                        <div class="saving-text"><i class="bi bi-heart-fill me-1"></i>Start your yoga journey</div>
                    </div>

                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="package-empty text-center">
                    <div class="package-empty-icon"><i class="bi bi-box-seam"></i></div>
                    <h5 class="fw-bold">No Membership Packages Available</h5>
                    <p>Membership packages are currently unavailable.</p>
                    @if (request('filter') || request('sort'))
                    <div class="mt-4">
                        <a href="{{ route('packages.member') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>View All Packages
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforelse
        </div>

    </div>
</div>

<script>
    function sortPackages(sort) {
        const url = new URL(window.location.href);
        const currentFilter = url.searchParams.get('filter');

        if (sort) {
            url.searchParams.set('sort', sort);
        } else {
            url.searchParams.delete('sort');
        }

        if (currentFilter) {
            url.searchParams.set('filter', currentFilter);
        }

        window.location.href = url.toString();
    }
</script>

@endsection
