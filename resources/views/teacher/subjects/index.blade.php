@extends('layouts.app')
@section('title','Subjects')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Manage Subjects</h4>
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSubjectModal">
            <i class="bi bi-plus-lg"></i> New Subject
        </button>
        <a href="{{ route('teacher.subjects.import') }}" class="btn btn-outline-secondary">Import</a>
    </div>
</div>

<div class="card card-strong">
    <div class="card-body">
        <input id="subjectSearch" class="form-control mb-3" placeholder="Search subjects...">

        <div class="table-responsive">
            <table id="subjectsTable" class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="sortable">Code</th>
                        <th class="sortable">Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td>{{ $subject->code }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->description }}</td>
                            <td>
                                <a href="{{ route('teacher.subjects.edit',$subject->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('teacher.subjects.destroy',$subject->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this subject?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $subjects->links() }}
    </div>
</div>

@include('teacher.modals.create_subject')
@endsection

@push('scripts')
<script>
    tableFilter('subjectSearch','subjectsTable');
</script>
@endpush
