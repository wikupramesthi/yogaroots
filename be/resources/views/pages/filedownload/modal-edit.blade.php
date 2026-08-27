<div id="modal-form-edit-dokumen-{{ $item->id }}" class="modal fade modal-form-dokumen-edit" tabindex="-1"
  aria-labelledby="modal-form-edit-dokumen-{{ $item->id }}-label" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('filedownload.update', $item->id) }}" method="post">
        @csrf
        @method('PUT')

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-edit-dokumen-{{ $item->id }}-label">Edit Dokumen
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">

          <div class="form-group mb-3">
            <label for="judul" class="mb-2">Nama Dokumen <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" placeholder="Nama Dokumen" name="judul" value="{{ $item->judul ?? old('judul') }}" required>
            @error('judul')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="deskripsi" class="mb-2">Deskripsi <span class="text-danger">*</span></label>
            <textarea type="text" class="form-control @error('deskripsi') is-invalid @enderror" id="desc" placeholder="Deskripsi" name="deskripsi" value="{{ $item->deskripsi ?? old('deskripsi') }}" required>{{ $item->deskripsi ?? old('deskripsi') }}</textarea>
            @error('deskripsi')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="kategori" class="mb-2">Kategori <span class="text-danger">*</span></label>
            <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" require>
              <option value="">-- Pilih --</option>
              <option value="akademik" {{ (isset($item) && $item->kategori == 'akademik') || old('kategori') == 'akademik' ? 'selected' : '' }}>Dokumen Kurikulum/option>
              <option value="informasi" {{ (isset($item) && $item->kategori == 'informasi') || old('kategori') == 'informasi' ? 'selected' : '' }}>Informasi Publik</option>
              <option value="laporan" {{ (isset($item) && $item->kategori == 'laporan') || old('kategori') == 'laporan' ? 'selected' : '' }}>Laporan Sekolah</option>
              <option value="edaran" {{ (isset($item) && $item->kategori == 'edaran') || old('kategori') == 'edaran' ? 'selected' : '' }}>Surat Edaran</option>
            </select>
            @error('kategori')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="file" class="mb-2">Upload File <span class="text-danger">*</span></label>
            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" value="{{ $item->file ?? old('file') }}">
            @error('file')
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