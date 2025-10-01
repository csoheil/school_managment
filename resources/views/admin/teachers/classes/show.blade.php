@extends('layouts.app')
@section('title','Class Details')

@section('content')
<div class="card card-strong mb-3">
  <div class="card-body">
    <h4>{{ $class->name }}</h4>
    <p class="text-muted">{{ $class->description }}</p>
    <p><strong>Teacher:</strong> {{ $class->teacher->name }}</p>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="card card-strong mb-3">
      <div class="card-body">
        <h5>Students</h5>
        <ul class="list-group">
          @foreach($class->students as $student)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              {{ $student->name }}
              <span class="badge bg-primary">{{ $student->pivot->status ?? 'Active' }}</span>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card card-strong mb-3">
      <div class="card-body">
        <h5>Subjects</h5>
        <ul class="list-group">
          @foreach($class->subjects as $subject)
            <li class="list-group-item">{{ $subject->name }} ({{ $subject->code }})</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="card card-strong">
  <div class="card-body">
    <h5>Schedules</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Day</th>
            <th>Subject</th>
            <th>Start</th>
            <th>End</th>
          </tr>
        </thead>
        <tbody>
          @foreach($class->schedules as $schedule)
            <tr>
              <td>{{ $schedule->day_of_week }}</td>
              <td>{{ $schedule->subject->name }}</td>
              <td>{{ $schedule->start_time }}</td>
              <td>{{ $schedule->end_time }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
