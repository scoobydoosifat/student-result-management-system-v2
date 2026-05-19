@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<h5 class="mb-0"><i class="bi bi-clipboard-data me-2 text-primary"></i>Edit Result</h5>
	</div>
	<div class="card-body">
		<div class="alert alert-info d-flex align-items-center gap-2 mb-4">
			<i class="bi bi-person"></i>
			<div>
				<strong>{{ $result->enrollment?->student?->full_name }}</strong> 
				<span class="text-muted">({{ $result->enrollment?->student?->student_id }})</span> | 
				{{ $result->enrollment?->course?->course_code }} | 
				{{ $result->enrollment?->semester?->semester_name }}
			</div>
		</div>
		<form method="post" action="{{ route('results.update', $result->id) }}">
			@csrf @method('put')
			<div class="row g-3">
				<div class="col-md-3">
					<label class="form-label">Mid Marks <span class="text-muted">(30)</span></label>
					<input type="number" name="mid_marks" class="form-control" min="0" max="30" value="{{ old('mid_marks', $result->mid_marks) }}" required>
					@error('mid_marks')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="col-md-3">
					<label class="form-label">Final Marks <span class="text-muted">(50)</span></label>
					<input type="number" name="final_marks" class="form-control" min="0" max="50" value="{{ old('final_marks', $result->final_marks) }}" required>
					@error('final_marks')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="col-md-3">
					<label class="form-label">Assignment <span class="text-muted">(10)</span></label>
					<input type="number" name="assignment_marks" class="form-control" min="0" max="10" value="{{ old('assignment_marks', $result->assignment_marks) }}" required>
					@error('assignment_marks')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="col-md-3">
					<label class="form-label">Attendance <span class="text-muted">(10)</span></label>
					<input type="number" name="attendance_marks" class="form-control" min="0" max="10" value="{{ old('attendance_marks', $result->attendance_marks) }}" required>
					@error('attendance_marks')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
			</div>
			<div class="mt-4 d-flex gap-2">
				<button class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update Result</button>
				<a class="btn btn-outline-secondary" href="{{ route('results.index') }}">Cancel</a>
			</div>
		</form>
	</div>
</div>
@endsection
