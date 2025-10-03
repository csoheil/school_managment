<div class="modal fade" id="addGradeModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('teacher.grades.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Grade</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Class</label>
            <select id="grade_class" name="class_id" class="form-select" required>
              <option value="">-- Select class --</option>
              @foreach($classes as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Exam</label>
            <select id="grade_exam" name="exam_id" class="form-select" required>
              <option value="">-- Select exam --</option>
              @foreach($exams as $e)
                <option value="{{ $e->id }}" data-class="{{ $e->class_id }}">{{ $e->subject->name }} — {{ $e->date }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Student</label>
            <select id="grade_student" name="student_id" class="form-select" required>
              <option value="">-- Select student --</option>
              @foreach($students as $s)
                <option value="{{ $s->id }}" data-classes="{{ $s->classes->pluck('id')->join(',') }}">{{ $s->name }} ({{ optional($s->classes->first())->name ?? '—' }})</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-3">
            <label class="form-label">Marks</label>
            <input type="number" name="marks" class="form-control" min="0" required>
          </div>

          <div class="col-md-3">
            <label class="form-label">Comments</label>
            <input type="text" name="comments" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Grade</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Optional: filter exam/student selects by chosen class
  document.getElementById('grade_class')?.addEventListener('change', function(){
    const cls = this.value;
    // filter exams
    const examSelect = document.getElementById('grade_exam');
    Array.from(examSelect.options).forEach(o => {
      if(!o.value) return;
      o.style.display = (o.dataset.class === cls || cls === '') ? '' : 'none';
    });
    // filter students
    const studentSelect = document.getElementById('grade_student');
    Array.from(studentSelect.options).forEach(o => {
      if(!o.value) return;
      const classes = o.dataset.classes ? o.dataset.classes.split(',') : [];
      o.style.display = (cls === '' || classes.includes(cls)) ? '' : 'none';
    });
  });
</script>
@endpush
