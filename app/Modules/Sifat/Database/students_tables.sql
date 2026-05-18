-- ============================================================
-- Sifat's Database Tables: students, student_logins
-- ============================================================

-- --------------------------------------------------------
-- Table: departments (Required for foreign key)
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
('Business Administration', NOW(), NOW());

UPDATE departments SET department_name = 'Computer Science & Engineering' WHERE id = 1;
DELETE FROM departments WHERE id = 3;

-- --------------------------------------------------------
-- Table: semesters (Required for foreign key)
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
('Spring 2025', NOW(), NOW());

UPDATE semesters SET semester_name = 'Spring 2025' WHERE id = 1;
DELETE FROM semesters WHERE id = 2;

-- --------------------------------------------------------
-- Table: students
-- --------------------------------------------------------
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
    INDEX idx_student_id (student_id),
    INDEX idx_department (department_id),
    INDEX idx_semester (semester_id),
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (semester_id) REFERENCES semesters(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

INSERT INTO students (student_id, full_name, email, phone, batch, enrollment_date, password, department_id, semester_id, created_at, updated_at) VALUES
('S-24001', 'Rahim Islam', 'rahim@example.com', '01512345601', '2024', '2024-01-15', 'hashed_password_1', 1, 1, NOW(), NOW()),
('S-24002', 'Fatema Begum', 'fatema@example.com', '01512345602', '2024', '2024-01-15', 'hashed_password_2', 1, 1, NOW(), NOW()),
('S-24003', 'Karim Ahmed', 'karim@example.com', '01512345603', '2024', '2024-01-15', 'hashed_password_3', 1, 1, NOW(), NOW()),
('S-24004', 'Nusrat Jahan', 'nusrat@example.com', '01512345604', '2024', '2024-01-16', 'hashed_password_4', 2, 1, NOW(), NOW()),
('S-24005', 'Mahmud Hasan', 'mahmud@example.com', '01512345605', '2024', '2024-01-16', 'hashed_password_5', 1, 2, NOW(), NOW());

UPDATE students SET full_name = 'Rahim Uddin', email = 'rahim.uddin@example.com' WHERE student_id = 'S-24001';
UPDATE students SET batch = '2024' WHERE department_id = 1;
DELETE FROM students WHERE student_id = 'S-24005';

SELECT * FROM students WHERE student_id = 'S-24001';
SELECT s.student_id, s.full_name, d.department_name
FROM students s
JOIN departments d ON d.id = s.department_id
WHERE s.student_id = 'S-24001';

-- --------------------------------------------------------
-- Table: student_logins
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS student_logins (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_id BIGINT UNSIGNED NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO student_logins (student_id, username, password, created_at, updated_at) VALUES
(1, 'S-24001', 'hashed_password_1', NOW(), NOW()),
(2, 'S-24002', 'hashed_password_2', NOW(), NOW()),
(3, 'S-24003', 'hashed_password_3', NOW(), NOW()),
(4, 'S-24004', 'hashed_password_4', NOW(), NOW()),
(5, 'S-24005', 'hashed_password_5', NOW(), NOW());

UPDATE student_logins SET password = 'new_hashed_password' WHERE student_id = 1;
DELETE FROM student_logins WHERE student_id = 5;

SELECT * FROM student_logins WHERE username = 'S-24001';