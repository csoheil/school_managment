<div class="modal fade" id="createScheduleModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('admin.schedules.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Create Schedule</h5>
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
            <label class="form-label">Day of Week</label>
            <input type="text" name="day_of_week" class="form-control" placeholder="Monday">
          </div>
          <div class="col-md-3">
            <label class="form-label">Start Time</label>
            <input type="time" name="start_time" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label">End Time</label>
            <input type="time" name="end_time" class="form-control">
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
