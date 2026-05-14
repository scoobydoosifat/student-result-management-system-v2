@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-header">
    <h5 class="mb-0"><i class="bi bi-person-badge me-2 text-primary"></i>Add Teacher</h5>
  </div>
  <div class="card-body">
    <form method="post" action="{{ route('coordinator.teachers.store') }}">
      @csrf
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Teacher ID</label>
          <input name="teacher_id" class="form-control" value="{{ old('teacher_id') }}" placeholder="e.g., T-1001" required>
          @error('teacher_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-8">
          <label class="form-label">Full Name</label>
          <input name="full_name" class="form-control" value="{{ old('full_name') }}" placeholder="e.g., Dr. John Smith" required>
          @error('full_name')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="teacher@example.com" required>
          @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">Phone</label>
          <input name="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g., 01712345678" required>
          @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">Designation</label>
          <input name="designation" class="form-control" value="{{ old('designation') }}" placeholder="e.g., Professor, Lecturer" required>
          @error('designation')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">Department</label>
          <select name="department_id" class="form-select" required>
            <option value="">Select department</option>
            @foreach ($departments as $department)
              <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->department_name }}</option>
            @endforeach
          </select>
          @error('department_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">Password <span class="text-muted">(optional)</span></label>
          <input type="password" name="password" class="form-control" placeholder="Default: password">
          @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Create Teacher</button>
        <a class="btn btn-outline-secondary" href="{{ route('coordinator.dashboard') }}">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
