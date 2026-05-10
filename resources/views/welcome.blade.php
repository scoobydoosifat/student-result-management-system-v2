@extends('layouts.app')
@section('content')
<div class="hero">
  <div class="hero-copy">
    <div class="eyebrow">SRMS</div>
    <h1 class="display-title">Student Result Management System</h1>
    <p class="text-muted mb-3">Track enrollments, publish results, and generate transcripts in one clean workspace.</p>
    <div class="d-flex flex-wrap gap-2">
      <span class="tag">Results</span>
      <span class="tag">GPA</span>
      <span class="tag">Transcripts</span>
      <span class="tag">Reports</span>
    </div>
    <div class="hero-actions">
      <a class="btn btn-primary" href="{{ route('student.login') }}">Student Login</a>
      <a class="btn btn-outline-primary" href="{{ route('coordinator.login') }}">Coordinator Login</a>
      <a class="btn btn-outline-secondary" href="{{ route('teacher.login') }}">Teacher Login</a>
    </div>
  </div>
  <div class="hero-card">
    <h2 class="section-title mb-2">Quick Access</h2>
    <p class="text-muted mb-3">Choose your role to jump into the right tools.</p>
    <div class="d-grid gap-2">
      <a class="btn btn-primary" href="{{ route('student.login') }}">Continue as Student</a>
      <a class="btn btn-outline-primary" href="{{ route('coordinator.login') }}">Continue as Coordinator</a>
      <a class="btn btn-outline-secondary" href="{{ route('teacher.login') }}">Continue as Teacher</a>
    </div>
  </div>
</div>
@endsection
