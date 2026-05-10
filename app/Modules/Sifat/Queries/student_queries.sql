SELECT s.student_id, s.full_name, d.department_name
FROM students s
JOIN departments d ON d.id = s.department_id
WHERE s.student_id = 'S-24001';
