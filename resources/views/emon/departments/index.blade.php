@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0"><i class="bi bi-building me-2 text-primary"></i>Departments</h5>
    <a class="btn btn-primary btn-sm" href="{{ route('departments.create') }}"><i class="bi bi-plus-lg me-1"></i>Add Department</a>
  </div>
  <div class="card-body p-0">
    @if($departments->isEmpty())
      <div class="empty-state">
        <div class="icon"><i class="bi bi-building"></i></div>
        <h5>No Departments</h5>
        <p class="text-muted">Create your first department to get started.</p>
        <a class="btn btn-primary" href="{{ route('departments.create') }}"><i class="bi bi-plus-lg me-1"></i>Add Department</a>
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr><th>Department Name</th><th class="text-end">Actions</th></tr>
          </thead>
          <tbody>
            @foreach ($departments as $department)
              <tr>
                <td><span class="fw-medium">{{ $department->department_name }}</span></td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('departments.edit', $department->id) }}"><i class="bi bi-pencil"></i> Edit</a>
                  <form method="post" action="{{ route('departments.destroy', $department->id) }}" class="d-inline">
                    @csrf @method('delete')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this department?')"><i class="bi bi-trash"></i> Delete</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection
