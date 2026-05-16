SELECT d.department_name, AVG(r.gpa) AS avg_gpa
FROM departments d
JOIN students s ON s.department_id = d.id
JOIN enrollments e ON e.student_id = s.id
JOIN results r ON r.enrollment_id = e.id
GROUP BY d.department_name
ORDER BY avg_gpa DESC;
