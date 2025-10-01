@extends('layouts.app')
@section('title','Edit Subject')

@section('content')
<div class="card card-strong">
  <div class="card-body">
    <h4 class="mb-3">Edit Subject</h4>
    <form action="{{ route('teacher.subjects.update',$subject->id) }}" method="POST" class="row g-3">
      @csrf @method('PUT')

      <div class="col-md-6">
        <label class="form-label">Name</label>
        <input name="name" class="form-control" value="{{ $subject->name }}" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Code</label>
        <input name="code" class="form-control" value="{{ $subject->code }}">
      </div>

      <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ $subject->description }}</textarea>
      </div>

      <div class="col-12 text-end">
        <a href="{{ route('teacher.subjects.index') }}" class="btn btn-secondary">Cancel</a>
        <button class="btn btn-primary">Update Subject</button>
      </div>
    </form>
  </div>
</div>
@endsection
