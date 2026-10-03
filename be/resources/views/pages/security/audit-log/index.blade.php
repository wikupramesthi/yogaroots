@extends('layouts.app')

@section('title', 'Audit Log')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Audit Log" page="Security" active="Audit Log"
        route="{{ route('security.audit-log.index') }}" />
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
                        <div class="ml-stat-icon ic-primary"><i class="bx bx-list-check"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['total']) }}</div>
                            <div class="ml-stat-label">Total Activities</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-warning"><i class="bx bx-calendar-check"></i></div>
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
                        <div class="ml-stat-icon ic-success"><i class="bx bx-plus-circle"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['created']) }}</div>
                            <div class="ml-stat-label">Created</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-violet"><i class="bx bx-edit"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['updated']) }}</div>
                            <div class="ml-stat-label">Updated</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-danger"><i class="bx bx-trash"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['deleted']) }}</div>
                            <div class="ml-stat-label">Deleted</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card ml-toolbar security-toolbar mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
                <form method="GET" action="{{ route('security.audit-log.index') }}"
                    class="security-filter-form d-flex flex-wrap align-items-end gap-3">
                    <div>
                        <label class="security-filter-label" for="filterSearch">Search</label>
                        <input type="text" name="search" id="filterSearch" class="form-control"
                            placeholder="User, data, or IP..." value="{{ $search }}" style="min-width: 200px;">
                    </div>
                    <div>
                        <label class="security-filter-label" for="filterEvent">Activity</label>
                        <select name="event" id="filterEvent" class="form-select">
                            <option value="">All Activities</option>
                            @foreach ($events as $option)
                                <option value="{{ $option }}" @selected($event === $option)>
                                    {{ ucfirst($option) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="security-filter-label" for="filterModel">Module</label>
                        <select name="model" id="filterModel" class="form-select">
                            <option value="">All Modules</option>
                            @foreach ($models as $class => $label)
                                <option value="{{ $class }}" @selected($model === $class)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="security-filter-label" for="filterUser">User</label>
                        <select name="user_uuid" id="filterUser" class="form-select" style="min-width: 180px;">
                            <option value="">All Users</option>
                            @foreach ($users as $uuid => $label)
                                <option value="{{ $uuid }}" @selected($userUuid === $uuid)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="security-filter-label" for="filterStart">From Date</label>
                        <input type="date" name="start_date" id="filterStart" class="form-control"
                            value="{{ $startDate }}">
                    </div>
                    <div>
                        <label class="security-filter-label" for="filterEnd">To Date</label>
                        <input type="date" name="end_date" id="filterEnd" class="form-control"
                            value="{{ $endDate }}">
                    </div>
                    <div class="d-flex gap-2 align-items-end">
<button type="submit" class="btn btn-success">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                        <a href="{{ route('security.audit-log.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                        <a href="{{ route('security.audit-log.exportPdf', request()->query()) }}" class="btn btn-success">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>
                        @can('audit-log.destroy')
                            @if ($stats['total'] > 0)
                                <button type="button" class="btn btn-outline-danger" onclick="clearAuditLogs()">
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
                <h5 class="card-title mb-0">Audit Trail</h5>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($logs->total()) }}
                    records</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                <p class="text-muted small mb-0 d-none d-md-block">History of data changes made by users.</p>
                @can('audit-log.destroy')
                <button type="button" id="bulkDeleteBtn" class="btn btn-sm btn-danger d-none" onclick="bulkDeleteAudit()">
                    <i class="bi bi-trash"></i> Delete selected (<span id="bulkCount">0</span>)
                </button>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <form id="bulk-delete-form" action="{{ route('security.audit-log.bulkDestroy') }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
                <div id="bulk-ids-container"></div>
            </form>
            <div class="table-responsive">
                <table class="table security-table">
                    <thead>
                        <tr>
                            @can('audit-log.destroy')
                            <th style="width: 36px;"><input type="checkbox" id="checkAllAudit" class="form-check-input"></th>
                            @endcan
                            <th>Time</th>
                            <th>User</th>
                            <th>Activity</th>
                            <th>Module</th>
                            <th>Data</th>
                            <th>IP Address</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($logs as $log)
                            <tr>
                                @can('audit-log.destroy')
                                <td><input type="checkbox" class="form-check-input audit-check" value="{{ $log->id }}"></td>
                                @endcan
                                <td>
                                    <span class="d-block">{{ optional($log->created_at)->translatedFormat('d M Y H:i') ?? '-' }}</span>
                                    <small class="log-muted">{{ optional($log->created_at)?->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <span class="d-block">{{ $log->user_name ?? 'System' }}</span>
                                    <small class="log-muted">{{ $log->user_email ?? '-' }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $log->event_badge }}">{{ $log->event_label }}</span>
                                </td>
                                <td>{{ $log->model_name }}</td>
                                <td>
                                    <span class="d-block">{{ $log->auditable_label ?? '-' }}</span>
                                    <small class="log-muted font-monospace">#{{ $log->auditable_id }}</small>
                                </td>
                                <td><span class="font-monospace small">{{ $log->ip_address ?? '-' }}</span></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-primary" title="Details"
                                        data-audit="{{ json_encode([
                                            'label' => $log->auditable_label,
                                            'event' => $log->event_label,
                                            'badge' => $log->event_badge,
                                            'model' => $log->model_name,
                                            'id' => $log->auditable_id,
                                            'user' => $log->user_name,
                                            'email' => $log->user_email,
                                            'time' => optional($log->created_at)->translatedFormat('d M Y H:i'),
                                            'url' => $log->url,
                                            'ip' => $log->ip_address,
                                            'ua' => $log->user_agent,
                                            'changes' => $log->changes(),
                                        ]) }}"
                                        onclick="showAuditDetail(this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    @can('audit-log.destroy')
                                        <button type="button" class="btn btn-sm btn-danger text-white" title="Delete"
                                            onclick="deleteAuditLog({{ $log->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-audit-log-{{ $log->id }}"
                                            action="{{ route('security.audit-log.destroy', $log->id) }}" method="POST"
                                            class="d-none">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No audit activity recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($logs->hasPages())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                    <div class="text-muted small">
                        Showing <strong>{{ $logs->firstItem() }}</strong> -
                        <strong>{{ $logs->lastItem() }}</strong> of
                        <strong>{{ $logs->total() }}</strong> records
                    </div>
                    <div>{{ $logs->links('pagination::minimal') }}</div>
                </div>
            @endif
        </div>
    </div>
</section>

<form id="clear-audit-log-form" action="{{ route('security.audit-log.clear') }}" method="POST" class="d-none">
    @method('DELETE')
    @csrf
</form>

<div class="modal fade" id="auditDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Audit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="audit-detail-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('after-script')
    <script>
        function escapeHtml(value) {
            if (value === null || value === undefined || value === '') {
                return '<span class="text-muted">-</span>';
            }
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function formatValue(value) {
            if (value === null || value === undefined || value === '') {
                return '<span class="text-muted fst-italic">empty</span>';
            }
            if (typeof value === 'object') {
                return '<code>' + escapeHtml(JSON.stringify(value)) + '</code>';
            }
            if (value === true || value === 1 || value === '1') {
                return '<span class="text-success">Active</span>';
            }
            if (value === false || value === 0 || value === '0') {
                return '<span class="text-danger">Inactive</span>';
            }
            return escapeHtml(value);
        }

        function showAuditDetail(button) {
            const data = JSON.parse(button.dataset.audit);
            const changes = data.changes || {};
            const keys = Object.keys(changes);

            let rows = '';
            if (keys.length) {
                keys.forEach(function (key) {
                    rows += '<tr>' +
                        '<td class="text-muted small">' + escapeHtml(key) + '</td>' +
                        '<td class="small">' + formatValue(changes[key].old) + '</td>' +
                        '<td class="small">' + formatValue(changes[key].new) + '</td>' +
                        '</tr>';
                });
            } else {
                rows = '<tr><td colspan="3" class="text-center text-muted py-3">No detailed changes.</td></tr>';
            }

            const html =
                '<div class="mb-3">' +
                    '<span class="badge ' + (data.badge || 'bg-secondary-subtle text-secondary') + '">' + escapeHtml(data.event) + '</span> ' +
                    '<strong>' + escapeHtml(data.model) + '</strong> - ' + escapeHtml(data.label || ('#' + data.id)) +
                '</div>' +
                '<div class="table-responsive mb-3">' +
                    '<table class="table table-sm align-middle">' +
                        '<thead><tr><th>Field</th><th>Before</th><th>After</th></tr></thead>' +
                        '<tbody>' + rows + '</tbody>' +
                    '</table>' +
                '</div>' +
                '<div class="row g-2 small">' +
                    '<div class="col-md-6"><span class="text-muted">User:</span> ' + escapeHtml(data.user || 'System') + ' (' + escapeHtml(data.email) + ')</div>' +
                    '<div class="col-md-6"><span class="text-muted">Time:</span> ' + escapeHtml(data.time) + '</div>' +
                    '<div class="col-md-6"><span class="text-muted">IP:</span> ' + escapeHtml(data.ip) + '</div>' +
                    '<div class="col-md-6" style="word-break:break-all;"><span class="text-muted">URL:</span> ' + escapeHtml(data.url) + '</div>' +
                    '<div class="col-12" style="word-break:break-all;"><span class="text-muted">User Agent:</span> ' + escapeHtml(data.ua) + '</div>' +
                '</div>';

            document.getElementById('audit-detail-body').innerHTML = html;
            new bootstrap.Modal(document.getElementById('auditDetailModal')).show();
        }

        function deleteAuditLog(id) {
            Swal.fire({
                title: 'Delete audit record?',
                text: 'This record will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#f43f5e'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-audit-log-' + id).submit();
                }
            });
        }

        function clearAuditLogs() {
            Swal.fire({
                title: 'Clear all records?',
                text: 'All audit history will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Clear!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#f43f5e'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('clear-audit-log-form').submit();
                }
            });
        }

        // bulk delete checkbox handling
        document.addEventListener('DOMContentLoaded', function() {
            const checkAll = document.getElementById('checkAllAudit');
            const bulkBtn = document.getElementById('bulkDeleteBtn');
            const bulkCount = document.getElementById('bulkCount');
            function updateBulk() {
                const checks = document.querySelectorAll('.audit-check');
                const checked = document.querySelectorAll('.audit-check:checked');
                const n = checked.length;
                if (bulkCount) bulkCount.textContent = n;
                if (bulkBtn) bulkBtn.classList.toggle('d-none', n === 0);
                if (checkAll) {
                    checkAll.checked = n > 0 && n === checks.length;
                    checkAll.indeterminate = n > 0 && n < checks.length;
                }
            }
            if (checkAll) {
                checkAll.addEventListener('change', function() {
                    document.querySelectorAll('.audit-check').forEach(c => c.checked = this.checked);
                    updateBulk();
                });
            }
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('audit-check')) updateBulk();
            });
        });

        function bulkDeleteAudit() {
            const ids = Array.from(document.querySelectorAll('.audit-check:checked')).map(c => c.value);
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
                    const form = document.getElementById('bulk-delete-form');
                    const container = document.getElementById('bulk-ids-container');
                    container.innerHTML = '';
                    ids.forEach(id => {
                        const inp = document.createElement('input');
                        inp.type = 'hidden';
                        inp.name = 'ids[]';
                        inp.value = id;
                        container.appendChild(inp);
                    });
                    form.submit();
                }
            });
        }
    </script>
@endpush
@endsection
