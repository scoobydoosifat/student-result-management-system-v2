@extends('layouts.app')
@section('content')
<div class="row g-3 stagger">
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body">
				<h5 class="section-title mb-2">Student Profile</h5>
				<div><strong>Name:</strong> {{ $student->full_name }}</div>
				<div><strong>ID:</strong> {{ $student->student_id }}</div>
				<div><strong>Department:</strong> {{ $student->department?->department_name }}</div>
				<div><strong>Current Semester:</strong> {{ $student->semester?->semester_name }}</div>
				<div><strong>Email:</strong> {{ $student->email }}</div>
				<div><strong>Phone:</strong> {{ $student->phone }}</div>
				<div><strong>Overall GPA:</strong> {{ $overallGpa ?? 'N/A' }}</div>
				<form method="post" action="{{ route('student.logout') }}" class="mt-3">
					@csrf
					<button class="btn btn-sm btn-outline-danger">Logout</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="card">
			<div class="card-body">
				<h5 class="section-title mb-3">Semester Results</h5>
				<div class="table-responsive">
					<table class="table table-sm table-striped">
						<thead>
							<tr>
								<th>Semester</th>
								<th>GPA</th>
								<th>Transcript</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($semesterStats as $stat)
								<tr>
									<td>{{ $stat['semester']?->semester_name ?? 'N/A' }}</td>
									<td>{{ $stat['gpa'] ?? 'N/A' }}</td>
									<td>
										@if ($stat['semester'])
											<a class="btn btn-sm btn-outline-primary" href="{{ route('student.transcript', $stat['semester']->id) }}">Download</a>
										@else
											<span class="text-muted">N/A</span>
										@endif
									</td>
								</tr>
							@empty
								<tr><td colspan="3" class="text-muted">No semester results yet.</td></tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card mt-3">
	<div class="card-body">
		<h5 class="section-title mb-3">Search Results</h5>
		<form method="get" action="{{ route('student.dashboard') }}" class="row g-2 mb-3">
			<div class="col-md-4">
				<label class="form-label">Course Code</label>
				<input name="course_code" class="form-control" list="courseCodes" value="{{ $filters['course_code'] ?? '' }}" placeholder="e.g., CSE101">
				<datalist id="courseCodes">
					@foreach ($courses as $course)
						<option value="{{ $course->course_code }}"></option>
					@endforeach
				</datalist>
			</div>
			<div class="col-md-4">
				<label class="form-label">Semester</label>
				<select name="semester_id" class="form-select">
					<option value="">All semesters</option>
					@foreach ($semesters as $semester)
						<option value="{{ $semester->id }}" @selected(($filters['semester_id'] ?? '') == $semester->id)>
							{{ $semester->semester_name }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-4">
				<label class="form-label">Grade</label>
				<select name="letter_grade" class="form-select">
					<option value="">All grades</option>
					@foreach (['A+','A','A-','B+','B','B-','C+','C','D','F'] as $grade)
						<option value="{{ $grade }}" @selected(($filters['letter_grade'] ?? '') === $grade)>{{ $grade }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-12 d-flex gap-2">
				<button class="btn btn-primary">Search</button>
				<a class="btn btn-outline-secondary" href="{{ route('student.dashboard') }}">Reset</a>
			</div>
		</form>
		<div class="table-responsive">
			<table class="table table-sm table-bordered align-middle">
				<thead>
					<tr>
						<th>Course</th>
						<th>Semester</th>
						<th>Total Marks</th>
						<th>Grade</th>
						<th>Grade Point</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($enrollments as $enrollment)
						<tr>
							<td>{{ $enrollment->course?->course_code }} - {{ $enrollment->course?->course_title }}</td>
							<td>{{ $enrollment->semester?->semester_name }}</td>
							<td>{{ $enrollment->result?->total_marks ?? 'N/A' }}</td>
							<td>{{ $enrollment->result?->letter_grade ?? 'N/A' }}</td>
							<td>{{ $enrollment->result?->grade_point ?? 'N/A' }}</td>
						</tr>
					@empty
						<tr><td colspan="5" class="text-muted">No matching results found.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
