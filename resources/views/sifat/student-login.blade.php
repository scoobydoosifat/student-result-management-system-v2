@extends('layouts.app')
@section('content')
<div class="auth-shell">
  <form method="post" action="{{ route('student.login.submit') }}" class="card auth-card">
    <div class="card-header">
      <div style="width: 60px; height: 60px; background: var(--accent-soft); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.5rem; color: var(--accent);"><i class="bi bi-person"></i></div>
      <h1 class="mb-1">Student Login</h1>
      <p class="text-muted mb-0">Access your dashboard and transcript history.</p>
    </div>
    <div class="card-body">
      @csrf
      @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center gap-2"><i class="bi bi-exclamation-triangle"></i>{{ $errors->first() }}</div>
      @endif
      <div class="mb-3">
        <label class="form-label">Username</label>
        <div class="input-group">
            <span class="input-group-text" style="border-radius: 12px 0 0 12px; border-right: none; background: white;"><i class="bi bi-person text-muted"></i></span>
            <input name="username" class="form-control" placeholder="S-24001" style="border-radius: 0 12px 12px 0; border-left: none;" required>
        </div>
      </div>
      <div class="mb-4">
        <label class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text" style="border-radius: 12px 0 0 12px; border-right: none; background: white;"><i class="bi bi-lock text-muted"></i></span>
            <input name="password" type="password" class="form-control" placeholder="Your password" style="border-radius: 0 12px 12px 0; border-left: none;" required>
        </div>
      </div>
      <button class="btn btn-primary w-100 py-2"><i class="bi bi-box-arrow-in-right me-2"></i>Login</button>
      <div class="text-center mt-3">
        <small class="text-muted">Demo: username <strong>S-24001</strong>, password <strong>password</strong></small>
      </div>
    </div>
  </form>
</div>
@endsection
