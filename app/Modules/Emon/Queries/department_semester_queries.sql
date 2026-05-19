SELECT d.department_name, COUNT(s.id) AS student_count
FROM departments d
LEFT JOIN students s ON s.department_id = d.id
GROUP BY d.department_name;
