<div class="modal fade" id="cekProfilModal-{{ $user->uuid }}" tabindex="-1"
    aria-labelledby="cekProfilModalLabel-{{ $user->uuid }}" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- ================= HEADER ================= --}}
            <div class="modal-header border-0 px-4 pt-4 pb-3">

                <div class="d-flex align-items-center gap-3">

                    {{-- Avatar --}}
                    <div class="rounded-circle bg-primary-subtle
                                d-flex align-items-center justify-content-center"
                        style="width: 52px; height: 52px;">

                        <span class="fw-bold text-primary fs-5">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>

                    </div>

                    <div>
                        <h5 class="modal-title fw-semibold mb-1" id="cekProfilModalLabel-{{ $user->uuid }}">
                            Member Overview
                        </h5>

                        <small class="text-muted">
                            {{ $user->name }}
                        </small>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>


            {{-- ================= BODY ================= --}}
            <div class="modal-body px-4 pb-4">

                {{-- ================= PERSONAL INFORMATION ================= --}}
                <div class="mb-4">

                    <div class="mb-3">
                        <h6 class="fw-semibold mb-1">
                            Personal Information
                        </h6>

                        <small class="text-muted">
                            Basic member information
                        </small>
                    </div>


                    <div class="row g-3">

                        {{-- Full Name --}}
                        <div class="col-md-6">
                            <div class="bg-primary-subtle rounded-3 p-3 h-100">

                                <small class="text-primary d-block mb-1">
                                    Full Name
                                </small>

                                <div class="fw-semibold text-dark">
                                    {{ $user->name }}
                                </div>

                            </div>
                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="bg-info-subtle rounded-3 p-3 h-100">

                                <small class="text-info-emphasis d-block mb-1">
                                    Email Address
                                </small>

                                <div class="fw-semibold text-dark text-break">
                                    {{ $user->email }}
                                </div>

                            </div>
                        </div>


                        {{-- Phone --}}
                        <div class="col-md-6">
                            <div class="bg-success-subtle rounded-3 p-3 h-100">

                                <small class="text-success d-block mb-1">
                                    Phone Number
                                </small>

                                <div class="fw-semibold text-dark">
                                    {{ $user->no_hp ?? '-' }}
                                </div>

                            </div>
                        </div>


                        {{-- Membership Status --}}
                        <div class="col-md-6">
                            <div class="bg-warning-subtle rounded-3 p-3 h-100">

                                <small class="text-warning-emphasis d-block mb-2">
                                    Membership Status
                                </small>

                                @if ($user->userPackages->isNotEmpty())
                                    <span class="badge rounded-pill bg-success px-3 py-2">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Active Member
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary px-3 py-2">
                                        <i class="bi bi-dash-circle-fill me-1"></i>
                                        No Membership
                                    </span>
                                @endif

                            </div>
                        </div>

                    </div>

                </div>


                {{-- ================= DIVIDER ================= --}}
                <hr class="my-4">


                {{-- ================= MEMBERSHIP ================= --}}
                <div>

                    <div class="d-flex align-items-center justify-content-between mb-3">

                        <div>
                            <h6 class="fw-semibold mb-1">
                                Membership
                            </h6>

                            <small class="text-muted">
                                Purchased membership packages
                            </small>
                        </div>

                        <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                            {{ $user->userPackages->count() }}
                            {{ $user->userPackages->count() == 1 ? 'Package' : 'Packages' }}
                        </span>

                    </div>


                    {{-- ================= PACKAGE LIST ================= --}}
                    @forelse ($user->userPackages as $userPackage)
                        <div class="bg-light border rounded-3 p-3 mb-3">

                            {{-- Package Header --}}
                            <div class="d-flex align-items-center justify-content-between gap-3">

                                <div class="d-flex align-items-center gap-3">

                                    <div class="bg-primary-subtle rounded-3
                                                d-flex align-items-center justify-content-center"
                                        style="width: 42px; height: 42px;">

                                        <i class="bi bi-box-seam text-primary"></i>

                                    </div>

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $userPackage->package->name ?? 'Unknown Package' }}
                                        </div>

                                        <small class="text-muted">
                                            Membership Package
                                        </small>
                                    </div>

                                </div>


                                {{-- Status --}}
                                @if ($userPackage->status === 'active')
                                    <span class="badge rounded-pill bg-success px-3 py-2">
                                        Active
                                    </span>
                                @elseif ($userPackage->status === 'expired')
                                    <span class="badge rounded-pill bg-danger px-3 py-2">
                                        Expired
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary px-3 py-2">
                                        {{ ucfirst($userPackage->status) }}
                                    </span>
                                @endif

                            </div>


                            {{-- Package Details --}}
                            <div class="row g-3 mt-3">

                                {{-- Quota --}}
                                <div class="col-md-4">

                                    <div class="bg-white rounded-3 p-3 h-100">

                                        <small class="text-muted d-block mb-1">
                                            Remaining Quota
                                        </small>

                                        <div class="fw-semibold">

                                            @if (is_null($userPackage->quota))
                                                <span class="text-primary">
                                                    <i class="bi bi-infinity me-1"></i>
                                                    Unlimited
                                                </span>
                                            @else
                                                {{ $userPackage->quota }}
                                                {{ $userPackage->quota == 1 ? 'Class' : 'Classes' }}
                                            @endif

                                        </div>

                                    </div>

                                </div>


                                {{-- Start Date --}}
                                <div class="col-md-4">

                                    <div class="bg-white rounded-3 p-3 h-100">

                                        <small class="text-muted d-block mb-1">
                                            Start Date
                                        </small>

                                        <div class="fw-semibold">
                                            {{ $userPackage->started_at ? $userPackage->started_at->format('d M Y') : '-' }}
                                        </div>

                                    </div>

                                </div>


                                {{-- Expiry Date --}}
                                <div class="col-md-4">

                                    <div class="bg-white rounded-3 p-3 h-100">

                                        <small class="text-muted d-block mb-1">
                                            Expiry Date
                                        </small>

                                        <div class="fw-semibold">

                                            @if ($userPackage->expired_at)
                                                {{ $userPackage->expired_at->format('d M Y') }}
                                            @else
                                                <span class="text-primary">
                                                    Unlimited
                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        {{-- ================= NO MEMBERSHIP ================= --}}
                        <div class="rounded-3 text-center py-4" style="border: 1px dashed var(--bs-border-color);">

                            <div class="mb-2">
                                <i class="bi bi-box-seam fs-3 text-secondary"></i>
                            </div>

                            <div class="fw-semibold mb-1">
                                No Membership
                            </div>

                            <small class="text-muted">
                                This member hasn't purchased any membership package yet.
                            </small>

                        </div>
                    @endforelse

                </div>

            </div>


            {{-- ================= FOOTER ================= --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-0">

                <button type="button" class="btn btn-danger border px-4" data-bs-dismiss="modal">
                    Close
                </button>

            </div>

        </div>

    </div>

</div>
