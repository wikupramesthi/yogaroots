@extends('layouts.app')

@section('title', 'Profile')

@section('breadcrumb')
<x-breadcrumb title="Profile" page="Pengatuan Akun" active="Profile" route="{{ route('profile.edit') }}" />
@endsection

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
    <span class="alert-text text-white"> {{ session('success') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="alert alert-danger alert-dismissible mb-0 mt-3 fade show position-relative" role="alert">
    <div class="d-flex">
        <i class="bi-exclamation-triangle-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
        <div class="text-white mt-2">
            Lengkapi profil instruktur Anda dengan informasi pribadi, pengalaman, serta keahlian yang Anda miliki.<br>
            Data ini diperlukan untuk melengkapi profil dan membantu peserta mengenal instruktur lebih baik.
        </div>
    </div>
</div>

<div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
    <div class="row">
        <div class="col-xl-4">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Foto Instruktur</div>
                <div class="card-body text-center">
                    <img src="{{ Auth::user()->avatar
                            ? (Str::startsWith(Auth::user()->avatar, 'http')
                                ? Auth::user()->avatar
                                : asset('storage/' . Auth::user()->avatar))
                            : asset('dist/assets/images/avatar.jpg') }}"
                        alt="{{ auth()->user()->name }}" class="img-account-profile img-thumbnail rounded-circle mb-2">
                    <div class="small font-italic text-muted mb-4">JPG or PNG dengan maksimal ukuran 1 Mb</div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">Biodata Diri</div>
                <div class="card-body">
                    <form action="{{ route('account.update', $user->uuid) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="avatar" class="small mb-1">Foto Profil<span class="text-danger"> *Ukuran foto
                                    maksimal 1mb (jpg,png,jpeg)</span></label>
                            <input class="form-control" id="avatar" type="file" name="avatar"
                                accept="image/png,image/jpeg">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="small mb-1">Nama Lengkap<span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="name" type="text" name="name"
                                value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="password">Password (Kosongkan jika tidak ingin
                                diubah)</label>
                            <input class="form-control" id="password" type="password" name="password"
                                autocomplete="new-password">
                        </div>

                        <div class="mb-3">
                            <label for="specializations" class="small mb-1">
                                Specialization <span class="text-danger">*</span>
                            </label>

                            @php
                            $selectedSpecializations = old(
                            'specializations',
                            $user->specializations->pluck('uuid')->toArray()
                            );
                            @endphp

                            <select
                                class="form-select"
                                id="specializations"
                                name="specializations[]"
                                multiple
                                size="5"
                                required>
                                @foreach ($specializations as $specialization)
                                <option
                                    value="{{ $specialization->uuid }}"
                                    {{ in_array($specialization->uuid, $selectedSpecializations) ? 'selected' : '' }}>
                                    {{ $specialization->name }}
                                </option>
                                @endforeach
                            </select>

                            <small class="text-muted">
                                Gunakan Ctrl (Windows) atau Command (Mac) untuk memilih beberapa specialization.
                            </small>

                            @error('specializations')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label for="email" class="small mb-1">Email <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="email" type="email" name="email"
                                    value="{{ old('email', $user->email) }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="no_hp" class="small mb-1">Nomor Whatsapp Aktif <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="no_hp" type="number" name="no_hp"
                                    value="{{ old('no_hp', $user->no_hp) }}" required>
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label for="tempat_lahir" class="small mb-1">Tempat Lahir <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="tempat_lahir" type="text" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_lahir" class="small mb-1">Tanggal Lahir <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" id="tanggal_lahir" type="date" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required>
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="small mb-1">Jenis Kelamin <span
                                        class="text-danger">*</span></label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                        Laki-Laki
                                    </option>
                                    <option value="P"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="nik" class="small mb-1">Agama <span
                                        class="text-danger">*</span></label>
                                <select name="agama" id="agama"
                                    class="form-control @error('agama') is-invalid @enderror" required>
                                    <option value="">-- Pilih Agama --</option>
                                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $agama)
                                    <option value="{{ $agama }}"
                                        {{ old('agama', $user->agama) == $agama ? 'selected' : '' }}>
                                        {{ $agama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label for="facebook" class="small mb-1">Facebook</label>
                                <input class="form-control" id="facebook" type="text" name="facebook"
                                    value="{{ old('facebook', $user->facebook) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="instagram" class="small mb-1">Instagram </label>
                                <input class="form-control" id="instagram" type="text" name="instagram"
                                    value="{{ old('instagram', $user->instagram) }}">
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label for="tiktok" class="small mb-1">Tiktok</label>
                                <input class="form-control" id="tiktok" type="text" name="tiktok"
                                    value="{{ old('tiktok', $user->tiktok) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="youtube" class="small mb-1">Youtube </label>
                                <input class="form-control" id="youtube" type="text" name="youtube"
                                    value="{{ old('youtube', $user->youtube) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="small mb-1">Alamat Domisili <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="alamat" type="text" name="alamat"
                                value="{{ old('alamat', $user->alamat) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="pengalaman" class="small mb-1">Pengalaman <span
                                    class="text-danger">*contoh: sudah 10 tahun</span></label>
                            <input class="form-control" id="alamat" type="text" name="pengalaman"
                                value="{{ old('pengalaman', $user->pengalaman) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="file_pendukung" class="small mb-1">Bografi
                                <span class="text-danger"> *Pengenalan diri Anda</span>
                            </label>
                            <div class="input-group">
                                <textarea name="biografi" id="biografi" rows="4"
                                    class="form-control @error('biografi') is-invalid @enderror">{{ old('biografi', $user->biografi) }}</textarea>
                                @error('biografi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end mt-5">
                            <button class="btn btn-primary" type="submit">Simpan Data</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

</div>

@include('profile.modals-file-preview', ['user' => $user])

@push('before-script')

<!-- Select2 CSS -->
<link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#specializations').select2({
            placeholder: 'Pilih specialization',
            width: '100%',
            closeOnSelect: false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#kecamatan').on('change', function() {
            var kecamatanId = $(this).val();
            var $kelurahan = $('#kelurahan');

            // Kosongkan opsi kelurahan
            $kelurahan.empty().append('<option value="">-- Pilih Kelurahan --</option>');

            if (kecamatanId) {
                $.ajax({
                    url: '/backend/get-kelurahan/' +
                        kecamatanId, // ← di sini harus ada koma setelahnya!
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Tampilkan hasil ke console (debug)
                        console.log("Kelurahan:", data);

                        $.each(data, function(id, nama) {
                            $kelurahan.append('<option value="' + id + '">' + nama +
                                '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error("Gagal:", xhr.responseText);
                        alert('Gagal mengambil data kelurahan');
                    }
                });
            }
        });
    });
</script>
@endpush

@endsection