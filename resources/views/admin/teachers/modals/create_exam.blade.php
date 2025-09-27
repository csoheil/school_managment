<div class="modal fade" id="createExamModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('teacher.exams.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Create Exam</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select">
              @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Subject</label>
            <select name="subject_id" class="form-select">
              @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Max Marks</label>
            <input type="number" name="max_marks" class="form-control" value="100">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </div>
</div>
