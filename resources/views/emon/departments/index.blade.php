@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="h5 mb-0">Departments</h1>
      <a class="btn btn-sm btn-primary" href="{{ route('departments.create') }}">Add Department</a>
    </div>
    <div class="table-responsive">
      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($departments as $department)
            <tr>
              <td>{{ $department->department_name }}</td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('departments.edit', $department->id) }}">Edit</a>
                <form method="post" action="{{ route('departments.destroy', $department->id) }}" class="d-inline">
                  @csrf
                  @method('delete')
                  <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this department?')">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="2" class="text-muted">No departments yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
