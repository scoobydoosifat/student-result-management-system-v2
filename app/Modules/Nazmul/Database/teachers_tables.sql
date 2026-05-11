-- ============================================================
-- Nazmul's Database Tables: teachers, teacher_logins
-- ============================================================

-- --------------------------------------------------------
-- Required reference table: departments
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

-- --------------------------------------------------------
-- Table: teachers
-- --------------------------------------------------------
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
    INDEX idx_teacher_id (teacher_id),
    INDEX idx_department (department_id),
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

INSERT INTO teachers (teacher_id, full_name, email, designation, phone, password, department_id, created_at, updated_at) VALUES
('T-001', 'Dr. Mohammad Ali', 'ali@example.com', 'Professor', '01711234561', 'hashed_password_1', 1, NOW(), NOW()),
('T-002', 'Dr. Sarah Ahmed', 'sarah@example.com', 'Associate Professor', '01711234562', 'hashed_password_2', 1, NOW(), NOW()),
('T-003', 'Mr. Rahman Khan', 'rahman@example.com', 'Assistant Professor', '01711234563', 'hashed_password_3', 2, NOW(), NOW()),
('T-004', 'Ms. Jahanara Begum', 'jahanara@example.com', 'Lecturer', '01711234564', 'hashed_password_4', 1, NOW(), NOW()),
('T-005', 'Mr. Kamal Hossain', 'kamal@example.com', 'Senior Lecturer', '01711234565', 'hashed_password_5', 3, NOW(), NOW());

UPDATE teachers SET designation = 'Professor' WHERE teacher_id = 'T-002';
UPDATE teachers SET department_id = 1 WHERE teacher_id = 'T-005';
DELETE FROM teachers WHERE teacher_id = 'T-005';

SELECT t.id, t.teacher_id, t.full_name, t.email, t.designation, d.department_name
FROM teachers t
JOIN departments d ON t.department_id = d.id
WHERE t.teacher_id = 'T-001';

SELECT * FROM teachers WHERE department_id = 1;

-- --------------------------------------------------------
-- Table: teacher_logins
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS teacher_logins (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    teacher_id BIGINT UNSIGNED NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO teacher_logins (teacher_id, username, password, created_at, updated_at) VALUES
(1, 'T-001', 'hashed_password_1', NOW(), NOW()),
(2, 'T-002', 'hashed_password_2', NOW(), NOW()),
(3, 'T-003', 'hashed_password_3', NOW(), NOW()),
(4, 'T-004', 'hashed_password_4', NOW(), NOW()),
(5, 'T-005', 'hashed_password_5', NOW(), NOW());

UPDATE teacher_logins SET password = 'new_password_hash' WHERE teacher_id = 1;
DELETE FROM teacher_logins WHERE teacher_id = 5;

SELECT * FROM teacher_logins WHERE username = 'T-001';

-- Additional queries for teacher management
SELECT t.teacher_id, t.full_name, t.designation, d.department_name, tl.username
FROM teachers t
JOIN departments d ON t.department_id = d.id
LEFT JOIN teacher_logins tl ON t.id = tl.teacher_id
ORDER BY t.teacher_id;