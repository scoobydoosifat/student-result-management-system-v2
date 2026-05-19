@extends('layouts.app')
@section('content')
<div class="card" style="max-width: 500px; margin: 0 auto;">
	<div class="card-header">
		<h5 class="mb-0"><i class="bi bi-calendar3 me-2 text-primary"></i>Edit Semester</h5>
	</div>
	<div class="card-body">
		<form method="post" action="{{ route('semesters.update', $semester->id) }}">
			@csrf @method('put')
			<div class="mb-3">
				<label class="form-label">Semester Name</label>
				<input name="semester_name" class="form-control" value="{{ old('semester_name', $semester->semester_name) }}" required>
				@error('semester_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
			</div>
			<div class="d-flex gap-2">
				<button class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
				<a class="btn btn-outline-secondary" href="{{ route('semesters.index') }}">Cancel</a>
			</div>
		</form>
	</div>
</div>
@endsection
