@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">My Attendance</h1>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Date</th>
        <th>Class</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($attendances as $attendance)
      <tr>
        <td>{{ $attendance->date }}</td>
        <td>{{ $attendance->class->name }}</td>
        <td>
          <span class="badge bg-{{ $attendance->status == 'Present' ? 'success' : 'danger' }}">
            {{ $attendance->status }}
          </span>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
