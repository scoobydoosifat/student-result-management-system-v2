@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-header">
		<h5 class="mb-0"><i class="bi bi-clipboard-data me-2 text-primary"></i>Add Result</h5>
	</div>
	<div class="card-body">
		@if ($enrollments->isEmpty())
			<div class="alert alert-info d-flex align-items-center gap-2"><i class="bi bi-info-circle"></i>All enrollments already have results.</div>
			<a class="btn btn-outline-secondary" href="{{ route('results.index') }}">Back</a>
		@else
			<form method="post" action="{{ route('results.store') }}">
				@csrf
				<div class="mb-3">
					<label class="form-label">Enrollment</label>
					<select name="enrollment_id" class="form-select" required>
						<option value="">Select enrollment</option>
						@foreach ($enrollments as $enrollment)
							<option value="{{ $enrollment->id }}" @selected(old('enrollment_id') == $enrollment->id)>{{ $enrollment->student?->student_id }} - {{ $enrollment->student?->full_name }} | {{ $enrollment->course?->course_code }} | {{ $enrollment->semester?->semester_name }}</option>
						@endforeach
					</select>
					@error('enrollment_id')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="row g-3">
					<div class="col-md-3">
						<label class="form-label">Mid Marks <span class="text-muted">(30)</span></label>
						<input type="number" name="mid_marks" class="form-control" min="0" max="30" value="{{ old('mid_marks') }}" required>
						@error('mid_marks')<div class="text-danger small">{{ $message }}</div>@enderror
					</div>
					<div class="col-md-3">
						<label class="form-label">Final Marks <span class="text-muted">(50)</span></label>
						<input type="number" name="final_marks" class="form-control" min="0" max="50" value="{{ old('final_marks') }}" required>
						@error('final_marks')<div class="text-danger small">{{ $message }}</div>@enderror
					</div>
					<div class="col-md-3">
						<label class="form-label">Assignment <span class="text-muted">(10)</span></label>
						<input type="number" name="assignment_marks" class="form-control" min="0" max="10" value="{{ old('assignment_marks') }}" required>
						@error('assignment_marks')<div class="text-danger small">{{ $message }}</div>@enderror
					</div>
					<div class="col-md-3">
						<label class="form-label">Attendance <span class="text-muted">(10)</span></label>
						<input type="number" name="attendance_marks" class="form-control" min="0" max="10" value="{{ old('attendance_marks') }}" required>
						@error('attendance_marks')<div class="text-danger small">{{ $message }}</div>@enderror
					</div>
				</div>
				<div class="mt-4 d-flex gap-2">
					<button class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save Result</button>
					<a class="btn btn-outline-secondary" href="{{ route('results.index') }}">Cancel</a>
				</div>
			</form>
		@endif
	</div>
</div>
@endsection
