@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-body">
		<h1 class="section-title mb-3">Edit Result</h1>
		<div class="mb-3 text-muted">
			{{ $result->enrollment?->student?->student_id }} - {{ $result->enrollment?->student?->full_name }} | {{ $result->enrollment?->course?->course_code }} | {{ $result->enrollment?->semester?->semester_name }}
		</div>
		<form method="post" action="{{ route('results.update', $result->id) }}">
			@csrf
			@method('put')
			<div class="row">
				<div class="col-md-3 mb-2">
					<label class="form-label">Mid (30)</label>
					<input type="number" name="mid_marks" class="form-control" min="0" max="30" value="{{ old('mid_marks', $result->mid_marks) }}" required>
					@error('mid_marks')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="col-md-3 mb-2">
					<label class="form-label">Final (50)</label>
					<input type="number" name="final_marks" class="form-control" min="0" max="50" value="{{ old('final_marks', $result->final_marks) }}" required>
					@error('final_marks')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="col-md-3 mb-2">
					<label class="form-label">Assignment (10)</label>
					<input type="number" name="assignment_marks" class="form-control" min="0" max="10" value="{{ old('assignment_marks', $result->assignment_marks) }}" required>
					@error('assignment_marks')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="col-md-3 mb-2">
					<label class="form-label">Attendance (10)</label>
					<input type="number" name="attendance_marks" class="form-control" min="0" max="10" value="{{ old('attendance_marks', $result->attendance_marks) }}" required>
					@error('attendance_marks')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
			</div>
			<div class="mt-3 d-flex gap-2">
				<button class="btn btn-primary">Update</button>
				<a class="btn btn-outline-secondary" href="{{ route('results.index') }}">Cancel</a>
			</div>
		</form>
	</div>
</div>
@endsection
