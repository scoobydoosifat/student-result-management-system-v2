@extends('layouts.app')
@section('content')
<style>
.card { border-radius: 16px; }
.form-label { font-weight: 500; color: #495057; }
</style>

<div class="row g-4 stagger">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person-fill me-2 text-primary"></i>Update Profile</h5>
            </div>
            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('teacher.profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Teacher ID</label>
                            <input class="form-control" value="{{ $teacher->teacher_id }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input name="full_name" class="form-control" value="{{ old('full_name', $teacher->full_name) }}" required>
                            @error('full_name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email', $teacher->email) }}" required>
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}" required>
                            @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Designation</label>
                            <input class="form-control" value="{{ $teacher->designation }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <input class="form-control" value="{{ $teacher->department?->department_name }}" disabled>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Save Changes</button>
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-key-fill me-2 text-primary"></i>Change Password</h5>
            </div>
            <div class="card-body">
                @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
                <form method="POST" action="{{ route('teacher.password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Current Password</label>
                            <input name="current_password" type="password" class="form-control" required>
                            @error('current_password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input name="new_password" type="password" class="form-control" required minlength="6">
                            @error('new_password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm New Password</label>
                            <input name="new_password_confirmation" type="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning"><i class="bi bi-lock-fill me-1"></i>Change Password</button>
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div style="width:100px;height:100px;background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);border-radius: 50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:3rem;color:white;font-weight:600;">
                    {{ substr($teacher->full_name, 0, 1) }}
                </div>
                <h5>{{ $teacher->full_name }}</h5>
                <p class="text-muted">{{ $teacher->teacher_id }}</p>
                <p class="text-muted">{{ $teacher->designation }}</p>
                <hr>
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-primary w-100"><i class="bi bi-arrow-left me-1"></i>Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection