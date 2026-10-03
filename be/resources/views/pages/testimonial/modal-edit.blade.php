<!-- Modals add menu -->
<div id="modal-form-edit-testimonial-{{ $item->uuid }}" class="modal fade modal-form-testimonial-edit" tabindex="-1"
    aria-labelledby="modal-form-edit-testimonial-{{ $item->uuid }}-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('testimonial.update', $item->uuid) }}" method="post">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-edit-testimonial-{{ $item->uuid }}-label">Edit Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="foto" class="mb-2">Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto"
                            placeholder="Photo" name="foto" value="{{ old('foto') }}" accept="image/*">
                        @error('foto')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        @if ($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Photo" class="img-thumbnail mt-2"
                            style="max-width: 150px;">
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama" class="mb-2">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            placeholder="Full Name" name="nama" value="{{ $item->nama ?? old('nama') }}" required>
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="jabatan" class="mb-2">Joined Since <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                            placeholder="Joined Since" name="jabatan"
                            value="{{ $item->jabatan ?? old('jabatan') }}">
                        @error('jabatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="isi_testimoni" class="mb-2">Testimonial Content <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('isi_testimoni') is-invalid @enderror" id="isi_testimoni"
                            placeholder="Testimonial Content" name="isi_testimoni" required>{{ $item->isi_testimoni ?? old('isi_testimoni') }}</textarea>
                        @error('isi_testimoni')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="urutan" class="mb-2">Order <span class="text-danger">*Ensure the order is unique</span></label>
                        <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan"
                            placeholder="Order" name="urutan" value="{{ $item->urutan ?? old('urutan') }}" required>
                        @error('urutan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="is_active" class="mb-2">Status <span class="text-danger">*</span></label>
                        <select name="is_active" id="is_active"
                            class="form-control @error('is_active') is-invalid @enderror" required>
                            <option value="">-- Select --</option>
                            <option value="active"
                                {{ (isset($item) && $item->is_active == 'active') || old('is_active') == 'active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="inactive"
                                {{ (isset($item) && $item->is_active == 'inactive') || old('is_active') == 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                        @error('is_active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary ">Update</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->