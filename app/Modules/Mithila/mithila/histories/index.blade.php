@extends('layouts.app')
@section('content')
<style>
.history-card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 16px; }
.history-card .card-header { background: white; border-bottom: 1px solid #f0f0f0; border-radius: 12px 12px 0 0; }
.grade-badge { font-size: 1.2rem; padding: 8px 16px; border-radius: 8px; }
.change-badge { font-size: 0.85rem; }
.student-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; }
</style>

<div class="mb-4">
  <a href="{{ route('teacher.dashboard') }}" class="text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Dashboard</a>
</div>

<div class="card border-0" style="box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
  <div class="card-header bg-white py-4">
    <h4 class="mb-0 fw-semibold"><i class="bi bi-clock-history text-primary me-2"></i>Result History</h4>
    <p class="text-muted mb-0 mt-1">Track all grade modifications for your courses</p>
  </div>
  <div class="card-body p-0">
    @if($histories->isEmpty())
      <div class="text-center py-5">
        <div style="width: 80px; height: 80px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 2rem;">📋</div>
        <h5 class="text-muted">No History Found</h5>
        <p class="text-muted">No grade modifications have been recorded yet.</p>
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light"><tr><th>Student</th><th>Course</th><th>Old Grade</th><th>New Grade</th><th>Changed</th><th>Time</th></tr></thead>
          <tbody>
            @foreach($histories as $history)
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="student-avatar">{{ substr($history->result?->enrollment?->student?->full_name ?? 'U', 0, 1) }}</div>
                    <div>
                      <div class="fw-medium">{{ $history->result?->enrollment?->student?->full_name ?? 'Unknown' }}</div>
                      <div class="small text-muted">{{ $history->result?->enrollment?->student?->student_id }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="fw-medium">{{ $history->result?->enrollment?->course?->course_code }}</div>
                  <div class="small text-muted">{{ $history->result?->enrollment?->course?->course_title }}</div>
                </td>
                <td><span class="badge bg-warning text-dark grade-badge">{{ $history->old_grade ?? 'N/A' }}</span></td>
                <td><span class="badge bg-success grade-badge">{{ $history->result?->letter_grade }}</span></td>
                <td>
                  @php
                    $oldTotal = $history->old_total_marks ?? 0;
                    $newTotal = $history->result?->total_marks ?? 0;
                    $diff = $newTotal - $oldTotal;
                  @endphp
                  <span class="badge {{ $diff >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} change-badge">
                    {{ $diff >= 0 ? '+' : '' }}{{ $diff }} marks
                  </span>
                </td>
                <td class="text-muted small">{{ $history->updated_at->diffForHumans() }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection
