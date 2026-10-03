@extends('layouts.app')
@section('title', 'Website Profile')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Website Profile" page="Website Profile" active="General Information" route="{{ route('company.index') }}" />
@endsection

<!-- Content -->
<section class="section">
    <div class="card">
        <div class="card-body">

            @if ($errors->any())
            <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
                <span class="alert-text text-white">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <form action="{{ route('company.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="visi" class="mb-2">Company Vision<span class="text-danger">*</span></label>
                    <input type="text" name="visi" class="form-control" placeholder="Enter Company Vision" require>
                </div>

                <div class="form-group mb-3">
                    <label for="misi" class="mb-2">Mission:</label>
                    <textarea name="misi" class="form-control" placeholder="Enter Company Mission"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="kebijakan" class="mb-2">Policy:</label>
                    <textarea name="kebijakan" class="form-control" placeholder="Enter Company Policy"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="jasapelayanan" class="mb-2">Services:</label>
                    <textarea name="jasapelayanan" class="form-control" placeholder="Enter Company Services"></textarea>
                </div>

                <div class="form-group text-right mt-4">
                    <a href="{{ route('company.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button class="btn btn-danger">Save</button>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection