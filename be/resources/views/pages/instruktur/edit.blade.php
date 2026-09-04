@extends('layouts.app')
@section('title', 'Edit Instructor')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Edit Instructor" page="Instructors" active="Edit Instructor" route="{{ route('instruktur.index') }}" />
@endsection

<!-- Content -->
<section class="section">
    <div class="card">
        <div class="card-body">

            <form action="{{ route('instruktur.update', $instruktur->uuid) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="avatar" class="mb-2">Photo Instructor <span class="text-danger">*</span></label>
                    <input type="file" name="avatar" id="avatar"
                        class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                    @if ($instruktur->avatar)
                    <small class="text-muted">Current Profile Photo: <a href="{{ asset('storage/' . $instruktur->avatar) }}"
                            target="_blank">View</a></small>
                    @endif
                    @error('avatar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="name" class="mb-2">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" placeholder="Full Name"
                        value="{{ old('name', $instruktur->name) }}"
                        class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="mb-2">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $instruktur->email) }}"
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
                    $selectedSpecializations = old(
                    'specializations',
                    $instruktur->specializations->pluck('uuid')->toArray()
                    );
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
                        <input type="text" name="tempat_lahir" id="tempat_lahir"
                            value="{{ old('tempat_lahir', $instruktur->tempat_lahir) }}"
                            class="form-control @error('tempat_lahir') is-invalid @enderror" required>
                        @error('tempat_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="mb-2">Date of birth <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $instruktur->tanggal_lahir) }}"
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
                        <option value="L"
                            {{ old('jenis_kelamin', $instruktur->jenis_kelamin) == 'L' ? 'selected' : '' }}>Male
                        </option>
                        <option value="P"
                            {{ old('jenis_kelamin', $instruktur->jenis_kelamin) == 'P' ? 'selected' : '' }}>Female
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
                        <option value="{{ $agama }}"
                            {{ old('agama', $instruktur->agama) == $agama ? 'selected' : '' }}>
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
                    <input type="text" name="pengalaman" id="pengalaman"
                        value="{{ old('pengalaman', $instruktur->pengalaman) }}"
                        class="form-control @error('pengalaman') is-invalid @enderror" required>
                    @error('pengalaman')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="no_hp" class="mb-2">Phone Number <span class="text-danger">*</span></label>
                    <input type="number" name="no_hp" id="no_hp" value="{{ old('no_hp', $instruktur->no_hp) }}"
                        class="form-control @error('no_hp') is-invalid @enderror" required>
                    @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="biografi" class="mb-2">Biography</label>
                    <textarea name="biografi" id="biografi" rows="4"
                        class="form-control @error('biografi') is-invalid @enderror">{{ old('biografi', $instruktur->biografi) }}</textarea>
                    @error('biografi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="is_active" class="mb-2">Currently Working <span class="text-danger">*</span></label>
                    <input type="date" name="is_active"
                        class="form-control @error('is_active') is-invalid @enderror"
                        value="{{ old('is_active', $instruktur->is_active) }}">
                    @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @php
                $socials = [
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'twitter' => 'Twitter',
                'tiktok' => 'TikTok',
                'youtube' => 'YouTube',
                ];
                @endphp

                @foreach ($socials as $key => $label)
                <div class="form-group mb-3">
                    <label for="{{ $key }}" class="mb-2">Link {{ $label }}</label>
                    <input type="text" name="{{ $key }}" id="{{ $key }}"
                        value="{{ old($key, $instruktur->$key) }}"
                        class="form-control @error($key) is-invalid @enderror">
                    @error($key)
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @endforeach

                <div class="form-group text-right mt-4">
                    <a href="{{ route('instruktur.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button class="btn btn-danger">Update</button>
                </div>

            </form>

        </div>
    </div>
</section>

@endsection