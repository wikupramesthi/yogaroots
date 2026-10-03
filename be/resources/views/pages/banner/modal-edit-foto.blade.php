<div id="modal-edit-foto-{{ $item->uuid }}" class="modal fade" tabindex="-1" aria-labelledby="modal-edit-foto-{{ $item->uuid }}-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('banner.update', $item->uuid) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="tipe" value="foto">

                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-foto-{{ $item->uuid }}-label">
                        <i class="bx bx-image-edit text-primary"></i> Edit Photo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <label class="form-label">Photo</label>
                            <div class="upload-preview has-img" id="editFotoPreview{{ $item->uuid }}">
                                <span class="upload-preview-label">
                                    <i class="bx bx-cloud-upload fs-2"></i>
                                    Click to replace the image
                                </span>
                                <img src="{{ $item->gambar() }}" class="upload-preview-img">
                            </div>
                            <input type="file" name="gambar" class="form-control mt-2 media-image-input" data-preview="#editFotoPreview{{ $item->uuid }}" accept="image/*">
                            <div class="form-text"><i class="bi bi-info-circle"></i> Leave empty to keep the current photo.</div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group mb-3">
                                <label for="editFotoNama{{ $item->uuid }}" class="form-label">Media Name <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="editFotoNama{{ $item->uuid }}" class="form-control" value="{{ $item->nama }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="editFotoPosisi{{ $item->uuid }}" class="form-label">Position <span class="text-danger">*</span></label>
                                <select name="posisi" id="editFotoPosisi{{ $item->uuid }}" class="form-select" required>
                                    <option value="slider" @selected($item->posisi === 'slider')>Banner / Slider (1643 x 544)</option>
                                    <option value="pengumuman" @selected($item->posisi === 'pengumuman')>Announcement</option>
                                    <option value="infografis" @selected($item->posisi === 'infografis')>Infographic</option>
                                    <option value="galeri" @selected($item->posisi === 'galeri')>Photo Gallery</option>
                                    <option value="popup" @selected($item->posisi === 'popup')>Popup</option>
                                    <option value="mitra" @selected($item->posisi === 'mitra')>Partners (615 x 380)</option>
                                    <option value="lainnya" @selected($item->posisi === 'lainnya')>Others</option>
                                </select>
                                <div class="form-text">This photo can be used as a banner, announcement, gallery, etc.</div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="editFotoAlbum{{ $item->uuid }}" class="form-label">Add to Albums <span class="text-muted">(optional)</span></label>
                                <select name="album_ids[]" id="editFotoAlbum{{ $item->uuid }}" class="form-select media-album-select" multiple>
                                    @foreach ($albums as $album)
                                    <option value="{{ $album->uuid }}" @selected($item->albums->pluck('uuid')->contains($album->uuid))>{{ $album->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="editFotoStatus{{ $item->uuid }}" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="editFotoStatus{{ $item->uuid }}" class="form-select" required>
                                            <option value="active" @selected($item->status === 'active')>Active</option>
                                            <option value="inactive" @selected($item->status === 'inactive')>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="editFotoLink{{ $item->uuid }}" class="form-label">Link</label>
                                        <input type="text" name="link" id="editFotoLink{{ $item->uuid }}" class="form-control" value="{{ $item->link }}" placeholder="https://...">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <label for="editFotoDeskripsi{{ $item->uuid }}" class="form-label">Description</label>
                                <textarea name="deskripsi" id="editFotoDeskripsi{{ $item->uuid }}" class="form-control" rows="2" placeholder="Short description (optional)">{{ $item->deskripsi }}</textarea>
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
