@extends('layouts.app')
@section('content')
<div class="auth-shell">
  <form method="post" action="{{ route('coordinator.login.submit') }}" class="card auth-card">
    <div class="card-body">
      <h1 class="section-title mb-1">Coordinator Login</h1>
      <p class="text-muted mb-3">Oversee departments, courses, and enrollments.</p>
      @csrf
      @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif
      <div class="mb-2">
        <label class="form-label">Coordinator ID</label>
        <input name="username" class="form-control" placeholder="C-9001" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" placeholder="Your password" required>
      </div>
      <button class="btn btn-primary w-100">Login</button>
      <small class="text-muted mt-3 d-block">Hint: use coordinator ID (e.g., C-9001) with password "password".</small>
    </div>
  </form>
</div>
@endsection
