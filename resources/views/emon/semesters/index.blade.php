@extends('layouts.app')
@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="h5 mb-0">Semesters</h1>
      <a class="btn btn-sm btn-primary" href="{{ route('semesters.create') }}">Add Semester</a>
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
          @forelse ($semesters as $semester)
            <tr>
              <td>{{ $semester->semester_name }}</td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('semesters.edit', $semester->id) }}">Edit</a>
                <form method="post" action="{{ route('semesters.destroy', $semester->id) }}" class="d-inline">
                  @csrf
                  @method('delete')
                  <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this semester?')">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="2" class="text-muted">No semesters yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
