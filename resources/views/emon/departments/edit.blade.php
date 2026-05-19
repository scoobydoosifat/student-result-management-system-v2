@extends('layouts.app')
@section('content')
<div class="card" style="max-width: 500px; margin: 0 auto;">
	<div class="card-header">
		<h5 class="mb-0"><i class="bi bi-building me-2 text-primary"></i>Edit Department</h5>
	</div>
	<div class="card-body">
		<form method="post" action="{{ route('departments.update', $department->id) }}">
			@csrf @method('put')
			<div class="mb-3">
				<label class="form-label">Department Name</label>
				<input name="department_name" class="form-control" value="{{ old('department_name', $department->department_name) }}" required>
				@error('department_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
			</div>
			<div class="d-flex gap-2">
				<button class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Update</button>
				<a class="btn btn-outline-secondary" href="{{ route('departments.index') }}">Cancel</a>
			</div>
		</form>
	</div>
</div>
@endsection
