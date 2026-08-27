@extends('layouts.app')
@section('title', 'Publikasi')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Publikasi" page="Publikasi" active="Semua Posting" route="{{ route('articles.index') }}" />
@endsection
<!-- Content -->
<section class="section">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
            <span class="alert-text text-white"> {{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="alert alert-info alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
        <div class="d-flex">
            <i class="bi-info-circle-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
            <div class="text-white mt-2">
                <strong>Informasi:</strong> Saat ini Anda sedang melihat berita untuk tahun
                <strong>{{ $year }}</strong>.
                <br>
                Untuk melihat berita dari tahun lainnya, silakan gunakan filter tahun yang tersedia di bawah.
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">

            <div class="col-md-3">
                <form method="GET" action="{{ route('articles.index') }}">
                    <div class="form-group row align-items-center mb-3">
                        <label for="tahun" class="col-sm-3 col-form-label font-weight-bold">Filter :</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="year" onchange="this.form.submit()">
                                @for ($y = date('Y'); $y >= 2018; $y--)
                                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">Publikasi</h4>
                @can('articles.store')
                    <a href="{{ route('articles.create') }}" class="btn btn-primary btn-md"><i class="bi bi-plus-lg"></i>
                        Tambah Baru</a>
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
                            <th>Judul</th>
                            <th>Author</th>
                            <th>Kategori</th>
                            <th>status</th>
                            {{-- <th>Sudah dilihat</th> --}}
                            <th>Tanggal Publish</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($articles as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="/storage/{{ $item->featured_image }}" class="img-fluid"
                                        style="max-height:80px" alt="{{ $item->title }}">
                                </td>
                                <td style="white-space: normal; max-width: 300px;">
                                    {{ $item->title }}
                                </td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->category->name }}</td>
                                <td>
                                    @if ($item->status == 'published')
                                        <span class="badge bg-success">Published</span>
                                    @elseif($item->status == 'draft')
                                        <span class="badge bg-secondary">Draft</span>
                                    @elseif($item->status == 'scheduled')
                                        <span class="badge bg-warning text-dark">Scheduled</span>
                                    @else
                                        <span class="badge bg-danger">Unknown</span>
                                    @endif
                                </td>
                                {{-- <td>
                                    <i class="bi bi-eye"></i> {{ number_format($item->views) }} kali
                                </td> --}}
                                <td> {{ $item->scheduled_at->format('d-m-Y') }}</td>
                                <td>
                                    @can('articles.update')
                                        <a href="{{ route('articles.edit', $item->uuid) }}"
                                            class="btn btn-icon btn-success text-white"><i class="bi bi-pencil-square"></i>
                                            Edit</a>
                                    @endcan
                                </td>

                                <td>
                                    @can('articles.destroy')
                                        <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                            class="btn btn-icon btn-danger text-white">
                                            <i class="bi bi-x-square"></i> Hapus
                                        </a>
                                        <form id="deleteForm_{{ $item->uuid }}"
                                            action="{{ route('articles.destroy', $item->uuid) }}" method="POST">
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
