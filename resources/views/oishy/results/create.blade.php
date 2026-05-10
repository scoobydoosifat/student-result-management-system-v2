@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-body">
		<h1 class="section-title mb-3">Add Result</h1>
		@if ($enrollments->isEmpty())
			<div class="alert alert-info">All enrollments already have results.</div>
			<a class="btn btn-outline-secondary" href="{{ route('results.index') }}">Back</a>
		@else
			<form method="post" action="{{ route('results.store') }}">
				@csrf
				<div class="mb-2">
					<label class="form-label">Enrollment</label>
					<select name="enrollment_id" class="form-select" required>
						<option value="">Select enrollment</option>
						@foreach ($enrollments as $enrollment)
							<option value="{{ $enrollment->id }}" @selected(old('enrollment_id') == $enrollment->id)>
								{{ $enrollment->student?->student_id }} - {{ $enrollment->student?->full_name }} | {{ $enrollment->course?->course_code }} | {{ $enrollment->semester?->semester_name }}
							</option>
						@endforeach
					</select>
					@error('enrollment_id')<div class="text-danger small">{{ $message }}</div>@enderror
				</div>
				<div class="row">
					<div class="col-md-3 mb-2">
						<label class="form-label">Mid (30)</label>
						<input type="number" name="mid_marks" class="form-control" min="0" max="30" value="{{ old('mid_marks') }}" required>
						@error('mid_marks')<div class="text-danger small">{{ $message }}</div>@enderror
					</div>
					<div class="col-md-3 mb-2">
						<label class="form-label">Final (50)</label>
						<input type="number" name="final_marks" class="form-control" min="0" max="50" value="{{ old('final_marks') }}" required>
						@error('final_marks')<div class="text-danger small">{{ $message }}</div>@enderror
					</div>
					<div class="col-md-3 mb-2">
						<label class="form-label">Assignment (10)</label>
						<input type="number" name="assignment_marks" class="form-control" min="0" max="10" value="{{ old('assignment_marks') }}" required>
						@error('assignment_marks')<div class="text-danger small">{{ $message }}</div>@enderror
					</div>
					<div class="col-md-3 mb-2">
						<label class="form-label">Attendance (10)</label>
						<input type="number" name="attendance_marks" class="form-control" min="0" max="10" value="{{ old('attendance_marks') }}" required>
						@error('attendance_marks')<div class="text-danger small">{{ $message }}</div>@enderror
					</div>
				</div>
				<div class="mt-3 d-flex gap-2">
					<button class="btn btn-primary">Save</button>
					<a class="btn btn-outline-secondary" href="{{ route('results.index') }}">Cancel</a>
				</div>
			</form>
		@endif
	</div>
</div>
@endsection
