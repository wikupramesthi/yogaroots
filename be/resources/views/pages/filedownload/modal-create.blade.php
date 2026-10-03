<!-- Modals add menu -->
<div id="modal-form-add-dokumen" class="modal fade modal-form-dokumen" tabindex="-1" aria-labelledby="modal-form-add-dokumen-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="modal-form" action="{{ route('filedownload.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-dokumen-label">Add Document</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="judul" class="mb-2">Document Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" placeholder="Document Name" name="judul" value="{{ old('judul') }}" required>
            @error('judul')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="deskripsi" class="mb-2">Description <span class="text-danger">*</span></label>
            <textarea type="text" class="form-control @error('deskripsi') is-invalid @enderror" id="desc" placeholder="Description" name="deskripsi" value="{{ old('deskripsi') }}" required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="kategori" class="mb-2">Category <span class="text-danger">*</span></label>
            <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
              <option value="">-- Select --</option>
              <option value="akademik">Curriculum Document</option>
              <option value="informasi">Public Information</option>
              <option value="laporan">School Report</option>
              <option value="edaran">Circular Letter</option>
            </select>
            @error('kategori')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label for="file" class="mb-2">Upload File <span class="text-danger">*</span></label>
            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" value="{{ old('file') }}">
            @error('file')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary ">Save</button>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->