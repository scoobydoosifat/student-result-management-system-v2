-- ============================================================
-- Mithila's Database Tables: result_histories, courses (for reporting)
-- ============================================================

-- --------------------------------------------------------
-- Required reference tables
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

INSERT INTO courses (course_code, course_title, credit_hours, department_id, teacher_id, created_at, updated_at) VALUES
('CSE-101', 'Introduction to Computer Science', 3, 1, 1, NOW(), NOW()),
('CSE-201', 'Data Structures and Algorithms', 4, 1, 2, NOW(), NOW()),
('CSE-301', 'Database Management Systems', 3, 1, 1, NOW(), NOW()),
('CSE-302', 'Computer Networks', 3, 1, 3, NOW(), NOW()),
('CSE-401', 'Software Engineering', 3, 1, 2, NOW(), NOW()),
('EEE-101', 'Basic Electrical Engineering', 3, 2, 3, NOW(), NOW()),
('CIV-101', 'Civil Engineering Fundamentals', 3, 3, 4, NOW(), NOW());

UPDATE courses SET credit_hours = 4 WHERE course_code = 'CSE-301';
DELETE FROM courses WHERE course_code = 'CIV-101';

SELECT * FROM courses WHERE department_id = 1;

-- --------------------------------------------------------
-- Table: enrollments (reference needed for results)
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

-- --------------------------------------------------------
-- Table: results (reference needed for result_histories)
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

-- --------------------------------------------------------
-- Table: result_histories
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS result_histories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    result_id BIGINT UNSIGNED NOT NULL,
    old_total_marks TINYINT UNSIGNED NOT NULL,
    old_grade VARCHAR(2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_result_id (result_id),
    INDEX idx_old_grade (old_grade),
    FOREIGN KEY (result_id) REFERENCES results(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO result_histories (result_id, old_total_marks, old_grade, created_at, updated_at) VALUES
(1, 88, 'A+', NOW(), NOW()),
(2, 75, 'B+', NOW(), NOW()),
(3, 82, 'A-', NOW(), NOW()),
(4, 65, 'C+', NOW(), NOW()),
(5, 90, 'A+', NOW(), NOW());

UPDATE result_histories SET old_grade = 'A' WHERE result_id = 1;
DELETE FROM result_histories WHERE id = 5;

SELECT rh.id, s.student_id, s.full_name, c.course_title, r.total_marks, r.letter_grade, 
       rh.old_total_marks, rh.old_grade
FROM result_histories rh
JOIN results r ON rh.result_id = r.id
JOIN enrollments e ON r.enrollment_id = e.id
JOIN students s ON e.student_id = s.id
JOIN courses c ON e.course_id = c.id
ORDER BY rh.created_at DESC;

-- Reporting queries for transcripts
SELECT 
    s.student_id,
    s.full_name,
    d.department_name,
    sem.semester_name,
    c.course_code,
    c.course_title,
    c.credit_hours,
    r.total_marks,
    r.letter_grade,
    r.grade_point
FROM students s
JOIN departments d ON s.department_id = d.id
JOIN semesters sem ON s.semester_id = sem.id
JOIN enrollments e ON s.id = e.student_id
JOIN courses c ON e.course_id = c.id
JOIN results r ON e.id = r.enrollment_id
WHERE s.student_id = 'S-24001'
ORDER BY sem.semester_name;

SELECT 
    s.student_id,
    s.full_name,
    ROUND(SUM(c.credit_hours * r.grade_point) / SUM(c.credit_hours), 2) as cgpa
FROM students s
JOIN enrollments e ON s.id = e.student_id
JOIN courses c ON e.course_id = c.id
JOIN results r ON e.id = r.enrollment_id
GROUP BY s.id, s.student_id, s.full_name
ORDER BY cgpa DESC;