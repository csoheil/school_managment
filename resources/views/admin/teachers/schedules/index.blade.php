@extends('layouts.app')
@section('title','My Schedule')

@section('content')
<div class="card card-strong">
    <div class="card-body">
        <h4>Schedule</h4>
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Day</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->class->name }}</td>
                        <td>{{ $schedule->subject->name }}</td>
                        <td>{{ $schedule->day_of_week }}</td>
                        <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $schedules->links() }}
    </div>
</div>
@endsection
