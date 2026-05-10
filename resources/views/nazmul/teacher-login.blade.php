@extends('layouts.app')
@section('content')
<div class="auth-shell">
  <form method="post" action="{{ route('teacher.login.submit') }}" class="card auth-card">
    <div class="card-body">
      <h1 class="section-title mb-1">Teacher Login</h1>
      <p class="text-muted mb-3">Manage marks and view result history.</p>
      @csrf
      @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif
      <div class="mb-2">
        <label class="form-label">Teacher ID</label>
        <input name="username" class="form-control" placeholder="T-1001" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input name="password" type="password" class="form-control" placeholder="Your password" required>
      </div>
      <button class="btn btn-primary w-100">Login</button>
      <small class="text-muted mt-3 d-block">Hint: use teacher ID (e.g., T-1001) with password "password".</small>
    </div>
  </form>
</div>
@endsection
