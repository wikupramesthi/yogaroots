<!-- Modals add menu -->
<div id="modal-form-edit-program-{{ $item->uuid }}" class="modal fade modal-form-program-edit" tabindex="-1"
    aria-labelledby="modal-form-edit-program-{{ $item->uuid }}-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" style="
    max-width: 800px !important;">
        <div class="modal-content">
            <form action="{{ route('program.modalUpdate', $item->uuid) }}" method="post">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-edit-program-{{ $item->id }}-label">Edit Kompetisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>

                <div class="modal-body" style="text-align: left;">

                    <div class="alert alert-info mb-4">
                        Perubahan data akan digunakan untuk proses
                        verifikasi pendaftaran calon murid
                        <strong>SLB Patriot Kota Bekasi</strong>.
                    </div>

                    <!-- DISABILITY -->
                    <div class="form-group mb-3">

                        <label class="mb-2">
                            Kriteria Disabilitas
                            <span class="text-danger">*</span>
                        </label>

                        <select name="disability_uuid"
                            class="form-control @error('disability_uuid') is-invalid @enderror" required>

                            <option value="">
                                -- Pilih Disabilitas --
                            </option>

                            @foreach ($disabilities as $disability)
                                <option value="{{ $disability->uuid }}"
                                    {{ $item->disability_uuid == $disability->uuid ? 'selected' : '' }}>

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

                        <input type="text" name="nama_anak"
                            class="form-control @error('nama_anak') is-invalid @enderror" value="{{ $item->nama_anak }}"
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

                                <input type="text" name="tempat_lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    value="{{ $item->tempat_lahir }}" required>

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

                                <input type="date" name="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ $item->tanggal_lahir }}" required>

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

                        <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Pilih Jenis Kelamin --
                            </option>

                            <option value="L" {{ $item->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="P" {{ $item->jenis_kelamin == 'P' ? 'selected' : '' }}>
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

                        <select name="agama" class="form-control @error('agama') is-invalid @enderror" required>

                            <option value="">-- Pilih Agama --</option>

                            <option value="islam" {{ $item->agama == 'islam' ? 'selected' : '' }}>
                                Islam
                            </option>

                            <option value="kristen" {{ $item->agama == 'kristen' ? 'selected' : '' }}>
                                Kristen
                            </option>

                            <option value="katolik" {{ $item->agama == 'katolik' ? 'selected' : '' }}>
                                Katolik
                            </option>

                            <option value="hindu" {{ $item->agama == 'hindu' ? 'selected' : '' }}>
                                Hindu
                            </option>

                            <option value="buddha" {{ $item->agama == 'buddha' ? 'selected' : '' }}>
                                Buddha
                            </option>

                            <option value="konghucu" {{ $item->agama == 'konghucu' ? 'selected' : '' }}>
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

                        <input type="number" name="anak_ke" class="form-control @error('anak_ke') is-invalid @enderror"
                            value="{{ $item->anak_ke }}" required>

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

                                <input type="text" name="nama_ayah"
                                    class="form-control @error('nama_ayah') is-invalid @enderror"
                                    value="{{ $item->nama_ayah }}" required>

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

                                <input type="text" name="nama_ibu"
                                    class="form-control @error('nama_ibu') is-invalid @enderror"
                                    value="{{ $item->nama_ibu }}" required>

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

                        <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" required>{{ $item->alamat }}</textarea>

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

                        <input type="text" name="no_hp"
                            class="form-control @error('no_hp') is-invalid @enderror" value="{{ $item->no_hp }}"
                            required>

                        @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary ">Update</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
