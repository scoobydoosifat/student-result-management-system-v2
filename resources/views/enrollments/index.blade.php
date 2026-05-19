@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="mb-0"><i class="bi bi-clipboard me-2 text-primary"></i>Enrollments</h5>
		<a class="btn btn-primary btn-sm" href="{{ route('enrollments.create') }}"><i class="bi bi-plus-lg me-1"></i>Add Enrollment</a>
	</div>
	<div class="card-body p-0">
		@if($enrollments->isEmpty())
			<div class="empty-state">
				<div class="icon"><i class="bi bi-clipboard"></i></div>
				<h5>No Enrollments</h5>
				<p class="text-muted">Create your first enrollment to get started.</p>
				<a class="btn btn-primary" href="{{ route('enrollments.create') }}"><i class="bi bi-plus-lg me-1"></i>Add Enrollment</a>
			</div>
		@else
			<div class="table-responsive">
				<table class="table table-hover mb-0">
					<thead class="table-light">
						<tr><th>Student</th><th>Course</th><th>Semester</th><th>Date</th><th class="text-end">Actions</th></tr>
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
								<td><span class="badge bg-primary-subtle text-primary">{{ $enrollment->semester?->semester_name }}</span></td>
								<td>{{ $enrollment->enrollment_date }}</td>
								<td class="text-end">
									<a class="btn btn-sm btn-outline-primary" href="{{ route('enrollments.edit', $enrollment->id) }}"><i class="bi bi-pencil"></i> Edit</a>
									<form method="post" action="{{ route('enrollments.destroy', $enrollment->id) }}" class="d-inline">
										@csrf @method('delete')
										<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this enrollment?')"><i class="bi bi-trash"></i> Delete</button>
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
