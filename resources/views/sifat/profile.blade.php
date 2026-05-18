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
                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Student ID</label>
                            <input class="form-control" value="{{ $student->student_id }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input name="full_name" class="form-control" value="{{ old('full_name', $student->full_name) }}" required>
                            @error('full_name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" required>
                            @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <input class="form-control" value="{{ $student->department?->department_name }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Semester</label>
                            <input class="form-control" value="{{ $student->semester?->semester_name }}" disabled>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Save Changes</button>
                        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
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
                <form method="POST" action="{{ route('student.password.update') }}">
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
                        <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="profile-avatar mb-3" style="width:100px;height:100px;font-size:3rem;">
                    {{ substr($student->full_name, 0, 1) }}
                </div>
                <h5>{{ $student->full_name }}</h5>
                <p class="text-muted">{{ $student->student_id }}</p>
                <hr>
                <a href="{{ route('student.dashboard') }}" class="btn btn-outline-primary w-100"><i class="bi bi-arrow-left me-1"></i>Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection