@extends('layouts.app')
@section('title','My Exams')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Exams</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createExamModal">
        <i class="bi bi-plus-lg"></i> Add Exam
    </button>
</div>

<div class="card card-strong">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Max Marks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <td>{{ $exam->subject->name }}</td>
                            <td>{{ $exam->class->name }}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->max_marks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $exams->links() }}
    </div>
</div>

@include('teacher.modals.create_exam')
@endsection
