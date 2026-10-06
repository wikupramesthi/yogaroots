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
            <div class="mb-3 text-end">
                <a href="{{ route('member-view', 'mobile') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-phone me-1"></i> Mobile view
                </a>
            </div>
            @include('pages.dashboard.member')
            @else
            @include('pages.dashboard.card')
            @endif

        </div>

    </section>
</div>

@endsection