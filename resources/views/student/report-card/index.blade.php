@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">My Report Card</h1>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Subject</th>
        <th>Score</th>
        <th>Comments</th>
      </tr>
    </thead>
    <tbody>
      @foreach($grades as $grade)
      <tr>
        <td>{{ $grade->subject->name }}</td>
        <td>
          <span class="badge bg-{{ $grade->score >= 50 ? 'success' : 'danger' }}">
            {{ $grade->score }}
          </span>
        </td>
        <td>{{ $grade->comments }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
