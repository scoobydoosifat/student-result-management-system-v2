@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-header">
    <h5 class="mb-0"><i class="bi bi-person-dash me-2 text-danger"></i>Drop Students From Your Courses</h5>
  </div>
  <div class="card-body p-0">
    @if (session('status'))
      <div class="alert alert-success m-3 d-flex align-items-center gap-2"><i class="bi bi-check-circle"></i>{{ session('status') }}</div>
    @endif
    @if($enrollments->isEmpty())
      <div class="empty-state">
        <div class="icon"><i class="bi bi-people"></i></div>
        <h5>No Enrollments</h5>
        <p class="text-muted">No students enrolled in your courses yet.</p>
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr><th>Student</th><th>Course</th><th>Department</th><th>Semester</th><th class="text-end">Action</th></tr>
          </thead>
          <tbody>
            @foreach ($enrollments as $enrollment)
              <tr>
                <td>
                  <div class="fw-medium">{{ $enrollment->student?->full_name }}</div>
                  <small class="text-muted">{{ $enrollment->student?->student_id }}</small>
                </td>
                <td>
                  <div class="fw-medium">{{ $enrollment->course?->course_code }}</div>
                  <small class="text-muted">{{ $enrollment->course?->course_title }}</small>
                </td>
                <td>{{ $enrollment->student?->department?->department_name }}</td>
                <td><span class="badge bg-primary-subtle text-primary">{{ $enrollment->semester?->semester_name }}</span></td>
                <td class="text-end">
                  <form method="post" action="{{ route('teacher.enrollments.destroy', $enrollment->id) }}" class="d-inline">
                    @csrf @method('delete')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Drop this student from your course?')"><i class="bi bi-person-dash me-1"></i>Drop</button>
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
