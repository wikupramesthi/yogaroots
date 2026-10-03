@extends('layouts.app')
@section('title', 'Events')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Events" page="Events" active="All Events" route="{{ route('events.index') }}" />
@endsection

<section class="section">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white"> {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white"> {{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {{-- Statistic cards: numbers follow the active filter --}}
    <div class="row mb-4 g-3 ml-stats">
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-primary"><i class="bx bx-calendar-event"></i></div><div><div class="ml-stat-value">{{ number_format($stats['total']) }}</div><div class="ml-stat-label">Total Events</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-success"><i class="bx bx-check-circle"></i></div><div><div class="ml-stat-value">{{ number_format($stats['published']) }}</div><div class="ml-stat-label">Published</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-warning"><i class="bx bx-edit"></i></div><div><div class="ml-stat-value">{{ number_format($stats['draft']) }}</div><div class="ml-stat-label">Draft</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-danger"><i class="bx bx-x-circle"></i></div><div><div class="ml-stat-value">{{ number_format($stats['cancelled']) }}</div><div class="ml-stat-label">Cancelled</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-violet"><i class="bx bx-check-double"></i></div><div><div class="ml-stat-value">{{ number_format($stats['completed']) }}</div><div class="ml-stat-label">Completed</div></div></div></div></div></div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body py-2 px-3">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
                <form method="GET" action="{{ route('events.index') }}" class="d-flex flex-wrap align-items-end gap-2">
                    <div><label class="form-label small mb-0">Search</label><input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Event name..." style="min-width:180px;" autocomplete="off"></div>
                    <div><label class="form-label small mb-0">Status</label><select name="status" class="form-select form-select-sm" style="min-width:150px;"><option value="">All</option><option value="draft" @selected($status==='draft')>Draft</option><option value="published" @selected($status==='published')>Published</option><option value="cancelled" @selected($status==='cancelled')>Cancelled</option><option value="completed" @selected($status==='completed')>Completed</option></select></div>
                    <div><label class="form-label small mb-0">From</label><input type="date" name="tanggal_mulai" class="form-control form-control-sm" value="{{ $tanggal_mulai }}"></div>
                    <div><label class="form-label small mb-0">Until</label><input type="date" name="tanggal_selesai" class="form-control form-control-sm" value="{{ $tanggal_selesai }}"></div>
                    <div class="d-flex gap-1"><button type="submit" class="btn btn-sm btn-success"><i class="bi bi-funnel"></i> Filter</button><a href="{{ route('events.index') }}" class="btn btn-sm btn-light">Reset</a></div>
                </form>
                @can('events.store')
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form-add-events">
                    <i class="bi bi-plus-lg"></i> Add Event
                </button>
                @endcan
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0">Events</h6>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($stats['total']) }} events</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:0.9rem;">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th><th>Image</th><th>Event Name</th><th>Date</th><th class="hide-xs">Time</th><th class="hide-sm">Location</th><th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="rounded" style="width:60px;height:42px;object-fit:cover;" loading="lazy">
                                @else
                                <span class="d-inline-flex align-items-center justify-content-center rounded bg-light text-muted" style="width:60px;height:42px;"><i class="bi bi-image"></i></span>
                                @endif
                            </td>
                            <td><span class="fw-semibold d-block" style="font-size:0.9rem;">{{ Str::limit($item->judul, 50) }}</span></td>
                            <td><small>{{ $item->tanggal?->format('d M Y') ?? '-' }}</small></td>
                            <td class="hide-xs">
                                <small>
                                    @if ($item->waktu_mulai)
                                    {{ $item->waktu_mulai }}
                                    @if ($item->waktu_selesai)
                                    - {{ $item->waktu_selesai }}
                                    @endif
                                    @else
                                    -
                                    @endif
                                </small>
                            </td>
                            <td class="hide-sm"><small>{{ Str::limit($item->lokasi ?? '-', 30) }}</small></td>
                            <td>
                                @if ($item->status === 'published')
                                <span class="badge bg-success">Published</span>
                                @elseif ($item->status === 'draft')
                                <span class="badge bg-secondary">Draft</span>
                                @elseif ($item->status === 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                                @elseif ($item->status === 'completed')
                                <span class="badge bg-primary">Completed</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('events.update')
                                    <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-events-{{ $item->uuid }}" title="Edit" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                                    @include('pages.event.modal-edit')
                                    @endcan
                                    @can('events.destroy')
                                    <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                                    <form id="deleteForm_{{ $item->uuid }}" action="{{ route('events.destroy', $item->uuid) }}" method="POST" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">No events found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- / Content -->

@include('pages.event.modal-create')

<script>
    function showSweetAlert(getId) {
        Swal.fire({
            title: 'Confirm Deletion',
            text: 'This data will be permanently deleted and cannot be recovered. Are you sure you want to delete it?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Deleted!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm_' + getId).submit();
            }
        });
    }
</script>
@endsection
