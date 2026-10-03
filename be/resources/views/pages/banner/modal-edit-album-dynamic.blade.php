<div id="modal-edit-album-{{ $album->uuid }}" class="modal fade" tabindex="-1" aria-labelledby="modal-edit-album-{{ $album->uuid }}-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('banner.updateAlbum', $album->uuid) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-album-{{ $album->uuid }}-label">
                        <i class="bx bx-folder text-success"></i> Edit Album
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Album Name <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" value="{{ $album->nama }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="deskripsi" class="form-control" rows="2" placeholder="Album description (optional)">{{ $album->deskripsi }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="active" @selected($album->status === 'active')>Active</option>
                                    <option value="inactive" @selected($album->status === 'inactive')>Inactive</option>
                                </select>
                            </div>
                            <div class="alert alert-info mb-0 py-2 small">
                                <i class="bi bi-info-circle"></i> Tick photos on the right. The first selected photo becomes the cover.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Select Photos <span class="text-danger">*</span></label>
                                <span class="media-picker-count badge bg-primary">loading...</span>
                            </div>
                            <input type="text" class="form-control form-control-sm mb-2 media-picker-search" data-target="#editAlbumScope{{ $album->uuid }}" placeholder="Search photos..." autocomplete="off">
                            <div class="media-modal-photos" id="editAlbumScope{{ $album->uuid }}" data-selected="{{ implode(',', $selected ?? []) }}">
                                <p class="text-muted small mb-0">Loading photos...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
