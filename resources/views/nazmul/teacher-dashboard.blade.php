@extends('layouts.app')
@section('content')
<div class="row g-3 stagger">
  <div class="col-lg-4">
    <div class="card">
      <div class="card-body">
        <h1 class="section-title mb-3">Teacher Panel</h1>
        <div><strong>Name:</strong> {{ $teacher->full_name }}</div>
        <div><strong>ID:</strong> {{ $teacher->teacher_id }}</div>
        <div><strong>Designation:</strong> {{ $teacher->designation }}</div>
        <div><strong>Department:</strong> {{ $teacher->department?->department_name }}</div>
        <div><strong>Email:</strong> {{ $teacher->email }}</div>
        <div><strong>Phone:</strong> {{ $teacher->phone }}</div>
        <p class="mt-3 mb-2 text-muted">You can manage marks, view result history, and drop students.</p>
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-sm btn-primary" href="{{ route('results.index') }}">Manage Results</a>
          <a class="btn btn-sm btn-outline-primary" href="{{ route('result-histories.index') }}">Result History</a>
          <a class="btn btn-sm btn-outline-danger" href="{{ route('teacher.enrollments.index') }}">Drop From Course</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body">
        <h2 class="section-title mb-3">Assigned Courses</h2>
        <div class="table-responsive">
          <table class="table table-sm table-striped">
            <thead>
              <tr>
                <th>Course</th>
                <th>Credit Hours</th>
                <th>Department</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($courses as $course)
                <tr>
                  <td>{{ $course->course_code }} - {{ $course->course_title }}</td>
                  <td>{{ $course->credit_hours }}</td>
                  <td>{{ $course->department?->department_name }}</td>
                </tr>
              @empty
                <tr><td colspan="3" class="text-muted">No courses assigned.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
