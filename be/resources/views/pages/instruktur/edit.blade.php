@extends('layouts.app')
@section('title', 'Data Pegawai')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Edit Pegawai" page="Data Pegawai" active="Edit Pegawai" route="{{ route('pegawai.index') }}" />
@endsection

<!-- Content -->
<section class="section">
    <div class="card">
        <div class="card-body">

            <form action="{{ route('pegawai.update', $pegawai->uuid) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="avatar" class="mb-2">Foto Pegawai <span class="text-danger">*</span></label>
                    <input type="file" name="avatar" id="avatar"
                        class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                    @if ($pegawai->avatar)
                        <small class="text-muted">Foto saat ini: <a href="{{ asset('storage/' . $pegawai->avatar) }}"
                                target="_blank">Lihat</a></small>
                    @endif
                    @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nik" class="mb-2">NIK/NIP <span class="text-danger">*</span></label>
                    <input type="number" name="nik" id="nik" value="{{ old('nik', $pegawai->nik) }}"
                        class="form-control @error('nik') is-invalid @enderror" required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="name" class="mb-2">Nama Lengkap <span class="text-danger">*beserta
                            gelar</span></label>
                    <input type="text" name="name" id="name" placeholder="Nama Lengkap beserta Gelar"
                        value="{{ old('name', $pegawai->name) }}"
                        class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="mb-2">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $pegawai->email) }}"
                        class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir" class="mb-2">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir"
                            value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}"
                            class="form-control @error('tempat_lahir') is-invalid @enderror" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="mb-2">Tanggal Lahir <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir) }}"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="jenis_kelamin" class="mb-2">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="L"
                            {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-Laki
                        </option>
                        <option value="P"
                            {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="agama" class="mb-2">Agama <span class="text-danger">*</span></label>
                    <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Agama --</option>
                        @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $agama)
                            <option value="{{ $agama }}"
                                {{ old('agama', $pegawai->agama) == $agama ? 'selected' : '' }}>
                                {{ $agama }}</option>
                        @endforeach
                    </select>
                    @error('agama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jabatan" class="mb-2">Jabatan <span class="text-danger">*Contoh : Guru Olahraga</span></label>
                    <input type="text" name="jabatan" id="jabatan"
                        value="{{ old('jabatan', $pegawai->jabatan) }}"
                        class="form-control @error('jabatan') is-invalid @enderror" required>
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="kepegawaian" class="mb-2">Status Kepegawaian <span
                            class="text-danger">*</span></label>
                    <select name="kepegawaian" id="kepegawaian"
                        class="form-control @error('kepegawaian') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        @foreach (['asn', 'honorer', 'magang', 'lainnya'] as $status)
                            <option value="{{ $status }}"
                                {{ old('kepegawaian', $pegawai->kepegawaian) == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    @error('kepegawaian')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="no_hp" class="mb-2">Nomor Handphone <span class="text-danger">*</span></label>
                    <input type="number" name="no_hp" id="no_hp" value="{{ old('no_hp', $pegawai->no_hp) }}"
                        class="form-control @error('no_hp') is-invalid @enderror" required>
                    @error('no_hp')
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
                            value="{{ old($key, $pegawai->$key) }}"
                            class="form-control @error($key) is-invalid @enderror">
                        @error($key)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <div class="form-group mb-3">
                    <label for="biografi" class="mb-2">Biografi</label>
                    <textarea name="biografi" id="biografi" rows="4"
                        class="form-control @error('biografi') is-invalid @enderror">{{ old('biografi', $pegawai->biografi) }}</textarea>
                    @error('biografi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="is_active" class="mb-2">Mulai Bekerja <span class="text-danger">*</span></label>
                    <input type="date" name="is_active"
                        class="form-control @error('is_active') is-invalid @enderror"
                        value="{{ old('is_active', $pegawai->is_active) }}">
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="file_pendukung" class="mb-2">File Pendukung (PDF)</label>
                    <input type="file" name="file_pendukung" id="file_pendukung"
                        class="form-control @error('file_pendukung') is-invalid @enderror" accept="application/pdf">
                    @if ($pegawai->file_pendukung)
                        <small class="text-muted">File saat ini: <a
                                href="{{ asset('storage/' . $pegawai->file_pendukung) }}"
                                target="_blank">Lihat</a></small>
                    @endif
                    @error('file_pendukung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group text-right mt-4">
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button class="btn btn-danger">Update</button>
                </div>

            </form>

        </div>
    </div>
</section>

@endsection
