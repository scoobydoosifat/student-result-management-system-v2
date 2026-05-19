@extends('layouts.app')
@section('content')
<div class="card" style="max-width: 500px; margin: 0 auto;">
	<div class="card-header">
		<h5 class="mb-0"><i class="bi bi-building me-2 text-primary"></i>Add Department</h5>
	</div>
	<div class="card-body">
		<form method="post" action="{{ route('departments.store') }}">
			@csrf
			<div class="mb-3">
				<label class="form-label">Department Name</label>
				<input name="department_name" class="form-control" value="{{ old('department_name') }}" placeholder="e.g., Computer Science" required>
				@error('department_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
			</div>
			<div class="d-flex gap-2">
				<button class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Save</button>
				<a class="btn btn-outline-secondary" href="{{ route('departments.index') }}">Cancel</a>
			</div>
		</form>
	</div>
</div>
@endsection
