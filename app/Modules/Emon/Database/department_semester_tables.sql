-- ============================================================
-- Emon's Database Tables: departments, semesters
-- ============================================================

-- --------------------------------------------------------
-- Table: departments
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS departments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

INSERT INTO departments (department_name, created_at, updated_at) VALUES
('Computer Science & Engineering', NOW(), NOW()),
('Electrical & Electronic Engineering', NOW(), NOW()),
('Civil Engineering', NOW(), NOW()),
('Mechanical Engineering', NOW(), NOW()),
('Business Administration', NOW(), NOW()),
('English', NOW(), NOW()),
('Mathematics', NOW(), NOW()),
('Physics', NOW(), NOW());

UPDATE departments SET department_name = 'Computer Science & Engineering (CSE)' WHERE id = 1;
DELETE FROM departments WHERE id = 8;

SELECT * FROM departments ORDER BY department_name;

SELECT COUNT(*) as total_departments FROM departments;

-- --------------------------------------------------------
-- Table: semesters
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS semesters (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    semester_name VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

INSERT INTO semesters (semester_name, created_at, updated_at) VALUES
('Spring 2024', NOW(), NOW()),
('Summer 2024', NOW(), NOW()),
('Autumn 2024', NOW(), NOW()),
('Spring 2025', NOW(), NOW()),
('Summer 2025', NOW(), NOW()),
('Autumn 2025', NOW(), NOW()),
('Spring 2026', NOW(), NOW());

UPDATE semesters SET semester_name = 'Spring 2024' WHERE id = 1;
DELETE FROM semesters WHERE id = 7;

SELECT * FROM semesters ORDER BY semester_name DESC;

SELECT COUNT(*) as total_semesters FROM semesters;

-- Additional management queries
SELECT department_name, 
       (SELECT COUNT(*) FROM students WHERE department_id = departments.id) as student_count,
       (SELECT COUNT(*) FROM teachers WHERE department_id = departments.id) as teacher_count
FROM departments;

SELECT 
    sem.semester_name,
    COUNT(DISTINCT e.student_id) as total_students,
    COUNT(DISTINCT e.course_id) as total_courses
FROM semesters sem
LEFT JOIN enrollments e ON sem.id = e.semester_id
GROUP BY sem.id, sem.semester_name
ORDER BY sem.semester_name;

-- --------------------------------------------------------
-- Additional: courses table (for department-semester management)
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
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

INSERT INTO courses (course_code, course_title, credit_hours, department_id, teacher_id, created_at, updated_at) VALUES
('CSE-101', 'Introduction to Computer Science', 3, 1, 1, NOW(), NOW()),
('CSE-201', 'Data Structures and Algorithms', 4, 1, 2, NOW(), NOW()),
('EEE-101', 'Basic Electrical Engineering', 3, 2, 3, NOW(), NOW()),
('CIV-101', 'Civil Engineering Fundamentals', 3, 3, 4, NOW(), NOW()),
('BUS-101', 'Introduction to Business', 3, 5, 5, NOW(), NOW());

UPDATE courses SET credit_hours = 3 WHERE department_id = 1;
DELETE FROM courses WHERE id = 5;

SELECT c.course_code, c.course_title, c.credit_hours, d.department_name
FROM courses c
JOIN departments d ON c.department_id = d.id
ORDER BY d.department_name, c.course_code;