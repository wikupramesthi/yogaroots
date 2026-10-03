<!-- Modals add menu -->
<div id="modal-form-add-polls" class="modal fade modal-form-polls" tabindex="-1" aria-labelledby="modal-form-add-polls-label"
  aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="modal-form" action="{{ route('poll.store') }}" method="post">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modal-form-add-polls-label">Add Poll</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
        </div>
        <div class="modal-body">
          
          <div class="form-group mb-3">
            <label for="question" class="mb-2">Question <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('question') is-invalid @enderror" 
                   id="question" name="question" 
                   placeholder="Write the poll question" value="{{ old('question') }}" required>
            @error('question')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

          <div class="form-group mb-3">
            <label for="status" class="mb-2">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
              <option value="">-- Select --</option>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
            @error('status')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>


        <div class="form-group mb-3">
            <label class="mb-2">Answer Choices <span class="text-danger">*</span></label>
            <div id="options-wrapper">
                <input type="text" name="options[]" class="form-control mb-2" placeholder="Option 1" required>
                <input type="text" name="options[]" class="form-control mb-2" placeholder="Option 2" required>
            </div>
            <button type="button" class="btn btn-sm btn-secondary" id="add-option">+ Add Option</button>
            @error('options')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary ">Save</button>
        </div>
      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->