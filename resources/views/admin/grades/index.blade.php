@extends('layouts.app')
@section('title','Grades')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Grades</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGradeModal">
            <i class="bi bi-plus-lg"></i> Add Grade
        </button>
    </div>

    <div class="card card-strong">
        <div class="card-body">
            <input id="gradeSearch" class="form-control mb-3" placeholder="Search grades...">

            <div class="table-responsive">
                <table id="gradesTable" class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th class="sortable">Student</th>
                        <th class="sortable">Exam</th>
                        <th>Marks</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($grades as $grade)
                        <tr>
                            <td>{{ $grade->student->name }}</td>
                            <td>{{ $grade->exam->subject->name }}</td>
                            <td>{{ $grade->marks }}</td>
                            <td>
                                <a href="{{ route('admin.grades.show',$grade->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.grades.edit',$grade->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.grades.destroy',$grade->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this grade?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $grades->links() }}
        </div>
    </div>

    @include('admin.modals.create_grade')
@endsection

@push('scripts')
    <script>
        tableFilter('gradeSearch','gradesTable');
    </script>
@endpush
