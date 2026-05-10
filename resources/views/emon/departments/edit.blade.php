@extends('layouts.app')
@section('content')
<div class="card">
	<div class="card-body">
		<h1 class="h5 mb-3">Edit Department</h1>
		<form method="post" action="{{ route('departments.update', $department->id) }}">
			@csrf
			@method('put')
			<label class="form-label">Department Name</label>
			<input name="department_name" class="form-control" value="{{ old('department_name', $department->department_name) }}" required>
			@error('department_name')
				<div class="text-danger small mt-1">{{ $message }}</div>
			@enderror
			<div class="mt-3 d-flex gap-2">
				<button class="btn btn-primary">Update</button>
				<a class="btn btn-outline-secondary" href="{{ route('departments.index') }}">Cancel</a>
			</div>
		</form>
	</div>
</div>
@endsection
