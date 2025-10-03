@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">My Classes</h1>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Class Name</th>
        <th>Description</th>
        <th>Teacher</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($classes as $class)
      <tr>
        <td>{{ $class->name }}</td>
        <td>{{ $class->description }}</td>
        <td>{{ $class->teacher->name }}</td>
        <td>
          <a href="{{ route('student.classes.show', $class->id) }}" class="btn btn-sm btn-primary">View</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
