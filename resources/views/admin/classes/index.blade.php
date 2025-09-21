@extends('layouts.app')
@section('title','Classes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Classes</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClassModal">
            <i class="bi bi-plus-lg"></i> Add Class
        </button>
    </div>

    <div class="card card-strong">
        <div class="card-body">
            <input id="classSearch" class="form-control mb-3" placeholder="Search classes...">

            <div class="table-responsive">
                <table id="classesTable" class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th class="sortable">ID</th>
                        <th class="sortable">Name</th>
                        <th>Description</th>
                        <th>Teacher</th>
                        <th>Students</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($classes as $class)
                        <tr>
                            <td>{{ $class->id }}</td>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->description }}</td>
                            <td>{{ optional($class->teacher)->name }}</td>
                            <td>{{ $class->students->count() }}</td>
                            <td>
                                <a href="{{ route('admin.classes.show',$class->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.classes.edit',$class->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.classes.destroy',$class->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this class?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $classes->links() }}
        </div>
    </div>

    @include('admin.modals.create_class')
@endsection

@push('scripts')
    <script>
        tableFilter('classSearch','classesTable');
    </script>
@endpush
