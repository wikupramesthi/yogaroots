<!-- Modals add menu -->
<div id="modal-form-edit-banner-{{ $item->uuid }}" class="modal fade modal-form-banner-edit" tabindex="-1"
    aria-labelledby="modal-form-edit-banner-{{ $item->uuid }}-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('banner.update', $item->uuid) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-edit-banner-{{ $item->uuid }}-label">Edit Banner
                        ({{ $item->nama }})
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">

                    <div class="form-group mb-3">
                        <label for="nama" class="mb-2">Nama Media <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            placeholder="Nama Media" name="nama" value="{{ $item->nama ?? old('nama') }}" required>
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="posisi" class="mb-2">Posisi <span class="text-danger">*Banner Slider ukuran (970 x 545 px)</span></label>
                        <select name="posisi" id="posisi" class="form-control @error('posisi') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih --</option>
                            <option value="slider"
                                {{ (isset($item) && $item->posisi == 'slider') || old('posisi') == 'slider' ? 'selected' : '' }}>
                                Banner / Slider</option>
                            <option value="pengumuman"
                                {{ (isset($item) && $item->posisi == 'pengumuman') || old('posisi') == 'pengumuman' ? 'selected' : '' }}>
                                Pengumuman</option>
                            <option value="infografis"
                                {{ (isset($item) && $item->posisi == 'infografis') || old('posisi') == 'infografis' ? 'selected' : '' }}>
                                Infografis</option>
                            <option value="galeri"
                                {{ (isset($item) && $item->posisi == 'galeri') || old('galeri') == 'galeri' ? 'selected' : '' }}>
                                Galeri Foto</option>
                            <option value="popup"
                                {{ (isset($item) && $item->posisi == 'popup') || old('posisi') == 'popup' ? 'selected' : '' }}>
                                Popup</option>
                            <option value="mitra"
                                {{ (isset($item) && $item->posisi == 'mitra') || old('posisi') == 'mitra' ? 'selected' : '' }}>
                                Mitra</option>
                            <option value="lainnya"
                                {{ (isset($item) && $item->posisi == 'lainnya') || old('posisi') == 'lainnya' ? 'selected' : '' }}>
                                Lainnya</option>
                        </select>

                        @error('posisi')
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
                        <label for="deskripsi" class="mb-2">Deskripsi</label>
                        <textarea type="text" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Deskripsi"
                            name="deskripsi" value="{{ $item->deskripsi ?? old('deskripsi') }}" rows="3">{{ $item->deskripsi ?? old('deskripsi') }}</textarea>
                        @error('deskripsi')
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
                        <label for="foto" class="mb-2">Gambar <span class="text-danger">*</span></label>
                        <input type="file" name="gambar" id="gambar"
                            class="form-control @error('gambar') is-invalid @enderror"
                            value="{{ $item->gambar ?? old('gambar') }}">
                        @error('gambar')
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