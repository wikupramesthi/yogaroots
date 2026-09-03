<!-- Modals add menu -->
<div id="modal-form-edit-events-{{ $item->uuid }}" class="modal fade modal-form-events-edit" tabindex="-1"
    aria-labelledby="modal-form-edit-events-{{ $item->uuid }}-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('events.update', $item->uuid) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-edit-events-{{ $item->uuid }}-label">Edit Events
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>

                <div class="modal-body">

                    {{-- Judul --}}
                    <div class="form-group mb-3">
                        <label for="judul" class="mb-2">
                            Event Name <span class="text-danger">*</span>
                        </label>

                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                            name="judul" placeholder="Event Name" value="{{ old('judul', $item->judul) }}"
                            required>

                        @error('judul')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="row">

                        {{-- Tanggal --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tanggal" class="mb-2">
                                    Date <span class="text-danger">*</span>
                                </label>

                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal"
                                    value="{{ old('tanggal', $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') : '') }}"
                                    required>

                                @error('tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="lokasi" class="mb-2">
                                    Location
                                </label>

                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                    id="lokasi" name="lokasi" placeholder="Event Location"
                                    value="{{ old('lokasi', $item->lokasi) }}">

                                @error('lokasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        {{-- Waktu Mulai --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="waktu_mulai" class="mb-2">
                                    Start Time
                                </label>

                                <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror"
                                    id="waktu_mulai" name="waktu_mulai"
                                    value="{{ old('waktu_mulai', $item->waktu_mulai ? \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') : '') }}">

                                @error('waktu_mulai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="waktu_selesai" class="mb-2">
                                    End Time
                                </label>

                                <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror"
                                    id="waktu_selesai" name="waktu_selesai"
                                    value="{{ old('waktu_selesai', $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') : '') }}">

                                @error('waktu_selesai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Kapasitas --}}
                    <div class="form-group mb-3">
                        <label for="kapasitas" class="mb-2">
                            Capacity
                        </label>

                        <input type="number" class="form-control @error('kapasitas') is-invalid @enderror"
                            id="kapasitas" name="kapasitas" placeholder="Number of Participants" min="1"
                            value="{{ old('kapasitas', $item->kapasitas) }}">

                        @error('kapasitas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="form-group mb-3">
                        <label for="deskripsi" class="mb-2">
                            Description
                        </label>

                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="10"
                            placeholder="Event Description">{{ old('deskripsi', $item->deskripsi) }}</textarea>

                        @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="row">

                        {{-- Gambar --}}
                        <div class="col-md-8">
                            <div class="form-group mb-3">

                                <label for="gambar" class="mb-2">
                                    Image
                                </label>

                                @if ($item->gambar)
                                <div class="mb-2">
                                    <img src="{{ $item->gambar() }}" alt="{{ $item->judul }}"
                                        class="img-thumbnail"
                                        style="max-width: 180px; max-height: 100px; object-fit: cover;">
                                </div>
                                @endif

                                <input type="file" class="form-control-file @error('gambar') is-invalid @enderror"
                                    id="gambar" name="gambar" accept="image/jpg,image/jpeg,image/png,image/webp">

                                <small class="text-muted" style="display: block; margin-top: 5px;">
                                    JPG, JPEG, PNG, WEBP. Maksimal 2MB.
                                    Leave blank if you don't want to change the image.
                                </small>

                                @error('gambar')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <div class="form-group mb-3">

                                <label for="status" class="mb-2">
                                    Status <span class="text-danger">*</span>
                                </label>

                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    name="status" required>

                                    <option value="draft"
                                        {{ old('status', $item->status) == 'draft' ? 'selected' : '' }}>
                                        Draft
                                    </option>

                                    <option value="published"
                                        {{ old('status', $item->status) == 'published' ? 'selected' : '' }}>
                                        Published
                                    </option>

                                    <option value="cancelled"
                                        {{ old('status', $item->status) == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>

                                    <option value="completed"
                                        {{ old('status', $item->status) == 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>

                                </select>

                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                        </div>

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