@extends('layouts.app')
@section('title','Teachers')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Teachers</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTeacherModal">
            <i class="bi bi-plus-lg"></i> Add Teacher
        </button>
    </div>

    <div class="card card-strong">
        <div class="card-body">
            <input id="teacherSearch" class="form-control mb-3" placeholder="Search teachers...">

            <div class="table-responsive">
                <table id="teachersTable" class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th class="sortable">ID</th>
                        <th class="sortable">Name</th>
                        <th class="sortable">Email</th>
                        <th>Subjects</th>
                        <th>Avatar</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->id }}</td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>
                                @foreach($teacher->subjects as $subj)
                                    <span class="badge bg-primary">{{ $subj->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <img src="{{ $teacher->avatar ?? asset('images/default-avatar.png') }}" class="avatar-sm">
                            </td>
                            <td>
                                <a href="{{ route('admin.teachers.show',$teacher->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.teachers.edit',$teacher->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.teachers.destroy',$teacher->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this teacher?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $teachers->links() }}
        </div>
    </div>

    @include('admin.modals.create_teacher')
@endsection

@push('scripts')
    <script>
        tableFilter('teacherSearch','teachersTable');
    </script>
@endpush
