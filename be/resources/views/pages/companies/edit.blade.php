@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-5">Edit Website Details</h4>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('company.update', $company->id) }}" method="POST">
                    @csrf
                    @method('put')

                    <div class="form-group mb-3">
                        <label for="visi">Vision:</label>
                        <input type="text" name="visi" class="form-control" placeholder="Enter Company Vision" value="{{ $company->visi }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="misi">Mission:</label>
                        <textarea name="misi" class="form-control" placeholder="Enter Company Mission">{{ $company->misi }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="kebijakan">Policy:</label>
                        <textarea name="kebijakan" class="form-control" placeholder="Enter Company Policy">{{ $company->kebijakan }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jasapelayanan">Services:</label>
                        <textarea name="jasapelayanan" class="form-control" placeholder="Enter Company Services">{{ $company->jasapelayanan }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection