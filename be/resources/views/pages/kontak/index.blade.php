@extends('layouts.app')
@section('title', 'Settings')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Messages" page="Settings" active="Messages" route="{{ route('layanan.kontak') }}" />
@endsection

<div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
    <div class="d-flex">
        <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>

        <div class="text-white mt-0">
            <strong>Message Management</strong> <br>
            Manage and review messages, inquiries, and feedback submitted by visitors through the contact form.
        </div>
    </div>
</div>

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
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">Messages</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap mx-2">
                <table class="table table table-bordered" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>WhatsApp Number</th>
                            <th>Message</th>
                            <th>Date Created</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kontaks as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->no_telp }}</td>
                                <td style="white-space: normal; word-break: break-word; max-width: 500px;">
                                    {{ $item->isi }}
                                </td>

                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                        class="btn btn-icon btn-danger text-white">
                                        <i class="bi bi-x-square"> Deleted</i>
                                    </a>
                                    <form id="deleteForm_{{ $item->uuid }}"
                                        action="{{ route('kontak.destroy', $item->uuid) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
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
            title: 'Confirm Deletion',
            text: 'This data will be permanently deleted and cannot be recovered. Are you sure you want to delete it?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Deleted!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicks "Yes, delete it!", submit the corresponding form
                document.getElementById('deleteForm_' + getId).submit();
            }
        });
    }
</script>
@endsection
