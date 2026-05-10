@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-body">
    <h1 class="h5 mb-3">Edit Course</h1>
    <form method="post" action="{{ route('courses.update', $course->id) }}">
      @csrf
      @method('put')
      <div class="row">
        <div class="col-md-4 mb-2">
          <label class="form-label">Course Code</label>
          <input name="course_code" class="form-control" value="{{ old('course_code', $course->course_code) }}" required>
          @error('course_code')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-8 mb-2">
          <label class="form-label">Course Title</label>
          <input name="course_title" class="form-control" value="{{ old('course_title', $course->course_title) }}" required>
          @error('course_title')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4 mb-2">
          <label class="form-label">Credit Hours</label>
          <input type="number" name="credit_hours" class="form-control" min="1" max="6" value="{{ old('credit_hours', $course->credit_hours) }}" required>
          @error('credit_hours')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4 mb-2">
          <label class="form-label">Department</label>
          <select name="department_id" class="form-select" required>
            @foreach ($departments as $department)
              <option value="{{ $department->id }}" @selected(old('department_id', $course->department_id) == $department->id)>{{ $department->department_name }}</option>
            @endforeach
          </select>
          @error('department_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4 mb-2">
          <label class="form-label">Assign Teacher</label>
          <select name="teacher_id" class="form-select" required>
            @foreach ($teachers as $teacher)
              <option value="{{ $teacher->id }}" @selected(old('teacher_id', $course->teacher_id) == $teacher->id)>{{ $teacher->teacher_id }} - {{ $teacher->full_name }}</option>
            @endforeach
          </select>
          @error('teacher_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary">Update</button>
        <a class="btn btn-outline-secondary" href="{{ route('courses.index') }}">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
