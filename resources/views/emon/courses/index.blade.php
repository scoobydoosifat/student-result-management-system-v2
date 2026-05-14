@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-book me-2 text-primary"></i>Courses</h5>
    <a class="btn btn-primary btn-sm" href="{{ route('courses.create') }}"><i class="bi bi-plus-lg me-1"></i>Add Course</a>
  </div>
  <div class="card-body p-0">
    @if($courses->isEmpty())
      <div class="empty-state">
        <div class="icon"><i class="bi bi-book"></i></div>
        <h5>No Courses</h5>
        <p class="text-muted">Create your first course to get started.</p>
        <a class="btn btn-primary" href="{{ route('courses.create') }}"><i class="bi bi-plus-lg me-1"></i>Add Course</a>
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr><th>Course</th><th>Credits</th><th>Department</th><th>Teacher</th><th class="text-end">Actions</th></tr>
          </thead>
          <tbody>
            @foreach ($courses as $course)
              <tr>
                <td>
                  <div class="fw-medium">{{ $course->course_code }}</div>
                  <small class="text-muted">{{ $course->course_title }}</small>
                </td>
                <td><span class="badge bg-primary-subtle text-primary">{{ $course->credit_hours }}</span></td>
                <td>{{ $course->department?->department_name }}</td>
                <td><span class="text-muted">{{ $course->teacher?->teacher_id }}</span> - {{ $course->teacher?->full_name }}</td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('courses.edit', $course->id) }}"><i class="bi bi-pencil"></i> Edit</a>
                  <form method="post" action="{{ route('courses.destroy', $course->id) }}" class="d-inline">
                    @csrf @method('delete')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this course?')"><i class="bi bi-trash"></i> Delete</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection
