@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">{{ $class->name }}</h1>
  <p>{{ $class->description }}</p>

  <h3 class="mt-4">Subjects</h3>
  <ul class="list-group mb-4">
    @foreach($class->subjects as $subject)
      <li class="list-group-item d-flex justify-content-between align-items-center">
        {{ $subject->name }}
        <span class="badge bg-primary">{{ $subject->code }}</span>
      </li>
    @endforeach
  </ul>
</div>
@endsection
