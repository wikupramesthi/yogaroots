<div class="modal fade" id="modalSuratPernyataan-{{ $item->id }}" tabindex="-1" aria-labelledby="modalSuratPernyataanLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Surat Pernyataan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                @if ($item->user && $item->user->surat_pernyataan && file_exists(public_path('storage/' . $item->user->surat_pernyataan)))
                <iframe src="{{ asset('storage/' . $item->user->surat_pernyataan) }}" width="100%" height="800px" frameborder="0"></iframe>
                @else
                <p class="text-danger">File surat pernyataan belum diunggah.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProfilKomunitas-{{ $item->id }}" tabindex="-1" aria-labelledby="modalProfilKomunitasLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Profil Komunitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                @if ($item->user && $item->user->profil_komunitas && file_exists(public_path('storage/' . $item->user->profil_komunitas)))
                <iframe src="{{ asset('storage/' . $item->user->profil_komunitas) }}" width="100%" height="800px" frameborder="0"></iframe>
                @else
                <p class="text-danger">File profil komunitas belum diunggah.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalLogoKomunitas-{{ $item->id }}" tabindex="-1" aria-labelledby="modalLogoKomunitasLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lihat Logo Komunitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                @if ($item->logo_komunitas && file_exists(public_path('storage/' . $item->logo_komunitas)))
                    <img src="{{ asset('storage/' . $item->logo_komunitas) }}" alt="Logo Komunitas" class="img-fluid rounded">
                @else
                    <p class="text-danger">File logo komunitas belum diunggah.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="modalUpdateStatus-{{ $item->id }}" tabindex="-1" aria-labelledby="modalUpdateStatusLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('program.updateStatus', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateStatusLabel-{{ $item->id }}">Status Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="status-{{ $item->id }}" class="mb-2">Pilih Status <span class="text-danger">*</span></label>
                        <select name="status" id="status-{{ $item->id }}" class="form-select" required>
                            <option value="diterima" {{ $item->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="diperbaiki" {{ $item->status == 'diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                            <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>Ditutup</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="catatan" class="mb-2">Catatan</label>
                        <textarea type="text" name="catatan" class="form-control @error('catatan') is-invalid @enderror"
                            value="{{ old('catatan', $item->catatan) }}">{{ old('catatan', $item->catatan) }}</textarea>
                             @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small>*Status akan mempengaruhi tahapan program ini dalam sistem.</small>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>