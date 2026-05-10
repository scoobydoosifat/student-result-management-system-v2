@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-body">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h1 class="h5 mb-0">Enrollments</h1>
			<a class="btn btn-sm btn-primary" href="{{ route('enrollments.create') }}">Add Enrollment</a>
		</div>
		<div class="table-responsive">
			<table class="table table-sm table-striped">
				<thead>
					<tr>
						<th>Student</th>
						<th>Course</th>
						<th>Semester</th>
						<th>Date</th>
						<th class="text-end">Actions</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($enrollments as $enrollment)
						<tr>
							<td>{{ $enrollment->student?->student_id }} - {{ $enrollment->student?->full_name }}</td>
							<td>{{ $enrollment->course?->course_code }} - {{ $enrollment->course?->course_title }}</td>
							<td>{{ $enrollment->semester?->semester_name }}</td>
							<td>{{ $enrollment->enrollment_date }}</td>
							<td class="text-end">
								<a class="btn btn-sm btn-outline-primary" href="{{ route('enrollments.edit', $enrollment->id) }}">Edit</a>
								<form method="post" action="{{ route('enrollments.destroy', $enrollment->id) }}" class="d-inline">
									@csrf
									@method('delete')
									<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this enrollment?')">Delete</button>
								</form>
							</td>
						</tr>
					@empty
						<tr><td colspan="5" class="text-muted">No enrollments yet.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
