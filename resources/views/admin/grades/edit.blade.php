@extends('layouts.app')
@section('title','Edit Grade')

@section('content')
<div class="card card-strong">
  <div class="card-body">
    <h4 class="mb-3">Edit Grade</h4>
    <form action="{{ route('teacher.grades.update',$grade->id) }}" method="POST" class="row g-3">
      @csrf @method('PUT')

      <div class="col-md-6">
        <label class="form-label">Student</label>
        <input class="form-control" value="{{ $grade->student->name }}" disabled>
      </div>

      <div class="col-md-6">
        <label class="form-label">Subject</label>
        <input class="form-control" value="{{ $grade->exam->subject->name }}" disabled>
      </div>

      <div class="col-md-4">
        <label class="form-label">Marks</label>
        <input type="number" name="marks" class="form-control" value="{{ $grade->marks }}" min="0" required>
      </div>

      <div class="col-md-8">
        <label class="form-label">Comments</label>
        <input type="text" name="comments" class="form-control" value="{{ $grade->comments }}">
      </div>

      <div class="col-12 text-end">
        <a href="{{ route('teacher.grades.index') }}" class="btn btn-secondary">Cancel</a>
        <button class="btn btn-primary">Update Grade</button>
      </div>
    </form>
  </div>
</div>
@endsection
