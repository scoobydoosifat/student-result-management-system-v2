@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="h5 mb-0">Drop Students From Your Courses</h1>
    </div>
    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="table-responsive">
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>Student</th>
            <th>Course</th>
            <th>Department</th>
            <th>Semester</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($enrollments as $enrollment)
            <tr>
              <td>{{ $enrollment->student?->student_id }} - {{ $enrollment->student?->full_name }}</td>
              <td>{{ $enrollment->course?->course_code }} - {{ $enrollment->course?->course_title }}</td>
              <td>{{ $enrollment->student?->department?->department_name }}</td>
              <td>{{ $enrollment->semester?->semester_name }}</td>
              <td class="text-end">
                <form method="post" action="{{ route('teacher.enrollments.destroy', $enrollment->id) }}" class="d-inline">
                  @csrf
                  @method('delete')
                  <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Drop this student from your course?')">Drop</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-muted">No enrollments found for your courses.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
