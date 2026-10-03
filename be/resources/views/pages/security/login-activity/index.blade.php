@extends('layouts.app')

@section('title', 'Login Activity')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Login Activity" page="Security" active="Login Activity"
        route="{{ route('security.login-activity.index') }}" />
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

    <div class="row mb-4 g-3 ml-stats">
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-primary"><i class="bx bx-log-in-circle"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['total']) }}</div>
                            <div class="ml-stat-label">Total Logins</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-success"><i class="bx bx-calendar-check"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['today']) }}</div>
                            <div class="ml-stat-label">Today</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-warning"><i class="bx bx-time-five"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['week']) }}</div>
                            <div class="ml-stat-label">Last 7 Days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-violet"><i class="bx bx-user-check"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['unique']) }}</div>
                            <div class="ml-stat-label">Unique Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-danger"><i class="bx bx-alarm-exclamation"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['suspicious']) }}</div>
                            <div class="ml-stat-label">Suspicious</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card ml-toolbar security-toolbar mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
            <form method="GET" action="{{ route('security.login-activity.index') }}"
                class="security-filter-form d-flex flex-wrap align-items-end gap-3">
                <div>
                    <label class="security-filter-label" for="filterSearch">Search</label>
                    <input type="text" name="search" id="filterSearch" class="form-control"
                        placeholder="Name, email, or IP..." value="{{ $search }}" style="min-width: 220px;">
                </div>
                <div>
                    <label class="security-filter-label" for="filterStart">From Date</label>
                    <input type="date" name="start_date" id="filterStart" class="form-control"
                        value="{{ $startDate }}">
                </div>
                <div>
                    <label class="security-filter-label" for="filterEnd">To Date</label>
                    <input type="date" name="end_date" id="filterEnd" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('security.login-activity.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                    @can('login-activity.destroy')
                        @if ($stats['total'] > 0)
                            <button type="button" class="btn btn-outline-danger" onclick="clearLoginActivities()">
                                <i class="bi bi-eraser"></i> Clear All
                            </button>
                        @endif
                    @endcan
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="card-title mb-0">Login History</h5>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($activities->total()) }}
                    records</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <p class="text-muted small mb-0 d-none d-md-block">Successful login activity recorded in the system.</p>
                @can('login-activity.destroy')
                <button type="button" id="bulkDeleteLoginActivityBtn" class="btn btn-sm btn-danger d-none" onclick="bulkDeleteLoginActivity()">
                    <i class="bi bi-trash"></i> Delete selected (<span id="bulkCountLoginActivity">0</span>)
                </button>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <form id="bulk-delete-login-activity-form" action="{{ route('security.login-activity.bulkDestroy') }}" method="POST" class="d-none">
                @csrf @method('DELETE')
                <div id="bulk-ids-login-activity"></div>
            </form>
            <div class="table-responsive">
                <table class="table security-table">
                    <thead>
                        <tr>
                            @can('login-activity.destroy')
                            <th style="width:36px;"><input type="checkbox" id="checkAllLoginActivity" class="form-check-input"></th>
                            @endcan
                            <th>User</th>
                            <th>Device</th>
                            <th>IP Address</th>
                            <th>Flags</th>
                            <th>Time</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($activities as $activity)
                            @php $flags = $detector->loginFlags($activity, $suspiciousUsers, $suspiciousIps); @endphp
                            <tr>
                                @can('login-activity.destroy')
                                <td><input type="checkbox" class="form-check-input login-activity-check" value="{{ $activity->id }}"></td>
                                @endcan
                                <td class="log-user">
                                    <span class="log-user-name d-block">{{ $activity->name ?? 'Unknown' }}</span>
                                    <small class="log-muted">{{ $activity->email ?? '-' }}</small>
                                </td>
                                <td>
                                    <span class="d-block">{{ $activity->browser() }}</span>
                                    <small class="log-muted">
                                        {{ $activity->platform() }}
                                        <span class="badge bg-light text-dark ms-1">{{ $activity->deviceType() }}</span>
                                    </small>
                                </td>
                                <td><span class="font-monospace small">{{ $activity->ip_address ?? '-' }}</span></td>
                                <td>
                                    @if ($flags)
                                        @foreach ($flags as $flag)
                                            <span class="badge bg-warning-subtle text-warning d-inline-flex align-items-center gap-1 mb-1">
                                                <i class="bi bi-exclamation-triangle"></i>{{ $flag }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="log-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-block">{{ optional($activity->logged_in_at)->translatedFormat('d M Y H:i') ?? '-' }}</span>
                                    <small class="log-muted">{{ optional($activity->logged_in_at)?->diffForHumans() }}</small>
                                </td>
                                <td class="text-end">
                                    @can('login-activity.destroy')
                                        <button type="button" class="btn btn-sm btn-danger text-white"
                                            title="Delete" onclick="deleteLoginActivity({{ $activity->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-login-activity-{{ $activity->id }}"
                                            action="{{ route('security.login-activity.destroy', $activity->id) }}"
                                            method="POST" class="d-none">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No login activity recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($activities->hasPages())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                    <div class="text-muted small">
                        Showing <strong>{{ $activities->firstItem() }}</strong> -
                        <strong>{{ $activities->lastItem() }}</strong> of
                        <strong>{{ $activities->total() }}</strong> records
                    </div>
                    <div>{{ $activities->links('pagination::minimal') }}</div>
                </div>
            @endif
        </div>
    </div>
</section>

<form id="clear-login-activity-form" action="{{ route('security.login-activity.clear') }}" method="POST" class="d-none">
    @method('DELETE')
    @csrf
</form>

@push('after-script')
    <script>
        function deleteLoginActivity(id) {
            Swal.fire({
                title: 'Delete this login record?',
                text: 'This record will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#f43f5e'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-login-activity-' + id).submit();
                }
            });
        }

        function clearLoginActivities() {
            Swal.fire({
                title: 'Clear all records?',
                text: 'All login history will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Clear!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#f43f5e'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('clear-login-activity-form').submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('checkAllLoginActivity');
            const bulkBtn = document.getElementById('bulkDeleteLoginActivityBtn');
            const bulkCount = document.getElementById('bulkCountLoginActivity');
            function updateBulk() {
                const checks = document.querySelectorAll('.login-activity-check');
                const checked = document.querySelectorAll('.login-activity-check:checked');
                const n = checked.length;
                if (bulkCount) bulkCount.textContent = n;
                if (bulkBtn) bulkBtn.classList.toggle('d-none', n === 0);
                if (checkAll) {
                    checkAll.checked = n > 0 && n === checks.length;
                    checkAll.indeterminate = n > 0 && n < checks.length;
                }
            }
            if (checkAll) checkAll.addEventListener('change', function() {
                document.querySelectorAll('.login-activity-check').forEach(c => c.checked = this.checked);
                updateBulk();
            });
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('login-activity-check')) updateBulk();
            });
        });
        function bulkDeleteLoginActivity() {
            const ids = Array.from(document.querySelectorAll('.login-activity-check:checked')).map(c => c.value);
            if (ids.length === 0) return;
            Swal.fire({
                title: 'Delete ' + ids.length + ' selected records?',
                text: 'Selected data will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#f43f5e'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('bulk-delete-login-activity-form');
                    const container = document.getElementById('bulk-ids-login-activity');
                    container.innerHTML = '';
                    ids.forEach(id => {
                        const inp = document.createElement('input');
                        inp.type = 'hidden'; inp.name = 'ids[]'; inp.value = id;
                        container.appendChild(inp);
                    });
                    form.submit();
                }
            });
        }
    </script>
@endpush
@endsection
