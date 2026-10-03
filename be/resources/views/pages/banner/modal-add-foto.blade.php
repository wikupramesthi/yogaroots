<div id="modal-add-foto" class="modal fade" tabindex="-1" aria-labelledby="modal-add-foto-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tipe" value="foto">

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-add-foto-label">
                        <i class="bx bx-image-add text-primary"></i> Add Photo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <label class="form-label">Photo <span class="text-danger">*</span></label>
                            <div class="upload-preview" id="addFotoPreview">
                                <span class="upload-preview-label">
                                    <i class="bx bx-cloud-upload fs-2"></i>
                                    Click to choose an image
                                </span>
                                <img src="" alt="preview" class="upload-preview-img">
                            </div>
                            <input type="file" name="gambar" class="form-control mt-2 media-image-input" data-preview="#addFotoPreview" accept="image/*" required>
                            <div class="form-text"><i class="bi bi-info-circle"></i> JPG, PNG, WEBP format. Max 5 MB.</div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group mb-3">
                                <label for="addFotoNama" class="form-label">Media Name <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="addFotoNama" class="form-control" placeholder="e.g. Anniversary Banner" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="addFotoPosisi" class="form-label">Position <span class="text-danger">*</span></label>
                                <select name="posisi" id="addFotoPosisi" class="form-select" required>
                                    <option value="">-- Select position --</option>
                                    <option value="slider">Banner / Slider (1643 x 544)</option>
                                    <option value="pengumuman">Announcement</option>
                                    <option value="infografis">Infographic</option>
                                    <option value="galeri">Photo Gallery</option>
                                    <option value="popup">Popup</option>
                                    <option value="mitra">Partners (615 x 380)</option>
                                    <option value="lainnya">Others</option>
                                </select>
                                <div class="form-text">This photo can be used as a banner, announcement, gallery, etc.</div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="addFotoAlbum" class="form-label">Add to Albums <span class="text-muted">(optional)</span></label>
                                <select name="album_ids[]" id="addFotoAlbum" class="form-select media-album-select" multiple>
                                    @foreach (($albumOptions ?? $albums ?? []) as $album)
                                    <option value="{{ $album->uuid }}">{{ $album->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="addFotoStatus" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="addFotoStatus" class="form-select" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="addFotoLink" class="form-label">Link</label>
                                        <input type="text" name="link" id="addFotoLink" class="form-control" placeholder="https://...">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label for="addFotoDeskripsi" class="form-label">Description</label>
                                <textarea name="deskripsi" id="addFotoDeskripsi" class="form-control" rows="2" placeholder="Short description (optional)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-cloud-arrow-up"></i> Save Photo</button>
                </div>
            </form>
        </div>
    </div>
</div>
