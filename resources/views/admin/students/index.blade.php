@extends('layouts.app')
@section('title','Students')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Students</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createStudentModal">
            <i class="bi bi-plus-lg"></i> Add Student
        </button>
    </div>

    <div class="card card-strong">
        <div class="card-body">
            <input id="studentSearch" class="form-control mb-3" placeholder="Search students...">

            <div class="table-responsive">
                <table id="studentsTable" class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th class="sortable">ID</th>
                        <th class="sortable">Name</th>
                        <th class="sortable">Email</th>
                        <th>Class</th>
                        <th>Avatar</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ optional($student->classes->first())->name ?? '-' }}</td>
                            <td>
                                <img src="{{ $student->avatar ?? asset('images/default-avatar.png') }}" class="avatar-sm">
                            </td>
                            <td>
                                <a href="{{ route('admin.students.show',$student->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.students.edit',$student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.students.destroy',$student->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this student?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $students->links() }}
        </div>
    </div>

    @include('admin.modals.register')
@endsection

@push('scripts')
    <script>
        tableFilter('studentSearch','studentsTable');
    </script>
@endpush
