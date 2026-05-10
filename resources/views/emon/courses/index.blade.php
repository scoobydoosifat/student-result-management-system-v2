@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="h5 mb-0">Courses</h1>
      <a class="btn btn-sm btn-primary" href="{{ route('courses.create') }}">Add Course</a>
    </div>
    <div class="table-responsive">
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>Course</th>
            <th>Credits</th>
            <th>Department</th>
            <th>Teacher</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($courses as $course)
            <tr>
              <td>{{ $course->course_code }} - {{ $course->course_title }}</td>
              <td>{{ $course->credit_hours }}</td>
              <td>{{ $course->department?->department_name }}</td>
              <td>{{ $course->teacher?->teacher_id }} - {{ $course->teacher?->full_name }}</td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('courses.edit', $course->id) }}">Edit</a>
                <form method="post" action="{{ route('courses.destroy', $course->id) }}" class="d-inline">
                  @csrf
                  @method('delete')
                  <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this course?')">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-muted">No courses found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
