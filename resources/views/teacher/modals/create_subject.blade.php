<div class="modal fade" id="createSubjectModal" tabindex="-1">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <form id="subjectForm" action="{{ route('teacher.subjects.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Create Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Code</label>
            <input name="code" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Subject</button>
        </div>
      </form>
    </div>
  </div>
</div>
