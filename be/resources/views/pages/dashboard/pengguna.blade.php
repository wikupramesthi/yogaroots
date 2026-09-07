@extends('layouts.app')
@section('title', 'All Members')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="All Members" page="Settings" active="All Members" route="{{ route('pengguna.index') }}" />
@endsection

<!-- Content -->
<section class="section mt-2">
    <div class="card">
        <div class="card-header">

            <div class="col-12">
                <form action="{{ route('pengguna.index') }}" method="GET" class="row g-2 align-items-center">

                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">From</span>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">To</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Year</span>

                            <select name="tahun" class="form-select">
                                <option value="">All Years</option>

                                @for ($tahun = date('Y'); $tahun >= 2025; $tahun--)
                                    <option value="{{ $tahun }}"
                                        {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="col-md-auto col-12 d-flex gap-2">

                        <button class="btn btn-sm btn-success" type="submit">
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>

                        <a href="{{ route('pengguna.index') }}" class="btn btn-sm btn-secondary">
                            Reset
                        </a>

                        <a href="{{ route('pengguna.export', request()->all()) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-file-earmark-excel"></i>
                            Download Excel
                        </a>

                    </div>

                </form>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap mx-2">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Registration Date</th>
                            <th>Member Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Registration</th>
                            <th>Membership Package</th>
                            <th>View Profile</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->email_verified_at ? $user->email_verified_at->format('d-m-Y H:i:s') : '-' }}
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td>{{ $user->no_hp ?? '-' }}</td>

                                {{-- Kolom verifikasi akun --}}
                                <td class="text-center">
                                    @if ($user->created_at)
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @else
                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                    @endif
                                </td>

                                {{-- Kolom status profil --}}
                                <td class="text-center">
                                    @if ($user->userPackages->isNotEmpty())
                                        <span title="Has Membership">
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        </span>
                                    @else
                                        <span title="No Membership">
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        </span>
                                    @endif
                                </td>

                                {{-- Tombol & Modal Detail --}}
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#cekProfilModal-{{ $user->uuid }}">
                                        <i class="bi bi-eye"></i> Lihat
                                    </button>
                                      @include('pages.dashboard.modal-detail-user', ['user' => $user])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</section>
<!-- / Content -->
@endsection
