@extends('layouts.app')
@section('title','Schedule Details')

@section('content')
    <div class="card card-strong">
        <div class="card-body">
            <h4>Schedule</h4>
            <p><strong>Class:</strong> {{ $schedule->class->name }}</p>
            <p><strong>Subject:</strong> {{ $schedule->subject->name }}</p>
            <p><strong>Day:</strong> {{ $schedule->day_of_week }}</p>
            <p><strong>Time:</strong> {{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
        </div>
    </div>
@endsection
