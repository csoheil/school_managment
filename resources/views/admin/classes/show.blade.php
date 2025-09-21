@extends('layouts.app')
@section('title','Class Details')

@section('content')
    <div class="card card-strong">
        <div class="card-body">
            <h4>{{ $class->name }}</h4>
            <p>{{ $class->description }}</p>
            <p><strong>Teacher:</strong> {{ optional($class->teacher)->name }}</p>

            <h5 class="mt-4">Students</h5>
            <ul class="list-group">
                @foreach($class->students as $student)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $student->name }}
                        <span class="text-muted">{{ $student->email }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
