SELECT t.teacher_id, t.full_name, c.course_code
FROM teachers t
JOIN courses c ON c.teacher_id = t.id
WHERE t.department_id = 1;
