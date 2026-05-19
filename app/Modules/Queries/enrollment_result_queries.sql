SELECT st.full_name, c.course_code, r.total_marks, r.letter_grade
FROM enrollments e
JOIN students st ON st.id = e.student_id
JOIN courses c ON c.id = e.course_id
JOIN results r ON r.enrollment_id = e.id;
