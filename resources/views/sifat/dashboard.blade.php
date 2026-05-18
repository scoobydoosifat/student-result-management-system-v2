@extends('layouts.app')
@section('content')
<style>
.profile-card { border-radius: 20px; overflow: hidden; }
.profile-header { background: linear-gradient(135deg, var(--accent) 0%, var(--purple) 100%); color: white; padding: 2rem; text-align: center; }
.profile-avatar { width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 600; margin: 0 auto 1rem; border: 3px solid rgba(255,255,255,0.3); }
.gpa-badge { background: rgba(255,255,255,0.2); padding: 0.5rem 1.5rem; border-radius: 999px; display: inline-block; margin-top: 0.5rem; }
.search-card { border-radius: 16px; }
.grade-badge { padding: 0.35rem 0.75rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; }
.grade-A { background: var(--success-soft); color: #047857; }
.grade-B { background: var(--accent-soft); color: #0369a1; }
.grade-C { background: var(--warning-soft); color: #b45309; }
.grade-D { background: #fef3c7; color: #d97706; }
.grade-F { background: var(--danger-soft); color: #b91c1c; }
</style>

<div class="row g-4 stagger">
    <div class="col-lg-4">
        <div class="card profile-card">
            <div class="profile-header">
                <div class="profile-avatar">{{ substr($student->full_name, 0, 1) }}</div>
                <h4 class="mb-1">{{ $student->full_name }}</h4>
                <p class="mb-2 opacity-75">{{ $student->student_id }}</p>
                @if($overallGpa)
                <div class="gpa-badge">
                    <i class="bi bi-trophy me-1"></i>Overall GPA: <strong>{{ $overallGpa }}</strong>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="profile-item"><span>Department</span><span>{{ $student->department?->department_name }}</span></div>
                <div class="profile-item"><span>Semester</span><span>{{ $student->semester?->semester_name }}</span></div>
                <div class="profile-item"><span>Email</span><span>{{ $student->email }}</span></div>
                <div class="profile-item"><span>Phone</span><span>{{ $student->phone }}</span></div>
                <div class="mt-3">
                    <a href="{{ route('student.profile') }}" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-pencil-square me-1"></i>Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body text-center">
                <form method="post" action="{{ route('student.logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar3 me-2 text-primary"></i>Semester Results</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Semester</th><th>GPA</th><th>Transcript</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($semesterStats as $stat)
                                <tr>
                                    <td class="fw-medium">{{ $stat['semester']?->semester_name ?? 'N/A' }}</td>
                                    <td><span class="badge bg-primary-subtle text-primary">{{ $stat['gpa'] ?? 'N/A' }}</span></td>
                                    <td>
                                        @if ($stat['semester'])
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('student.transcript', $stat['semester']->id) }}"><i class="bi bi-download me-1"></i>Download</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">No semester results yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card search-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-search me-2 text-primary"></i>Search Results</h5>
            </div>
            <div class="card-body">
                <form method="get" action="{{ route('student.dashboard') }}" class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Course Code</label>
                        <input name="course_code" class="form-control" list="courseCodes" value="{{ $filters['course_code'] ?? '' }}" placeholder="e.g., CSE101">
                        <datalist id="courseCodes">
                            @foreach ($courses as $course)<option value="{{ $course->course_code }}"></option>@endforeach
                        </datalist>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Semester</label>
                        <select name="semester_id" class="form-select">
                            <option value="">All semesters</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}" @selected(($filters['semester_id'] ?? '') == $semester->id)>{{ $semester->semester_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Grade</label>
                        <select name="letter_grade" class="form-select">
                            <option value="">All grades</option>
                            @foreach (['A+','A','A-','B+','B','B-','C+','C','D','F'] as $grade)
                                <option value="{{ $grade }}" @selected(($filters['letter_grade'] ?? '') === $grade)>{{ $grade }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary"><i class="bi bi-search me-1"></i>Search</button>
                        <a class="btn btn-outline-secondary" href="{{ route('student.dashboard') }}"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr><th>Course</th><th>Semester</th><th>Marks</th><th>Grade</th><th>Point</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($enrollments as $enrollment)
                                <tr>
                                    <td>
                                        <div class="fw-medium">{{ $enrollment->course?->course_code }}</div>
                                        <small class="text-muted">{{ $enrollment->course?->course_title }}</small>
                                    </td>
                                    <td>{{ $enrollment->semester?->semester_name }}</td>
                                    <td>{{ $enrollment->result?->total_marks ?? '-' }}</td>
                                    <td>
                                        @php $grade = $enrollment->result?->letter_grade; $gradeClass = $grade ? (in_array(substr($grade,0,1),['A']) ? 'grade-A' : (in_array(substr($grade,0,1),['B']) ? 'grade-B' : (in_array(substr($grade,0,1),['C']) ? 'grade-C' : (in_array(substr($grade,0,1),['D']) ? 'grade-D' : 'grade-F')))) : ''; @endphp
                                        <span class="grade-badge {{ $gradeClass }}">{{ $enrollment->result?->letter_grade ?? '-' }}</span>
                                    </td>
                                    <td>{{ $enrollment->result?->grade_point ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No matching results found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
