@extends('layouts.app')

@section('title', 'Class Schedules')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Schedules" page="Classes" active="Schedules"
        route="{{ route('schedules.index') }}" />
@endsection

<section class="section">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-3 fade show" role="alert">
            <span class="alert-text text-white">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible mb-3 fade show" role="alert">
            <span class="alert-text text-white">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap mb-3">
                <a href="{{ route('schedules.index', array_filter(['tab' => 'today', 'search' => $search ?? null, 'studio' => $studioUuid ?? null, 'level' => $level ?? null])) }}"
                    class="btn {{ $tab === 'today' ? 'btn-primary' : 'btn-light' }}">Today</a>
                <a href="{{ route('schedules.index', array_filter(['tab' => 'upcoming', 'search' => $search ?? null, 'studio' => $studioUuid ?? null, 'level' => $level ?? null])) }}"
                    class="btn {{ $tab === 'upcoming' ? 'btn-primary' : 'btn-light' }}">Upcoming (7 days)</a>
                <a href="{{ route('bookings.my') }}" class="btn btn-outline-secondary ms-auto">My Bookings</a>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">My Orders</a>
            </div>
            <form method="GET" action="{{ route('schedules.index') }}" class="row g-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="col-md-5">
                    <input type="search" name="search" value="{{ $search ?? '' }}" class="form-control"
                        placeholder="Search class or instructor" autocomplete="off">
                </div>
                <div class="col-md-3">
                    <select name="studio" class="form-select" onchange="this.form.submit()">
                        <option value="">All studios</option>
                        @foreach (($studios ?? []) as $studio)
                            <option value="{{ $studio->uuid }}" @selected(($studioUuid ?? '') === $studio->uuid)>{{ $studio->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="level" class="form-select" onchange="this.form.submit()">
                        <option value="">All levels</option>
                        @foreach (['foundation' => 'Foundation', 'intermediate' => 'Intermediate', 'advance' => 'Advance'] as $lv => $label)
                            <option value="{{ $lv }}" @selected(($level ?? '') === $lv)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </form>
        </div>
    </div>

    @if ($tab === 'today')
        @include('pages.schedules.partials.table', ['schedules' => $schedules, 'bookingDate' => $date])
    @else
        @foreach ($groups as $group)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ \Carbon\Carbon::parse($group['date'])->translatedFormat('l, j F Y') }}</h5>
                </div>
                <div class="card-body">
                    @include('pages.schedules.partials.table', ['schedules' => $group['schedules'], 'bookingDate' => $group['date']])
                </div>
            </div>
        @endforeach
    @endif
</section>

@endsection
