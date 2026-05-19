-- ============================================================
-- Oishy's Database Tables: enrollments, results
-- ============================================================

-- --------------------------------------------------------
-- Required reference tables (departments, semesters, students, teachers)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS departments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS semesters (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    semester_name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS students (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(255) NOT NULL UNIQUE,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL UNIQUE,
    batch VARCHAR(50) NOT NULL,
    enrollment_date DATE NOT NULL,
    password VARCHAR(255) NOT NULL,
    department_id BIGINT UNSIGNED NOT NULL,
    semester_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (semester_id) REFERENCES semesters(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS teachers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    teacher_id VARCHAR(255) NOT NULL UNIQUE,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    designation VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    department_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- --------------------------------------------------------
-- Table: courses
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS courses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(255) NOT NULL UNIQUE,
    course_title VARCHAR(255) NOT NULL,
    credit_hours TINYINT UNSIGNED NOT NULL,
    department_id BIGINT UNSIGNED NOT NULL,
    teacher_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_course_code (course_code),
    INDEX idx_department (department_id),
    INDEX idx_teacher (teacher_id),
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- --------------------------------------------------------
-- Table: enrollments
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS enrollments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    semester_id BIGINT UNSIGNED NOT NULL,
    enrollment_date DATE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY unique_enrollment (student_id, course_id, semester_id),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (semester_id) REFERENCES semesters(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO enrollments (student_id, course_id, semester_id, enrollment_date, created_at, updated_at) VALUES
(1, 1, 1, '2024-01-20', NOW(), NOW()),
(1, 2, 1, '2024-01-20', NOW(), NOW()),
(2, 1, 1, '2024-01-20', NOW(), NOW()),
(2, 2, 1, '2024-01-20', NOW(), NOW()),
(3, 1, 2, '2024-05-15', NOW(), NOW()),
(3, 3, 2, '2024-05-15', NOW(), NOW()),
(4, 2, 1, '2024-01-21', NOW(), NOW()),
(5, 1, 2, '2024-05-16', NOW(), NOW());

UPDATE enrollments SET enrollment_date = '2024-01-22' WHERE id = 1;
DELETE FROM enrollments WHERE id = 8;

SELECT e.id, s.student_id, s.full_name, c.course_code, c.course_title, sem.semester_name
FROM enrollments e
JOIN students s ON e.student_id = s.id
JOIN courses c ON e.course_id = c.id
JOIN semesters sem ON e.semester_id = sem.id
WHERE s.student_id = 'S-24001';

-- --------------------------------------------------------
-- Table: results
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS results (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    enrollment_id BIGINT UNSIGNED NOT NULL UNIQUE,
    mid_marks TINYINT UNSIGNED NOT NULL,
    final_marks TINYINT UNSIGNED NOT NULL,
    assignment_marks TINYINT UNSIGNED NOT NULL,
    attendance_marks TINYINT UNSIGNED NOT NULL,
    total_marks TINYINT UNSIGNED NOT NULL,
    letter_grade VARCHAR(2) NOT NULL,
    grade_point DECIMAL(3,2) NOT NULL,
    gpa DECIMAL(3,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO results (enrollment_id, mid_marks, final_marks, assignment_marks, attendance_marks, total_marks, letter_grade, grade_point, gpa, created_at, updated_at) VALUES
(1, 20, 45, 15, 8, 88, 'A+', 4.00, 4.00, NOW(), NOW()),
(2, 18, 42, 14, 7, 81, 'A', 3.75, 3.88, NOW(), NOW()),
(3, 19, 44, 15, 8, 86, 'A', 3.75, 3.75, NOW(), NOW()),
(4, 17, 40, 13, 6, 76, 'A-', 3.50, 3.63, NOW(), NOW()),
(5, 15, 38, 12, 7, 72, 'B+', 3.25, 3.25, NOW(), NOW()),
(6, 16, 35, 11, 5, 67, 'B', 3.00, 3.00, NOW(), NOW()),
(7, 18, 41, 14, 7, 80, 'A-', 3.50, 3.50, NOW(), NOW());

UPDATE results SET mid_marks = 22, final_marks = 48, total_marks = 94, letter_grade = 'A+', grade_point = 4.00 WHERE enrollment_id = 1;
UPDATE results SET gpa = 3.90 WHERE id IN (SELECT id FROM results WHERE letter_grade = 'A');
DELETE FROM results WHERE enrollment_id = 7;

SELECT r.id, s.student_id, s.full_name, c.course_title, r.mid_marks, r.final_marks, 
       r.total_marks, r.letter_grade, r.grade_point, r.gpa
FROM results r
JOIN enrollments e ON r.enrollment_id = e.id
JOIN students s ON e.student_id = s.id
JOIN courses c ON e.course_id = c.id
WHERE s.student_id = 'S-24001';

SELECT 
    s.student_id,
    s.full_name,
    ROUND(AVG(r.gpa), 2) as average_gpa
FROM students s
JOIN enrollments e ON s.id = e.student_id
JOIN results r ON e.id = r.enrollment_id
GROUP BY s.id, s.student_id, s.full_name
ORDER BY average_gpa DESC;