<!-- Modals add menu -->
<div id="modal-form-edit-service-{{ $item->uuid }}" class="modal fade modal-form-service-edit" tabindex="-1"
    aria-labelledby="modal-form-edit-service-{{ $item->uuid }}-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('services.update', $item->uuid) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-edit-service-{{ $item->uuid }}-label">Edit Layanan
                        ({{ $item->judul }})
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label for="judul" class="mb-2">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                            placeholder="Nama Kegiatan" name="judul" value="{{ $item->judul ?? old('judul') }}"
                            required>
                        @error('judul')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi" class="mb-2">Isi Halaman <span class='text-danger'>*</span></label>
                        <textarea name="deskripsi" cols="30" rows="5" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="kategori_layanan" class="mb-2">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_layanan" id="kategori_layanan"
                            class="form-control @error('kategori_layanan') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="ekstrakurikuler"
                                {{ (isset($item) && $item->kategori_layanan == 'ekstrakurikuler') || old('kategori_layanan') == 'ekstrakurikuler' ? 'selected' : '' }}>
                                Ekstrakurikuler
                            </option>
                            <option value="kegiatan"
                                {{ (isset($item) && $item->kategori_layanan == 'kegiatan') || old('kategori_layanan') == 'kegiatan' ? 'selected' : '' }}>
                                Kegiatan Sekolah
                            </option>
                            <option value="bimbingan"
                                {{ (isset($item) && $item->kategori_layanan == 'bimbingan') || old('kategori_layanan') == 'bimbingan' ? 'selected' : '' }}>
                                Bimbingan Akademik
                            </option>

                        </select>

                        @error('kategori_layanan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="form-group mb-3">
                        <label for="kategori_layanan" class="mb-2">Warna Tampilan <span
                                class="text-danger">*</span></label>
                        <select name="color" id="color" class="form-control @error('color') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Warna --</option>
                            <option value="blue" {{ old('color', $item->color ?? '') == 'blue' ? 'selected' : '' }}>
                                Biru</option>
                            <option value="orange"
                                {{ old('color', $item->color ?? '') == 'orange' ? 'selected' : '' }}>Orange</option>
                            <option value="green" {{ old('color', $item->color ?? '') == 'green' ? 'selected' : '' }}>
                                Hijau</option>
                            <option value="red" {{ old('color', $item->color ?? '') == 'red' ? 'selected' : '' }}>
                                Merah</option>
                            <option value="yellow"
                                {{ old('color', $item->color ?? '') == 'yellow' ? 'selected' : '' }}>Kuning</option>
                            <option value="purple"
                                {{ old('color', $item->color ?? '') == 'purple' ? 'selected' : '' }}>Ungu</option>
                            <option value="cyan" {{ old('color', $item->color ?? '') == 'cyan' ? 'selected' : '' }}>
                                Cyan</option>
                            <option value="pink" {{ old('color', $item->color ?? '') == 'pink' ? 'selected' : '' }}>
                                Pink</option>
                            <option value="teal" {{ old('color', $item->color ?? '') == 'teal' ? 'selected' : '' }}>
                                Teal</option>
                            <option value="brown" {{ old('color', $item->color ?? '') == 'brown' ? 'selected' : '' }}>
                                Coklat</option>
                        </select>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @error('kategori_layanan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="mb-2">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih --</option>
                            <option value="active"
                                {{ (isset($item) && $item->status == 'active') || old('status') == 'active' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="inactive"
                                {{ (isset($item) && $item->status == 'inactive') || old('status') == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="link" class="mb-2">Link </label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="link"
                            placeholder="Link" name="link" value="{{ $item->link ?? old('link') }}">
                        @error('link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="foto" class="mb-2">Gambar/icon <span class="text-danger">*</span></label>
                        <input type="file" name="icon" id="icon"
                            class="form-control @error('icon') is-invalid @enderror"
                            value="{{ $item->icon ?? old('icon') }}">
                        @error('icon')
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
