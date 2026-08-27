@extends('layouts.app')

@section('title', 'Profile')

@section('breadcrumb')
    <x-breadcrumb title="Profile" page="User Management" active="Profile" route="{{ route('profile.edit') }}" />
@endsection

@section('content')
    @if ($errors->updatePassword->any())
        @foreach ($errors->updatePassword->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif

    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-sm">
                    <img src="{{ Auth::user()->avatar
                        ? (Str::startsWith(Auth::user()->avatar, 'http')
                            ? Auth::user()->avatar
                            : asset('storage/' . Auth::user()->avatar))
                        : asset('dist/assets/compiled/jpg/avatar.jpg') }}"
                        alt="{{ auth()->user()->name }}" class="img-thumbnail rounded-circle" style="width: 100px" ;>
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <h3 class="text-grey mb-1">{{ auth()->user()->name }}</h3>
                    <p class="text-white-75">{{ auth()->user()->getRoleNames()[0] }}</p>
                </div>
            </div>
            <!--end col-->

        </div>
        <!--end row-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex">
                    <!-- Nav tabs -->

                    @role('super-admin|admin')
                        <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link fs-14 active" href="{{ route('account.index') }}">
                                    <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                        class="d-none d-md-inline-block">Lengkapi Profil</span>
                                </a>
                            </li>
                        </ul>
                    @else
                    @endrole

                    <div class="flex-shrink-0">
                        <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-password-{{ auth()->user()->id }}"
                            class="btn btn-success"><i class="ri-edit-box-line align-bottom"></i>
                            Ubah Password</a>
                    </div>
                </div>
                <!-- Tab panes -->
                <div class="tab-content pt-4 text-muted">
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">Info Profile</h5>
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Nama Lengkap :</th>
                                                        <td class="text-muted">{{ auth()->user()->name }}</td>
                                                    </tr>
                                                    <th class="ps-0" scope="row">Email :</th>
                                                    <td class="text-muted">{{ auth()->user()->email }}</td>
                                                    <tr>
                                                        <th class="ps-0" scope="row">Bergabung pada :</th>
                                                        <td class="text-muted">
                                                            {{ Carbon\Carbon::parse(auth()->user()->created_at)->translatedFormat('H:i - l, d F Y') ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                            <!-- end card body -->
                        </div><!-- end card -->
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end tab-pane-->
            </div>
        </div>
        <!--end tab-content-->
    </div>

    <!--end row-->
    @include('profile.partials.change-password')

@endsection
