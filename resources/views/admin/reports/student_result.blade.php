@extends('layouts.app')
@section('title','Student Report')

@section('content')
    <div class="card card-strong">
        <div class="card-body">
            <h4>Report Card - {{ $student->name }}</h4>
            <p>Email: {{ $student->email }}</p>

            <table class="table table-bordered mt-3">
                <thead>
                <tr>
                    <th>Subject</th>
                    <th>Exam Date</th>
                    <th>Marks</th>
                </tr>
                </thead>
                <tbody>
                @foreach($student->grades as $grade)
                    <tr>
                        <td>{{ $grade->exam->subject->name }}</td>
                        <td>{{ $grade->exam->date }}</td>
                        <td>{{ $grade->marks }} / {{ $grade->exam->max_marks }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
@endsection
