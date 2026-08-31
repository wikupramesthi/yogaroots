@extends('layouts.app')
@section('title', 'Event')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Event" page="Event" active="Daftar Event" route="{{ route('events.index') }}" />
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
    <div class="card">
        <div class="card-header">

            <div class="col-md-8">
                <form method="GET" action="{{ route('events.index') }}" class="d-flex align-items-center gap-2">

                    <label class="font-weight-bold mb-0">
                        Filter:
                    </label>

                    {{-- Status --}}
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>

                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>
                            Published
                        </option>

                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>
                    </select>

                    {{-- Tanggal Mulai --}}
                    <input type="date" name="tanggal_mulai" class="form-control"
                        value="{{ request('tanggal_mulai') }}">

                    {{-- Tanggal Selesai --}}
                    <input type="date" name="tanggal_selesai" class="form-control"
                        value="{{ request('tanggal_selesai') }}">

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>

                    @if (request('status') || request('tanggal_mulai') || request('tanggal_selesai'))
                        <a href="{{ route('events.index') }}" class="btn btn-danger">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    @endif

                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">Semua Event</h4>
                @can('events.store')
                    <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                        data-bs-target="#modal-form-add-events">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Baru
                    </button>
                @endcan

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap mx-2">
                <table class="table table table-bordered" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Gambar</th>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Event"
                                        style="width: 80px; height: auto;">
                                </td>
                                <td>{{ $item->judul }}</td>
                                <td>
                                    {{ $item->tanggal?->format('d M Y') ?? '-' }}
                                </td>

                                <td>
                                    @if ($item->waktu_mulai)
                                        {{ $item->waktu_mulai }}
                                        @if ($item->waktu_selesai)
                                            - {{ $item->waktu_selesai }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->lokasi }}</td>


                                <td>
                                    @if ($item->status === 'published')
                                        <span class="badge bg-success">
                                            Published
                                        </span>
                                    @elseif ($item->status === 'draft')
                                        <span class="badge bg-secondary">
                                            Draft
                                        </span>
                                    @elseif ($item->status === 'cancelled')
                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>
                                    @elseif ($item->status === 'completed')
                                        <span class="badge bg-primary">
                                            Completed
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @can('events.update')
                                        <a data-bs-toggle="modal"
                                            data-bs-target="#modal-form-edit-events-{{ $item->uuid }}"
                                            class="btn btn-icon btn-success text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        @include('pages.event.modal-edit')
                                    @endcan
                                </td>

                                <td>
                                    @can('events.destroy')
                                        <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                            class="btn btn-icon btn-danger text-white">
                                            <i class="bi bi-x-square"></i> Hapus
                                        </a>
                                        <form id="deleteForm_{{ $item->uuid }}"
                                            action="{{ route('events.destroy', $item->uuid) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    @endcan
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

@include('pages.event.modal-create')

<script>
    function showSweetAlert(getId) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            text: 'Data ini akan dihapus secara permanen dan tidak bisa dikembalikan. Apakah Anda yakin ingin menghapusnya?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicks "Yes, delete it!", submit the corresponding form
                document.getElementById('deleteForm_' + getId).submit();
            }
        });
    }
</script>
@endsection
