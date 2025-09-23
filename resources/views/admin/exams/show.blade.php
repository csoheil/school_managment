@extends('layouts.app')
@section('title','Exam Details')

@section('content')
    <div class="card card-strong">
        <div class="card-body">
            <h4>{{ $exam->subject->name }} - Exam</h4>
            <p><strong>Class:</strong> {{ $exam->class->name }}</p>
            <p><strong>Date:</strong> {{ $exam->date }}</p>
            <p><strong>Max Marks:</strong> {{ $exam->max_marks }}</p>

            <h5 class="mt-4">Grades</h5>
            <ul class="list-group">
                @foreach($exam->grades as $grade)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $grade->student->name }}
                        <span class="badge bg-success">{{ $grade->marks }} / {{ $exam->max_marks }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
