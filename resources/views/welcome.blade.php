@extends('layouts.app')
@section('content')
<style>
    .hero-gradient { background: linear-gradient(135deg, var(--accent-soft) 0%, var(--purple-soft) 100%); border-radius: 24px; padding: 3rem; margin-bottom: 2rem; }
</style>
<div class="hero">
    <div class="hero-copy">
        <div class="eyebrow">Welcome to SRMS</div>
        <h1 class="display-title">Student Result Management System</h1>
        <p>Track enrollments, publish results, and generate transcripts in one modern workspace. Simplify academic management with powerful tools.</p>
        <div class="d-flex flex-wrap gap-2 mb-4">
            <span class="tag"><i class="bi bi-mortarboard me-1"></i>Results</span>
            <span class="tag"><i class="bi bi-graph-up me-1"></i>GPA</span>
            <span class="tag"><i class="bi bi-file-earmark-text me-1"></i>Transcripts</span>
            <span class="tag"><i class="bi bi-bar-chart me-1"></i>Reports</span>
        </div>
        <div class="hero-actions">
            <a class="btn btn-primary" href="{{ route('student.login') }}"><i class="bi bi-person me-2"></i>Student Login</a>
            <a class="btn btn-primary" href="{{ route('coordinator.login') }}"><i class="bi bi-shield-check me-2"></i>Coordinator Login</a>
            <a class="btn btn-primary" href="{{ route('teacher.login') }}"><i class="bi bi-book me-2"></i>Teacher Login</a>
        </div>
    </div>
    <div class="hero-card">
        <h3 class="mb-1">Get Started</h3>
        <p class="mb-3 text-muted">Select your role to access the system.</p>
        <a href="{{ route('student.login') }}" class="login-option student">
            <div class="icon"><i class="bi bi-person"></i></div>
            <div>
                <div class="fw-semibold">Student</div>
                <small class="text-muted">View results & transcripts</small>
            </div>
            <i class="bi bi-chevron-right ms-auto text-muted"></i>
        </a>
        <a href="{{ route('coordinator.login') }}" class="login-option coordinator">
            <div class="icon"><i class="bi bi-shield-check"></i></div>
            <div>
                <div class="fw-semibold">Coordinator</div>
                <small class="text-muted">Manage all resources</small>
            </div>
            <i class="bi bi-chevron-right ms-auto text-muted"></i>
        </a>
        <a href="{{ route('teacher.login') }}" class="login-option teacher">
            <div class="icon"><i class="bi bi-book"></i></div>
            <div>
                <div class="fw-semibold">Teacher</div>
                <small class="text-muted">Manage marks & results</small>
            </div>
            <i class="bi bi-chevron-right ms-auto text-muted"></i>
        </a>
    </div>
</div>
<div class="row g-4 mt-2">
    <div class="col-md-4">
        <div class="card stat-card h-100" style="background: var(--accent-soft);">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background: white; color: var(--accent);"><i class="bi bi-clipboard-data"></i></div>
                <div>
                    <div class="text-muted small">Results</div>
                    <div class="h4 mb-0 fw-bold">Track & Manage</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card h-100" style="background: var(--purple-soft);">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background: white; color: var(--purple);"><i class="bi bi-graph-up"></i></div>
                <div>
                    <div class="text-muted small">GPA</div>
                    <div class="h4 mb-0 fw-bold">Calculate & Analyze</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card h-100" style="background: var(--success-soft);">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background: white; color: var(--success);"><i class="bi bi-file-earmark-pdf"></i></div>
                <div>
                    <div class="text-muted small">Transcripts</div>
                    <div class="h4 mb-0 fw-bold">Generate & Download</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
