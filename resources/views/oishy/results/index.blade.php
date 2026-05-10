@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-body">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h1 class="section-title mb-0">Results</h1>
			<a class="btn btn-sm btn-primary" href="{{ route('results.create') }}">Add Result</a>
		</div>
		<div class="table-responsive">
			<table class="table table-sm table-striped">
				<thead>
					<tr>
						<th>Student</th>
						<th>Course</th>
						<th>Semester</th>
						<th>Total</th>
						<th>Grade</th>
						<th>GPA</th>
						<th class="text-end">Actions</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($results as $result)
						<tr>
							<td>{{ $result->enrollment?->student?->student_id }} - {{ $result->enrollment?->student?->full_name }}</td>
							<td>{{ $result->enrollment?->course?->course_code }} - {{ $result->enrollment?->course?->course_title }}</td>
							<td>{{ $result->enrollment?->semester?->semester_name }}</td>
							<td>{{ $result->total_marks }}</td>
							<td>{{ $result->letter_grade }}</td>
							<td>{{ $result->grade_point }}</td>
							<td class="text-end">
								<a class="btn btn-sm btn-outline-primary" href="{{ route('results.edit', $result->id) }}">Edit</a>
								<form method="post" action="{{ route('results.destroy', $result->id) }}" class="d-inline">
									@csrf
									@method('delete')
									<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this result?')">Delete</button>
								</form>
							</td>
						</tr>
					@empty
						<tr><td colspan="7" class="text-muted">No results yet.</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
