<!-- Modal -->
<div class="modal fade" id="modal-konfirmasi-program" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Registration Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure all the data is correct and you want to register the prospective student to the SLB School in Bekasi City?
      </div>
      <div class="modal-footer">
        <form action="{{ route('program.verifikasi', $program->uuid) }}" method="POST">
          @csrf
          @method('PATCH')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Yes, I am sure</button>
        </form>
      </div>
    </div>
  </div>
</div>