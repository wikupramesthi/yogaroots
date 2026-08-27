<!-- Modals add menu -->
<div id="modal-form-add-service" class="modal fade modal-form-service" tabindex="-1"
    aria-labelledby="modal-form-add-service-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="modal-form" action="{{ route('services.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-add-service-label">Tambah Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="judul" class="mb-2">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                            placeholder="Nama Kegiatan" name="judul" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi" class="mb-2">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Deskripsi" name="deskripsi"
                            value="{{ old('deskripsi') }}" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="kategori_layanan" class="mb-2">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_layanan" id="kategori_layanan"
                            class="form-control @error('kategori_layanan') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="ekstrakurikuler"
                                {{ old('kategori_layanan') == 'ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler
                            </option>
                            <option value="kegiatan" {{ old('kategori_layanan') == 'kegiatan' ? 'selected' : '' }}>
                                Kegiatan Sekolah</option>
                            <option value="bimbingan" {{ old('kategori_layanan') == 'bimbingan' ? 'selected' : '' }}>
                                Bimbingan Akademik</option>
                        </select>
                        @error('kategori_layanan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="color" class="mb-2">Warna Tampilan <span class="text-danger">*</span></label>
                        <select name="color" id="color" class="form-control @error('color') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Warna --</option>
                            <option value="blue"
                                {{ old('color', $service->color ?? '') == 'blue' ? 'selected' : '' }}>Biru</option>
                            <option value="orange"
                                {{ old('color', $service->color ?? '') == 'orange' ? 'selected' : '' }}>Orange</option>
                            <option value="green"
                                {{ old('color', $service->color ?? '') == 'green' ? 'selected' : '' }}>Hijau</option>
                            <option value="red"
                                {{ old('color', $service->color ?? '') == 'red' ? 'selected' : '' }}>Merah</option>
                            <option value="yellow"
                                {{ old('color', $service->color ?? '') == 'yellow' ? 'selected' : '' }}>Kuning</option>
                            <option value="purple"
                                {{ old('color', $service->color ?? '') == 'purple' ? 'selected' : '' }}>Ungu</option>
                            <option value="cyan"
                                {{ old('color', $service->color ?? '') == 'cyan' ? 'selected' : '' }}>Cyan</option>
                            <option value="pink"
                                {{ old('color', $service->color ?? '') == 'pink' ? 'selected' : '' }}>Pink</option>
                            <option value="teal"
                                {{ old('color', $service->color ?? '') == 'teal' ? 'selected' : '' }}>Teal</option>
                            <option value="brown"
                                {{ old('color', $service->color ?? '') == 'brown' ? 'selected' : '' }}>Coklat</option>
                        </select>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="mb-2">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih --</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="link" class="mb-2">Link</label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="link"
                            placeholder="Link" name="link" value="{{ old('link') }}">
                        @error('link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="foto" class="mb-2">Gambar/icon <span class="text-danger">*</span></label>
                        <input type="file" name="icon" id="icon"
                            class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon') }}"
                            required>
                        @error('icon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary ">Simpan</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
