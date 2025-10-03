@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">My Schedule</h1>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Day</th>
        <th>Subject</th>
        <th>Start</th>
        <th>End</th>
      </tr>
    </thead>
    <tbody>
      @foreach($schedules as $schedule)
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
@endsection
