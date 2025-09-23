@extends('layouts.app')
@section('title','Grade Details')

@section('content')
    <div class="card card-strong">
        <div class="card-body">
            <h4>Grade</h4>
            <p><strong>Student:</strong> {{ $grade->student->name }}</p>
            <p><strong>Exam:</strong> {{ $grade->exam->subject->name }} ({{ $grade->exam->date }})</p>
            <p><strong>Marks:</strong> {{ $grade->marks }} / {{ $grade->exam->max_marks }}</p>
        </div>
    </div>
@endsection
