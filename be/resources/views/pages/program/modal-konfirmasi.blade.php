<!-- Modal -->
<div class="modal fade" id="modal-konfirmasi-program" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Konfirmasi Pendaftaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin seluruh data sudah benar dan ingin mendaftarkan calon murid ke Sekolah SLB Kota Bekasi?
      </div>
      <div class="modal-footer">
        <form action="{{ route('program.verifikasi', $program->uuid) }}" method="POST">
          @csrf
          @method('PATCH')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Ya, saya yakin</button>
        </form>
      </div>
    </div>
  </div>
</div>