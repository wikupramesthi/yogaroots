<!-- Modal Update Sidebar -->
<div class="modal fade" id="modalUpdateSidebar-{{ $item->uuid }}" tabindex="-1"
    aria-labelledby="modalLabelSidebar-{{ $item->uuid }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pages.updateSidebar', $item->uuid) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelSidebar-{{ $item->uuid }}">Ubah Sidebar?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-wrap text-break">
                    <p>
                        Apakah Anda yakin ingin mengubah status sidebar untuk halaman
                        <strong>{{ $item->title }}</strong> menjadi
                        <span class="text-primary">
                            {{ $item->has_sidebar ? 'Tidak' : 'Ya' }}
                        </span>?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, ubah</button>
                </div>
            </div>
        </form>
    </div>
</div>
