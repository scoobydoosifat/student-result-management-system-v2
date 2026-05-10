@extends('layouts.app')
@section('content')
<div class="row g-3 stagger">
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body">
				<h5 class="section-title mb-2">Coordinator Profile</h5>
				<div><strong>Name:</strong> {{ $teacher->full_name }}</div>
				<div><strong>ID:</strong> {{ $teacher->teacher_id }}</div>
				<div><strong>Designation:</strong> {{ $teacher->designation }}</div>
				<div><strong>Department:</strong> {{ $teacher->department?->department_name }}</div>
				<div><strong>Email:</strong> {{ $teacher->email }}</div>
				<div><strong>Phone:</strong> {{ $teacher->phone }}</div>
				@if (session('status'))
					<div class="alert alert-success mt-2 mb-0">{{ session('status') }}</div>
				@endif
				<form method="post" action="{{ route('coordinator.logout') }}" class="mt-3">
					@csrf
					<button class="btn btn-sm btn-outline-danger">Logout</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="card">
			<div class="card-body">
				<h5 class="section-title mb-3">Assigned Courses</h5>
				<div class="table-responsive">
					<table class="table table-sm table-striped">
						<thead>
							<tr>
								<th>Course</th>
								<th>Credit Hours</th>
								<th>Enrollments</th>
								<th>Results Published</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($courseStats as $stat)
								<tr>
									<td>{{ $stat['course']->course_code }} - {{ $stat['course']->course_title }}</td>
									<td>{{ $stat['course']->credit_hours }}</td>
									<td>{{ $stat['enrollment_count'] }}</td>
									<td>{{ $stat['results_published'] }}</td>
								</tr>
							@empty
								<tr><td colspan="4" class="text-muted">No courses assigned.</td></tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
