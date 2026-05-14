@extends('layouts.app')
@section('content')
<style>
.coord-header { background: linear-gradient(135deg, var(--purple) 0%, #7c3aed 100%); color: white; }
.quick-action { border-radius: 14px; padding: 1.25rem; border: 2px solid var(--border); text-decoration: none; color: var(--text); transition: all 0.2s; display: flex; flex-direction: column; align-items: center; gap: 0.75rem; }
.quick-action:hover { border-color: var(--accent); background: var(--accent-soft); transform: translateY(-3px); }
.quick-action .icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; }
</style>

<div class="row g-4 stagger">
    <div class="col-lg-4">
        <div class="card profile-card">
            <div class="profile-header coord-header" style="background: linear-gradient(135deg, var(--purple) 0%, #7c3aed 100%);">
                <div class="profile-avatar">{{ substr($teacher->full_name, 0, 1) }}</div>
                <h4 class="mb-1">{{ $teacher->full_name }}</h4>
                <p class="mb-2 opacity-75">{{ $teacher->designation }}</p>
            </div>
            <div class="card-body">
                <div class="profile-item"><span>Coordinator ID</span><span>{{ $teacher->teacher_id }}</span></div>
                <div class="profile-item"><span>Department</span><span>{{ $teacher->department?->department_name }}</span></div>
                <div class="profile-item"><span>Email</span><span>{{ $teacher->email }}</span></div>
                <div class="profile-item"><span>Phone</span><span>{{ $teacher->phone }}</span></div>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center gap-2 mt-3"><i class="bi bi-check-circle"></i>{{ session('status') }}</div>
        @endif
        <div class="card mt-3">
            <div class="card-body">
                <p class="text-muted small mb-2">Quick Actions</p>
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('teacher.students.create') }}" class="quick-action py-3">
                            <div class="icon" style="background: var(--accent-soft); color: var(--accent);"><i class="bi bi-person-plus"></i></div>
                            <span class="small fw-medium">Add Student</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('coordinator.teachers.create') }}" class="quick-action py-3">
                            <div class="icon" style="background: var(--purple-soft); color: var(--purple);"><i class="bi bi-person-badge"></i></div>
                            <span class="small fw-medium">Add Teacher</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body text-center">
                <form method="post" action="{{ route('coordinator.logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card" style="background: var(--accent-soft);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon" style="background: white; color: var(--accent);"><i class="bi bi-book"></i></div>
                        <div><div class="text-muted small">Courses</div><div class="h4 mb-0 fw-bold">{{ count($courseStats) }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card" style="background: var(--success-soft);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon" style="background: white; color: var(--success);"><i class="bi bi-people"></i></div>
                        <div><div class="text-muted small">Total Enrollments</div><div class="h4 mb-0 fw-bold">{{ array_sum(array_column($courseStats, 'enrollment_count')) }}</div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card" style="background: var(--purple-soft);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon" style="background: white; color: var(--purple);"><i class="bi bi-clipboard-check"></i></div>
                        <div><div class="text-muted small">Results Published</div><div class="h4 mb-0 fw-bold">{{ array_sum(array_column($courseStats, 'results_published')) }}</div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-collection me-2 text-primary"></i>Assigned Courses</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Course</th><th>Credits</th><th>Enrollments</th><th>Results</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($courseStats as $stat)
                                <tr>
                                    <td>
                                        <div class="fw-medium">{{ $stat['course']->course_code }}</div>
                                        <small class="text-muted">{{ $stat['course']->course_title }}</small>
                                    </td>
                                    <td><span class="badge bg-primary-subtle text-primary">{{ $stat['course']->credit_hours }}</span></td>
                                    <td><span class="badge bg-success-subtle text-success">{{ $stat['enrollment_count'] }}</span></td>
                                    <td><span class="badge bg-warning-subtle text-warning">{{ $stat['results_published'] }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No courses assigned.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
