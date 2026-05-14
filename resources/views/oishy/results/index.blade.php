@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="mb-0"><i class="bi bi-clipboard-data me-2 text-primary"></i>Results</h5>
		<a class="btn btn-primary btn-sm" href="{{ route('results.create') }}"><i class="bi bi-plus-lg me-1"></i>Add Result</a>
	</div>
	<div class="card-body p-0">
		@if($results->isEmpty())
			<div class="empty-state">
				<div class="icon"><i class="bi bi-clipboard-data"></i></div>
				<h5>No Results</h5>
				<p class="text-muted">Add your first result to get started.</p>
				<a class="btn btn-primary" href="{{ route('results.create') }}"><i class="bi bi-plus-lg me-1"></i>Add Result</a>
			</div>
		@else
			<div class="table-responsive">
				<table class="table table-hover mb-0">
					<thead class="table-light">
						<tr><th>Student</th><th>Course</th><th>Semester</th><th>Total</th><th>Grade</th><th>GPA</th><th class="text-end">Actions</th></tr>
					</thead>
					<tbody>
						@foreach ($results as $result)
							<tr>
								<td>
									<div class="fw-medium">{{ $result->enrollment?->student?->full_name }}</div>
									<small class="text-muted">{{ $result->enrollment?->student?->student_id }}</small>
								</td>
								<td>
									<div class="fw-medium">{{ $result->enrollment?->course?->course_code }}</div>
									<small class="text-muted">{{ $result->enrollment?->course?->course_title }}</small>
								</td>
								<td><span class="badge bg-primary-subtle text-primary">{{ $result->enrollment?->semester?->semester_name }}</span></td>
								<td><strong>{{ $result->total_marks }}</strong></td>
								<td>
									@php $grade = $result->letter_grade; $gradeClass = $grade ? (in_array(substr($grade,0,1),['A']) ? 'grade-A' : (in_array(substr($grade,0,1),['B']) ? 'grade-B' : (in_array(substr($grade,0,1),['C']) ? 'grade-C' : (in_array(substr($grade,0,1),['D']) ? 'grade-D' : 'grade-F')))) : ''; @endphp
									<span class="grade-badge {{ $gradeClass }}">{{ $result->letter_grade }}</span>
								</td>
								<td><span class="badge bg-success-subtle text-success">{{ $result->grade_point }}</span></td>
								<td class="text-end">
									<a class="btn btn-sm btn-outline-primary" href="{{ route('results.edit', $result->id) }}"><i class="bi bi-pencil"></i> Edit</a>
									<form method="post" action="{{ route('results.destroy', $result->id) }}" class="d-inline">
										@csrf @method('delete')
										<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this result?')"><i class="bi bi-trash"></i> Delete</button>
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
<style>
.grade-badge { padding: 0.35rem 0.75rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; }
.grade-A { background: var(--success-soft); color: #047857; }
.grade-B { background: var(--accent-soft); color: #0369a1; }
.grade-C { background: var(--warning-soft); color: #b45309; }
.grade-D { background: #fef3c7; color: #d97706; }
.grade-F { background: var(--danger-soft); color: #b91c1c; }
</style>
@endsection
