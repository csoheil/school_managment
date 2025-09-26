@extends('layouts.app')
@section('title','My Classes')

@section('content')
<div class="card card-strong">
    <div class="card-body">
        <h4>My Classes</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Description</th>
                        <th>Students</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $class)
                        <tr>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->description }}</td>
                            <td>{{ $class->students->count() }}</td>
                            <td>
                                <a href="{{ route('teacher.classes.show',$class->id) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $classes->links() }}
    </div>
</div>
@endsection
