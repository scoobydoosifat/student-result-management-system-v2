<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Transcript</title>
	<style>
		body { font-family: Arial, sans-serif; font-size: 12px; color: #111; }
		h1, h2 { margin: 0 0 8px; }
		table { width: 100%; border-collapse: collapse; margin-top: 12px; }
		th, td { border: 1px solid #444; padding: 6px; text-align: left; }
		th { background: #f2f2f2; }
		.meta { margin-bottom: 12px; }
	</style>
</head>
<body>
	<h1>Semester Transcript</h1>
	<div class="meta">
		<div><strong>Student:</strong> {{ $student->full_name }}</div>
		<div><strong>Student ID:</strong> {{ $student->student_id }}</div>
		<div><strong>Department:</strong> {{ $student->department?->department_name }}</div>
		<div><strong>Semester:</strong> {{ $semester?->semester_name ?? 'N/A' }}</div>
	</div>

	<table>
		<thead>
			<tr>
				<th>Course Code</th>
				<th>Course Title</th>
				<th>Credit Hours</th>
				<th>Total Marks</th>
				<th>Letter Grade</th>
				<th>Grade Point</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($rows as $row)
				<tr>
					<td>{{ $row['course_code'] }}</td>
					<td>{{ $row['course_title'] }}</td>
					<td>{{ $row['credit_hours'] }}</td>
					<td>{{ $row['total_marks'] ?? 'N/A' }}</td>
					<td>{{ $row['letter_grade'] ?? 'N/A' }}</td>
					<td>{{ $row['grade_point'] ?? 'N/A' }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<p><strong>Total Credits:</strong> {{ $totalCredits }}</p>
	<p><strong>Semester GPA:</strong> {{ $gpa ?? 'N/A' }}</p>
</body>
</html>
