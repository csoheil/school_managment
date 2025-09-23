@extends('layouts.app')
@section('title','Exams')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Exams</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createExamModal">
            <i class="bi bi-plus-lg"></i> Add Exam
        </button>
    </div>

    <div class="card card-strong">
        <div class="card-body">
            <input id="examSearch" class="form-control mb-3" placeholder="Search exams...">

            <div class="table-responsive">
                <table id="examsTable" class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th class="sortable">Subject</th>
                        <th class="sortable">Class</th>
                        <th>Date</th>
                        <th>Max Marks</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <td>{{ $exam->subject->name }}</td>
                            <td>{{ $exam->class->name }}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->max_marks }}</td>
                            <td>
                                <a href="{{ route('admin.exams.show',$exam->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.exams.edit',$exam->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.exams.destroy',$exam->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this exam?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $exams->links() }}
        </div>
    </div>

    @include('admin.modals.create_exam')
@endsection

@push('scripts')
    <script>
        tableFilter('examSearch','examsTable');
    </script>
@endpush
