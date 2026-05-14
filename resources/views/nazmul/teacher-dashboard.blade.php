@extends('layouts.app')
@section('content')
<style>
.teacher-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 16px; }
.teacher-card h1 { font-size: 1.5rem; font-weight: 600; }
.stat-card { border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: transform 0.2s; }
.stat-card:hover { transform: translateY(-4px); }
.action-btn { border-radius: 10px; padding: 12px 20px; font-weight: 500; display: flex; align-items: center; gap: 8px; }
.course-card { border-left: 4px solid #667eea; }
.course-badge { background: #f3f4f6; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; }
</style>

<div class="row g-4 stagger">
  <div class="col-lg-4">
    <div class="card teacher-card p-4">
      <div class="text-center mb-4">
        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 2rem; font-weight: 600;">{{ substr($teacher->full_name, 0, 1) }}</div>
        <h1 class="mb-1">{{ $teacher->full_name }}</h1>
        <p class="mb-0 opacity-75">{{ $teacher->designation }}</p>
      </div>
      <div class="border-top border-white border-opacity-25 pt-3">
        <div class="d-flex justify-content-between py-2"><span>Teacher ID</span><strong>{{ $teacher->teacher_id }}</strong></div>
        <div class="d-flex justify-content-between py-2"><span>Department</span><strong>{{ $teacher->department?->department_name }}</strong></div>
        <div class="d-flex justify-content-between py-2"><span>Email</span><strong>{{ $teacher->email }}</strong></div>
        <div class="d-flex justify-content-between py-2"><span>Phone</span><strong>{{ $teacher->phone }}</strong></div>
      </div>
      <div class="mt-4">
        <p class="small opacity-75 mb-3">Quick Actions</p>
        <div class="d-flex flex-column gap-2">
          <a class="btn btn-light action-btn" href="{{ route('results.index') }}"><i class="bi bi-clipboard-data"></i> Manage Results</a>
          <a class="btn btn-light action-btn" href="{{ route('result-histories.index') }}"><i class="bi bi-clock-history"></i> Result History</a>
          <a class="btn btn-outline-light action-btn" href="{{ route('teacher.enrollments.index') }}"><i class="bi bi-person-dash"></i> Drop From Course</a>
        </div>
      </div>
      <form method="post" action="{{ route('teacher.logout') }}" class="mt-4">
        @csrf
        <button class="btn btn-outline-light w-100">Logout</button>
      </form>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card stat-card p-3">
          <div class="d-flex align-items-center gap-3">
            <div style="width: 48px; height: 48px; background: #e8f5e9; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #2e7d32; font-size: 1.5rem;"><i class="bi bi-book"></i></div>
            <div><div class="text-muted small">Assigned Courses</div><div class="h4 mb-0 fw-bold">{{ $courses->count() }}</div></div>
          </div>
        </div>
      </div>
    </div>
    <div class="card border-0" style="box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
      <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0 fw-semibold"><i class="bi bi-collection text-primary me-2"></i>Assigned Courses</h5>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Course Code</th><th>Course Title</th><th>Credits</th><th>Department</th></tr></thead>
            <tbody>
              @forelse ($courses as $course)
                <tr class="course-card">
                  <td><span class="course-badge">{{ $course->course_code }}</span></td>
                  <td class="fw-medium">{{ $course->course_title }}</td>
                  <td><span class="badge bg-primary-subtle text-primary">{{ $course->credit_hours }}</span></td>
                  <td>{{ $course->department?->department_name }}</td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No courses assigned yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
