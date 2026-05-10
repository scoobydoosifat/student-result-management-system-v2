@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-body">
		<h1 class="h5 mb-3">Add Enrollment</h1>
		<form method="post" action="{{ route('enrollments.store') }}">
			@csrf
			<div class="mb-2">
				<label class="form-label">Student</label>
				<select name="student_id" class="form-select" required>
					<option value="">Select student</option>
					@foreach ($students as $student)
						<option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
							{{ $student->student_id }} - {{ $student->full_name }}
						</option>
					@endforeach
				</select>
				@error('student_id')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
			<div class="mb-2">
				<label class="form-label">Course</label>
				<select name="course_id" class="form-select" required>
					<option value="">Select course</option>
					@foreach ($courses as $course)
						<option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
							{{ $course->course_code }} - {{ $course->course_title }}
						</option>
					@endforeach
				</select>
				@error('course_id')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
			<div class="mb-2">
				<label class="form-label">Semester</label>
				<select name="semester_id" class="form-select" required>
					<option value="">Select semester</option>
					@foreach ($semesters as $semester)
						<option value="{{ $semester->id }}" @selected(old('semester_id') == $semester->id)>
							{{ $semester->semester_name }}
						</option>
					@endforeach
				</select>
				@error('semester_id')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
			<div class="mb-2">
				<label class="form-label">Enrollment Date</label>
				<input type="date" name="enrollment_date" class="form-control" value="{{ old('enrollment_date') }}" required>
				@error('enrollment_date')<div class="text-danger small">{{ $message }}</div>@enderror
			</div>
			<div class="mt-3 d-flex gap-2">
				<button class="btn btn-primary">Save</button>
				<a class="btn btn-outline-secondary" href="{{ route('enrollments.index') }}">Cancel</a>
			</div>
		</form>
	</div>
</div>
@endsection
