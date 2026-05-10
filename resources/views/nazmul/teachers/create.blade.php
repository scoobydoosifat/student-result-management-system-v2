@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-body">
    <h1 class="h5 mb-3">Add Teacher</h1>
    <form method="post" action="{{ route('coordinator.teachers.store') }}">
      @csrf
      <div class="row">
        <div class="col-md-4 mb-2">
          <label class="form-label">Teacher ID</label>
          <input name="teacher_id" class="form-control" value="{{ old('teacher_id') }}" required>
          @error('teacher_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-8 mb-2">
          <label class="form-label">Full Name</label>
          <input name="full_name" class="form-control" value="{{ old('full_name') }}" required>
          @error('full_name')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-2">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
          @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-2">
          <label class="form-label">Phone</label>
          <input name="phone" class="form-control" value="{{ old('phone') }}" required>
          @error('phone')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-2">
          <label class="form-label">Designation</label>
          <input name="designation" class="form-control" value="{{ old('designation') }}" required>
          @error('designation')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-2">
          <label class="form-label">Department</label>
          <select name="department_id" class="form-select" required>
            <option value="">Select department</option>
            @foreach ($departments as $department)
              <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->department_name }}</option>
            @endforeach
          </select>
          @error('department_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-2">
          <label class="form-label">Password (optional)</label>
          <input type="password" name="password" class="form-control" placeholder="Default: password">
          @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary">Create Teacher</button>
        <a class="btn btn-outline-secondary" href="{{ route('coordinator.dashboard') }}">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
