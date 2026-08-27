<!-- Modals add menu -->
<div id="modal-form-add-program" class="modal fade modal-form-program" tabindex="-1"
    aria-labelledby="modal-form-add-program-label" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px !important;">
        <div class="modal-content">

            <form id="modal-form" action="{{ route('program.modalStore') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-add-program-label">
                        Biodata Calon Murid
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-danger mb-4">
                        Orang Tua/Wali akan dihubungi melalui
                        <strong>WhatsApp</strong>
                        untuk informasi pendaftaran dan tahap wawancara.
                    </div>

                    <!-- DISABILITY -->
                    <div class="form-group mb-3">
                        <label class="mb-2">
                            Kriteria Disabilitas
                            <span class="text-danger">*</span>
                        </label>

                        <select name="disability_uuid"
                            class="form-control @error('disability_uuid') is-invalid @enderror"
                            required>

                            <option value="">-- Pilih Disabilitas --</option>

                            @foreach ($disabilities as $disability)
                                <option value="{{ $disability->uuid }}"
                                    {{ old('disability_uuid') == $disability->uuid ? 'selected' : '' }}>

                                    {{ $disability->name }}

                                </option>
                            @endforeach
                        </select>

                        @error('disability_uuid')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- NAMA ANAK -->
                    <div class="form-group mb-3">
                        <label class="mb-2">
                            Nama Anak
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            name="nama_anak"
                            class="form-control @error('nama_anak') is-invalid @enderror"
                            value="{{ old('nama_anak') }}"
                            required>

                        @error('nama_anak')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- TEMPAT & TANGGAL LAHIR -->
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label class="mb-2">
                                    Tempat Lahir
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="tempat_lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    value="{{ old('tempat_lahir') }}"
                                    required>

                                @error('tempat_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label class="mb-2">
                                    Tanggal Lahir
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="date"
                                    name="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir') }}"
                                    required>

                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                    </div>

                    <!-- JENIS KELAMIN -->
                    <div class="form-group mb-3">

                        <label class="mb-2">
                            Jenis Kelamin
                            <span class="text-danger">*</span>
                        </label>

                        <select name="jenis_kelamin"
                            class="form-control @error('jenis_kelamin') is-invalid @enderror"
                            required>

                            <option value="">-- Pilih Jenis Kelamin --</option>

                            <option value="L"
                                {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="P"
                                {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>

                        @error('jenis_kelamin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- AGAMA -->
                    <div class="form-group mb-3">

                        <label class="mb-2">
                            Agama
                            <span class="text-danger">*</span>
                        </label>

                        <select name="agama"
                            class="form-control @error('agama') is-invalid @enderror"
                            required>

                            <option value="">-- Pilih Agama --</option>

                            <option value="islam"
                                {{ old('agama') == 'islam' ? 'selected' : '' }}>
                                Islam
                            </option>

                            <option value="kristen"
                                {{ old('agama') == 'kristen' ? 'selected' : '' }}>
                                Kristen
                            </option>

                            <option value="katolik"
                                {{ old('agama') == 'katolik' ? 'selected' : '' }}>
                                Katolik
                            </option>

                            <option value="hindu"
                                {{ old('agama') == 'hindu' ? 'selected' : '' }}>
                                Hindu
                            </option>

                            <option value="buddha"
                                {{ old('agama') == 'buddha' ? 'selected' : '' }}>
                                Buddha
                            </option>

                            <option value="konghucu"
                                {{ old('agama') == 'konghucu' ? 'selected' : '' }}>
                                Konghucu
                            </option>

                        </select>

                        @error('agama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- ANAK KE -->
                    <div class="form-group mb-3">

                        <label class="mb-2">
                            Anak Ke
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number"
                            name="anak_ke"
                            class="form-control @error('anak_ke') is-invalid @enderror"
                            value="{{ old('anak_ke') }}"
                            required>

                        @error('anak_ke')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- NAMA ORANG TUA -->
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label class="mb-2">
                                    Nama Ayah
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="nama_ayah"
                                    class="form-control @error('nama_ayah') is-invalid @enderror"
                                    value="{{ old('nama_ayah') }}"
                                    required>

                                @error('nama_ayah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">

                                <label class="mb-2">
                                    Nama Ibu
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="nama_ibu"
                                    class="form-control @error('nama_ibu') is-invalid @enderror"
                                    value="{{ old('nama_ibu') }}"
                                    required>

                                @error('nama_ibu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                    </div>

                    <!-- ALAMAT -->
                    <div class="form-group mb-3">

                        <label class="mb-2">
                            Alamat
                            <span class="text-danger">*</span>
                        </label>

                        <textarea name="alamat"
                            rows="3"
                            class="form-control @error('alamat') is-invalid @enderror"
                            required>{{ old('alamat') }}</textarea>

                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- NO HP -->
                    <div class="form-group mb-3">

                        <label class="mb-2">
                            No HP / WhatsApp
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                            name="no_hp"
                            class="form-control @error('no_hp') is-invalid @enderror"
                            value="{{ old('no_hp') }}"
                            required>

                        @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                        class="btn btn-primary">
                        Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>