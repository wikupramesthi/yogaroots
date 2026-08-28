<!-- Modals add menu -->
<div id="modal-form-add-banner" class="modal fade modal-form-banner" tabindex="-1" aria-labelledby="modal-form-add-banner-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="modal-form" action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-banner-label">Tambah Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="nama" class="mb-2">Nama Media <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama Media" name="nama" value="{{ old('nama') }}" required>
            @error('nama')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="posisi" class="mb-2">Posisi <span class="text-danger">*</span></label>
            <select name="posisi" id="posisi" class="form-control @error('posisi') is-invalid @enderror" required>
              <option value="">-- Pilih --</option>
              <option value="slider" {{ old('posisi') == 'slider' ? 'selected' : '' }}>Banner / Slider</option>
              <option value="pengumuman" {{ old('posisi') == 'pengumuman' ? 'selected' : '' }}>Pengumuman</option>
              <option value="infografis" {{ old('posisi') == 'infografis' ? 'selected' : '' }}>Infografis</option>
              <option value="galeri" {{ old('posisi') == 'galeri' ? 'selected' : '' }}>Galeri Foto</option>
              <option value="popup" {{ old('posisi') == 'popup' ? 'selected' : '' }}>Popup</option>
              <option value="mitra" {{ old('posisi') == 'mitra' ? 'selected' : '' }}>Mitra</option>
              <option value="lainnya" {{ old('posisi') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('posisi')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="deskripsi" class="mb-2">Deskripsi</label>
            <textarea type="text" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" rows="3"></textarea>
            @error('deskripsi')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="status" class="mb-2">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
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
            <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" placeholder="Link" name="link" value="{{ old('link') }}">
            @error('link')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="foto" class="mb-2">Gambar <span class="text-danger">*</span></label>
            <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" value="{{ old('gambar') }}" required>
            @error('gambar')
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