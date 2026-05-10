@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-body">
		<h1 class="h5 mb-3">Edit Semester</h1>
		<form method="post" action="{{ route('semesters.update', $semester->id) }}">
			@csrf
			@method('put')
			<label class="form-label">Semester Name</label>
			<input name="semester_name" class="form-control" value="{{ old('semester_name', $semester->semester_name) }}" required>
			@error('semester_name')
				<div class="text-danger small mt-1">{{ $message }}</div>
			@enderror
			<div class="mt-3 d-flex gap-2">
				<button class="btn btn-primary">Update</button>
				<a class="btn btn-outline-secondary" href="{{ route('semesters.index') }}">Cancel</a>
			</div>
		</form>
	</div>
</div>
@endsection
