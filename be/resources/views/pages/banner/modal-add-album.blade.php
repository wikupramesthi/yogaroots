<div id="modal-add-album" class="modal fade" tabindex="-1" aria-labelledby="modal-add-album-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('banner.storeAlbum') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-album-label">
                        <i class="bx bx-folder-plus text-success"></i> Create Album
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="addAlbumNama" class="form-label">Album Name <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="addAlbumNama" class="form-control" placeholder="e.g. Work Meeting 2026" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="addAlbumDeskripsi" class="form-label">Description</label>
                                <textarea name="deskripsi" id="addAlbumDeskripsi" class="form-control" rows="2" placeholder="Album description (optional)"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="addAlbumStatus" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="addAlbumStatus" class="form-select" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
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
                            <input type="text" class="form-control form-control-sm mb-2 media-picker-search" data-target="#addAlbumScope" placeholder="Search photos..." autocomplete="off">
                            <div class="media-modal-photos" id="addAlbumScope" data-selected="">
                                <p class="text-muted small mb-0">Loading photos...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-folder-check"></i> Create Album</button>
                </div>
            </form>
        </div>
    </div>
</div>
