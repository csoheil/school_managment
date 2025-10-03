@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">Student Dashboard</h1>
  <div class="row">
    <div class="col-md-6">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="card-title">My Classes</h5>
          <p class="card-text">View your enrolled classes.</p>
          <a href="{{ route('student.classes.index') }}" class="btn btn-primary">View Classes</a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="card-title">My Report Card</h5>
          <p class="card-text">Check your grades and performance.</p>
          <a href="{{ route('student.report-card.index') }}" class="btn btn-success">View Report Card</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
