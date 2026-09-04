@extends('layouts.app')
@section('title', 'Add Instructor')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Add Instructor" page="Instructors" active="Add Instructor" route="{{ route('instruktur.index') }}" />
@endsection

<!-- Content -->
<section class="section">
    <div class="card">
        <div class="card-body">

            <form action="{{ route('instruktur.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="avatar" class="mb-2">Photo Instructor<span class="text-danger">*</span></label>
                    <input type="file" name="avatar" id="avatar"
                        class="form-control @error('avatar') is-invalid @enderror" accept="image/*" required>
                    @error('avatar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="name" class="mb-2">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Full Name"
                        value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="mb-2">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="specializations" class="small mb-1">
                        Select Specializations <span class="text-danger">*</span>
                    </label>

                    @php
                    $selectedSpecializations = old('specializations', []);
                    @endphp

                    <select
                        class="form-control"
                        id="specializations"
                        name="specializations[]"
                        multiple
                        required>

                        @foreach ($specializations as $specialization)
                        <option
                            value="{{ $specialization->uuid }}"
                            {{ in_array($specialization->uuid, $selectedSpecializations) ? 'selected' : '' }}>
                            {{ $specialization->name }}
                        </option>
                        @endforeach

                    </select>

                    @error('specializations')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir" class="mb-2">Place of birth <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                            class="form-control @error('tempat_lahir') is-invalid @enderror" required>
                        @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="mb-2">Date of birth <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
                        @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="jenis_kelamin" class="mb-2">Gender <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Select Gender --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Male
                        </option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Female
                        </option>
                    </select>
                    @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="agama" class="mb-2">Religion <span class="text-danger">*</span></label>
                    <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror"
                        required>
                        <option value="">-- Choose Religion --</option>
                        @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $agama)
                        <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>
                            {{ $agama }}
                        </option>
                        @endforeach
                    </select>
                    @error('agama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="pengalaman" class="mb-2">Experience <span class="text-danger">*Example: 10 years</span></label>
                    <input type="text" name="pengalaman" id="pengalaman" value="{{ old('pengalaman') }}"
                        class="form-control @error('pengalaman') is-invalid @enderror" required>
                    @error('pengalaman')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="no_hp" class="mb-2">Phone Number</label>
                    <input type="number" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                        class="form-control @error('no_hp') is-invalid @enderror">
                    @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="biografi" class="mb-2">Biography</label>
                    <textarea name="biografi" id="biografi" rows="4"
                        class="form-control @error('biografi') is-invalid @enderror">{{ old('biografi') }}</textarea>
                    @error('biografi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="is_active" class="mb-2">Currently Working <span class="text-danger">*</span></label>
                    <input type="date" name="is_active"
                        class="form-control @error('is_active') is-invalid @enderror"
                        value="{{ old('is_active') }}">
                    @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="facebook" class="mb-2">Link Facebook</label>
                    <input type="text" name="facebook" id="facebook" value="{{ old('facebook') }}"
                        class="form-control @error('facebook') is-invalid @enderror">
                    @error('facebook')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="instagram" class="mb-2">Link Instagram</label>
                    <input type="text" name="instagram" id="instagram" value="{{ old('instagram') }}"
                        class="form-control @error('instagram') is-invalid @enderror">
                    @error('instagram')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="twitter" class="mb-2">Link Twitter</label>
                    <input type="text" name="twitter" id="twitter" value="{{ old('twitter') }}"
                        class="form-control @error('twitter') is-invalid @enderror">
                    @error('twitter')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tiktok" class="mb-2">Link TikTok</label>
                    <input type="text" name="tiktok" id="tiktok" value="{{ old('tiktok') }}"
                        class="form-control @error('tiktok') is-invalid @enderror">
                    @error('tiktok')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="youtube" class="mb-2">Link YouTube</label>
                    <input type="text" name="youtube" id="youtube" value="{{ old('youtube') }}"
                        class="form-control @error('youtube') is-invalid @enderror">
                    @error('youtube')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-right mt-4">
                    <a href="{{ route('instruktur.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection