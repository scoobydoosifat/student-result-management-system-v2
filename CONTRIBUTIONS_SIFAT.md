# SIFAT IBNE MAZIB — Student Module Documentation

**Student Result Management System (SRMS)**
**Developer:** Sifat Ibne Mazib (Group Leader)
**Student ID:** 2023200000068
**Branch:** `sifat`
**Commit:** `d0bcb85` — *"Add Sifat module files"*

---

# Table of Contents

1. [Role & Responsibilities](#1-role--responsibilities)
2. [Module Overview](#2-module-overview)
3. [Technical Contributions](#3-technical-contributions)
4. [File Structure](#4-file-structure)
5. [Controllers & Backend Logic](#5-controllers--backend-logic)
6. [Frontend Views](#6-frontend-views)
7. [Database Design](#7-database-design)
8. [System Workflow](#8-system-workflow)
9. [Key Features Implemented](#9-key-features-implemented)
10. [Code Location Summary](#10-code-location-summary)

---

# 1. Role & Responsibilities

As the **Group Leader** of this project, Sifat was responsible for both technical implementation and project coordination. The Student Module is one of the most critical parts of SRMS as it provides the main interface for students to view their academic performance.

| Responsibility | Description |
|---------------|-------------|
| **Student Authentication** | Login/logout system with secure session management |
| **Student Dashboard** | Display GPA, semester results, and enrollment data |
| **Profile Management** | Allow students to update personal information |
| **Password Management** | Secure password change with verification |
| **Result Filtering** | Search/filter results by course, semester, or grade |
| **GPA Calculation** | Dynamic GPA calculation using credit hours and grade points |
| **Project Coordination** | Led the team, integrated all modules, managed project structure |
| **Database Design** | Designed student and student_login tables with proper relationships |

---

# 2. Module Overview

Sifat's module provides the student-facing functionality of SRMS. Students can log in, view their dashboard with grades and GPA, filter their results, and manage their profile.

```
┌─────────────────────────────────────────────────────────────────┐
│                        SIFAT MODULE                              │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│   ┌─────────────────────┐    ┌─────────────────────────────┐    │
│   │  StudentAuth        │    │  StudentDashboard          │    │
│   │  Controller         │    │  Controller                 │    │
│   │  - login            │    │  - index (dashboard)        │    │
│   │  - logout           │    │  - profile                  │    │
│   │  - showLoginForm    │    │  - updateProfile            │    │
│   └──────────┬──────────┘    │  - changePassword           │    │
│              │                │  - calculateGPA             │    │
│              │                │  - applyFilters             │    │
│              ▼                └──────────────┬──────────────┘    │
│   ┌─────────────────────┐                   │                   │
│   │  student-login      │                   ▼                   │
│   │  (View)             │    ┌─────────────────────────────────┐ │
│   └─────────────────────┘    │         Dashboard Views         │ │
│                              │  - dashboard.blade.php          │ │
│                              │  - profile.blade.php           │ │
│                              └─────────────────────────────────┘ │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

# 3. Technical Contributions

## 3.1 Controllers Built

| Controller | File | Lines | Methods |
|------------|------|-------|---------|
| `StudentAuthController` | `app/Modules/Sifat/Controllers/StudentAuthController.php` | 46 | showLoginForm, login, logout |
| `StudentDashboardController` | `app/Modules/Sifat/Controllers/StudentDashboardController.php` | 155 | index, profile, updateProfile, changePassword, applyFilters, buildSemesterStats, calculateGpa |

## 3.2 Views Built

| View | Purpose |
|------|---------|
| `resources/views/sifat/student-login.blade.php` | Student login form with validation |
| `resources/views/sifat/dashboard.blade.php` | Main dashboard with GPA, semester results, search filters |
| `resources/views/sifat/profile.blade.php` | Profile edit and password change forms |

## 3.3 Database Files

| File | Purpose |
|------|---------|
| `database/migrations/2026_01_01_000003_create_students_table.php` | Students table migration (shared) |
| `database/migrations/2026_01_01_000009_create_student_logins_table.php` | Student logins table migration (shared) |
| `database/seeders/DatabaseSeeder.php` | Dynamic data population with students, enrollments, results |
| `app/Modules/Sifat/Database/students_tables.sql` | Standalone SQL schema with seed data |
| `app/Modules/Sifat/Queries/student_queries.sql` | SQL query examples for student data |

## 3.4 Shared Models Used

| Model | Usage in Sifat's Module |
|-------|------------------------|
| `App\Models\Student` | Fetch student data with department/semester relationships |
| `App\Models\StudentLogin` | Authentication and session management |
| `App\Models\Department` | Display student's department in dashboard |
| `App\Models\Semester` | Display current semester and filter options |
| `App\Models\Enrollment` | Fetch all enrollments with course/result relationships |
| `App\Models\Course` | Display enrolled courses and filter by course code |
| `App\Models\Result` | Display marks, grades, and grade points |

---

# 4. File Structure

```
📁 app/Modules/Sifat/
├── 📁 Controllers/
│   ├── StudentAuthController.php
│   └── StudentDashboardController.php
├── 📁 Database/
│   └── students_tables.sql
├── 📁 Documentation/
│   └── README.md
└── 📁 Queries/
    └── student_queries.sql

📁 resources/views/sifat/
├── student-login.blade.php
├── dashboard.blade.php
└── profile.blade.php

📁 database/
├── migrations/
│   ├── 2026_01_01_000003_create_students_table.php
│   └── 2026_01_01_000009_create_student_logins_table.php
└── seeders/
    └── DatabaseSeeder.php (handles student data seeding)
```

---

# 5. Controllers & Backend Logic

## 5.1 StudentAuthController

The `StudentAuthController` handles student authentication with secure password hashing and session management.

```php
// Password verification using Laravel's Hash facade
if (!$login || !Hash::check($credentials['password'], $login->password)) {
    return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
}

// Session creation for authenticated student
session([
    'student_id' => $login->student_id,
    'student_name' => $login->student?->full_name,
]);
```

**Route names defined:** `student.login`, `student.login.submit`, `student.logout`

### Methods Breakdown

| Method | HTTP Verb | URI | Description |
|--------|-----------|-----|-------------|
| `showLoginForm()` | GET | `/student/login` | Display login form |
| `login()` | POST | `/student/login` | Authenticate student |
| `logout()` | POST | `/student/logout` | Clear session and logout |

### Workflow

```
Student → GET /student/login
       │
       ├─> Display login form (username/password)
       │
       └─> POST /student/login
             ├─> Validate: username & password required
             ├─> Query StudentLogin table with username
             ├─> Verify password using Hash::check()
             ├─> Success → Create session → Redirect to dashboard
             └─> Failure → Return with error message
```

---

## 5.2 StudentDashboardController

The `StudentDashboardController` is the core of the student module. It provides the dashboard view, profile management, password change, and GPA calculation.

### Key Implementation Details

1. **Session-based Authentication**: Uses `session('student_id')` to identify the logged-in student
2. **Eager Loading**: Uses `Student::with(['department', 'semester', 'login'])` to prevent N+1 queries
3. **Dynamic GPA Calculation**: Calculates GPA using credit hours and grade points from related tables
4. **Advanced Filtering**: Filter results by course code, semester, or letter grade
5. **Semester-wise Statistics**: Groups enrollments by semester with individual GPA

### Methods Breakdown

| Method | HTTP Verb | URI | Description |
|--------|-----------|-----|-------------|
| `index()` | GET | `/student/dashboard` | Main dashboard with all data |
| `profile()` | GET | `/student/profile` | View profile page |
| `updateProfile()` | PUT | `/student/profile` | Update name, email, phone |
| `changePassword()` | PUT | `/student/password` | Change password with verification |

### GPA Calculation Logic

```php
private function calculateGpa(Collection $enrollments): ?float
{
    $totalCredits = 0;
    $totalPoints = 0.0;

    foreach ($enrollments as $enrollment) {
        if (!$enrollment->course || !$enrollment->result) {
            continue;
        }

        $credits = (int) $enrollment->course->credit_hours;
        $totalCredits += $credits;
        $totalPoints += $enrollment->result->grade_point * $credits;
    }

    if ($totalCredits === 0) {
        return null;
    }

    return round($totalPoints / $totalCredits, 2);
}
```

### Filter Application Logic

```php
private function applyFilters($query, Request $request)
{
    // Filter by course code (partial match)
    if ($request->filled('course_code')) {
        $query->whereHas('course', function ($builder) use ($request) {
            $builder->where('course_code', 'like', '%' . $request->course_code . '%');
        });
    }

    // Filter by semester
    if ($request->filled('semester_id')) {
        $query->where('semester_id', $request->semester_id);
    }

    // Filter by letter grade
    if ($request->filled('letter_grade')) {
        $query->whereHas('result', function ($builder) use ($request) {
            $builder->where('letter_grade', $request->letter_grade);
        });
    }

    return $query;
}
```

### Profile Update Validation

```php
$data = $request->validate([
    'full_name' => 'required|string',
    'email' => 'required|email|unique:students,email,' . $student->id,
    'phone' => 'required|string|unique:students,phone,' . $student->id,
]);
```

### Password Change Validation

```php
$data = $request->validate([
    'current_password' => 'required',
    'new_password' => 'required|min:6|confirmed',
]);

// Verify current password before allowing change
if (!Hash::check($data['current_password'], $studentLogin->password)) {
    return back()->withErrors(['current_password' => 'Current password is incorrect']);
}
```

---

# 6. Frontend Views

## 6.1 Design Principles

- **Consistent Layout**: All views extend `layouts.app` (Bootstrap 5 base)
- **Modern UI**: Gradient profile headers, color-coded grade badges
- **Responsive Design**: Works on desktop and mobile
- **Form Validation**: Client-side HTML5 + Laravel server-side validation
- **Interactive Filters**: Search results by course code, semester, or grade
- **Visual Feedback**: Success/error messages, loading states

## 6.2 student-login.blade.php

```
┌─────────────────────────────────────────────┐
│              STUDENT LOGIN                   │
│  ┌─────────────────────────────────────────┐│
│  │         👤                               ││
│  │    Student Login                        ││
│  │  Access your dashboard and transcript  ││
│  │  history.                               ││
│  ├─────────────────────────────────────────┤│
│  │  Username:  [S-24001          ] 👤      ││
│  │  Password:  [************    ] 🔒       ││
│  │  [Login]                                 ││
│  │  Demo: username S-24001, password       ││
│  └─────────────────────────────────────────┘│
└─────────────────────────────────────────────┘
```

## 6.3 dashboard.blade.php

The dashboard has two main sections:

### Left Column - Profile Card
```
┌─────────────────────────────────┐
│  👤 Sifat Mazib                 │
│     S-24001                    │
│  ┌───────────────────────────┐  │
│  │ Department: CSE           │  │
│  │ Semester: Spring 2025     │  │
│  │ Email: sifat@uni.edu.bd   │  │
│  │ Phone: 01720000001        │  │
│  │ Overall GPA: 3.75         │  │
│  │ [Edit Profile]            │  │
│  └───────────────────────────┘  │
│  [Logout]                        │
└─────────────────────────────────┘
```

### Right Column - Results

**Semester Results Table:**
```
┌─────────────────────────────────────────────────────┐
│  Semester Results                        [Download]│
│  ─────────────────────────────────────────────────│
│  Semester      │ GPA       │ Transcript            │
│  ─────────────────────────────────────────────────│
│  Spring 2025   │ 3.75      │ [Download]            │
│  Summer 2025   │ 3.50      │ [Download]            │
│  Fall 2025     │ 3.25      │ [Download]            │
└─────────────────────────────────────────────────────┘
```

**Search/Filter Section:**
```
┌─────────────────────────────────────────────────────┐
│  Search Results                                     │
│  Course: [CSE101 ▼]  Semester: [All ▼]  Grade: [All ▼]
│  [Search] [Reset]                                   │
├─────────────────────────────────────────────────────┤
│  Course    │ Semester  │ Marks │ Grade │ Point    │
│  ──────────────────────────────────────────────────│
│  CSE101    │ Sp 2025   │ 84    │  A    │ 4.00     │
│  CSE201    │ Sp 2025   │ 76    │  B+   │ 3.25     │
│  CSE301    │ Su 2025   │ 71    │  A-   │ 3.50     │
└─────────────────────────────────────────────────────┘
```

**Grade Color Coding:**
| Grade | Color | Background |
|-------|-------|------------|
| A+, A, A- | Green | #d1fae5 |
| B+, B, B- | Blue | #dbeafe |
| C+, C | Orange | #fed7aa |
| D | Yellow | #fef3c7 |
| F | Red | #fee2e2 |

## 6.4 profile.blade.php

```
┌─────────────────────────────────────────────────────┐
│  UPDATE PROFILE                    CHANGE PASSWORD │
│  ─────────────────────────────────────────────────  │
│  Student ID: S-24001 [disabled]                    │
│  Full Name:  [Sifat Mazib          ]                │
│  Email:      [sifat@uni.edu.bd     ]                │
│  Phone:      [01720000001           ]                │
│  Department: CSE [disabled]                         │
│  Semester:   Spring 2025 [disabled]                │
│  [Save Changes] [Cancel]                           │
│                                                      │
│  Current Password: [************]                  │
│  New Password:    [************]                  │
│  Confirm:         [************]                  │
│  [Change Password]                                 │
└─────────────────────────────────────────────────────┘
```

---

# 7. Database Design

## 7.1 Entity Relationship Diagram - Sifat's Tables

```
┌─────────────────────┐       ┌─────────────────────┐
│     departments     │       │     semesters      │
│   (Emon's Module)   │       │   (Emon's Module)  │
├─────────────────────┤       ├─────────────────────┤
│ id (PK)             │       │ id (PK)             │
│ department_name     │       │ semester_name       │
└──────────┬──────────┘       └──────────┬──────────┘
           │                              │
           │    ┌─────────────────┐      │
           └────►     students     ◄─────┘
                  ├─────────────────┤
                  │ id (PK)         │
                  │ student_id (UK) │
                  │ full_name       │
                  │ email (UK)      │
                  │ phone (UK)      │
                  │ batch           │
                  │ enrollment_date │
                  │ password        │
                  │ department_id FK│──────────┐
                  │ semester_id FK  │          │
                  │ created_at      │          │
                  │ updated_at      │          │
                  └────────┬────────┘          │
                           │                   │
                  ┌────────▼────────┐          │
                  │  student_logins │          │
                  │  (My Table)     │          │
                  ├─────────────────┤          │
                  │ id (PK)         │          │
                  │ student_id (FK) │──────────┘
                  │ username (UK)   │
                  │ password        │
                  │ created_at      │
                  │ updated_at      │
                  └─────────────────┘
```

## 7.2 Complete System Database - All Team Members' Tables

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                        COMPLETE DATABASE STRUCTURE                          │
│                        (All Team Members' Work)                             │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  EMON'S TABLES (Foundation):                                               │
│  ┌───────────────────┐    ┌───────────────────┐    ┌───────────────────┐  │
│  │   departments     │    │   semesters       │    │    courses        │  │
│  ├───────────────────┤    ├───────────────────┤    ├───────────────────┤  │
│  │ id (PK)           │    │ id (PK)           │    │ id (PK)           │  │
│  │ department_name   │    │ semester_name     │    │ course_code       │  │
│  └─────────┬─────────┘    └─────────┬─────────┘    │ course_title      │  │
│            │                       │              │ credit_hours     │  │
│            │                       │              │ department_id FK │──┘
│            │                       │              │ teacher_id FK    │──┐
│            ▼                       ▼              └───────────────────┘  │
│  ┌───────────────────┐    ┌───────────────────┐                        │
│  │   teachers        │    │    students       │                        │
│  │ (Nazmul's Module) │    │  (Sifat's Module) │                        │
│  ├───────────────────┤    ├───────────────────┤                        │
│  │ id (PK)           │    │ id (PK)           │◄──┐                    │
│  │ teacher_id        │    │ student_id (UK)   │   │                    │
│  │ full_name         │    │ full_name         │   │                    │
│  │ department_id FK  │───►│ email (UK)        │   │                    │
│  │ ...               │    │ phone (UK)        │   │                    │
│  └───────────────────┘    │ department_id FK  │◄──┘                    │
│                           │ semester_id FK    │◄──┘                    │
│                           └─────────┬─────────┘                        │
│                                     │                                   │
│                           ┌─────────▼─────────┐                        │
│                           │  student_logins   │                        │
│                           │  (Sifat's Module) │                        │
│                           ├───────────────────┤                        │
│                           │ id (PK)           │                        │
│                           │ student_id (FK)───┼───┐                    │
│                           │ username (UK)     │   │                    │
│                           │ password           │   │                    │
│                           └───────────────────┘   │                    │
│                                                     │                    │
│  NAZMUL'S TABLES:                                    │                    │
│  ┌───────────────────┐                             │                    │
│  │  teacher_logins   │                             │                    │
│  ├───────────────────┤                             │                    │
│  │ id (PK)           │                             │                    │
│  │ teacher_id (FK)───┘                            │                    │
│  │ username (UK)     │                             │                    │
│  │ password          │                             │                    │
│  └───────────────────┘                             │                    │
│                                                     │                    │
│  OISHY'S TABLES:                                     │                    │
│  ┌───────────────────┐                             │                    │
│  │  enrollments      │◄────────────────────────────┘                    │
│  ├───────────────────┤                                                  │
│  │ id (PK)           │                                                  │
│  │ student_id (FK)───┼─────────────┐                                    │
│  │ course_id (FK)────┼───────────┐ │                                    │
│  │ semester_id (FK)──┼───────┐   │                                    │
│  │ enrollment_date   │       │   │                                    │
│  └─────────┬─────────┘       │   │                                    │
│            │                 │   │                                    │
│            └────────┬────────┘   │                                    │
│                     ▼            ▼                                    │
│  ┌───────────────────┐    ┌───────────────────┐                        │
│  │    results        │    │ result_histories │                        │
│  │  (Oishy's Module) │    │ (Mithila's Module)│                        │
│  ├───────────────────┤    ├───────────────────┤                        │
│  │ id (PK)           │    │ id (PK)           │                        │
│  │ enrollment_id (FK)┴───►│ old_enrollment_id │                        │
│  │ mid_marks         │    │ old_result_id     │                        │
│  │ final_marks       │    │ ...              │                        │
│  │ assignment_marks  │    └───────────────────┘                        │
│  │ attendance_marks  │                                                 │
│  │ total_marks       │                                                 │
│  │ letter_grade      │                                                 │
│  │ grade_point       │                                                 │
│  │ gpa               │                                                 │
│  └───────────────────┘                                                 │
│                                                                             │
│  All connected through FOREIGN KEYS                                         │
└─────────────────────────────────────────────────────────────────────────────┘
```

## 7.3 Schema Definitions

### students (Sifat's Table)

| Column | Type | Constraints |
|--------|------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT |
| student_id | VARCHAR(255) | NOT NULL, UNIQUE |
| full_name | VARCHAR(255) | NOT NULL |
| email | VARCHAR(255) | NOT NULL, UNIQUE |
| phone | VARCHAR(20) | NOT NULL, UNIQUE |
| batch | VARCHAR(50) | NOT NULL |
| enrollment_date | DATE | NOT NULL |
| password | VARCHAR(255) | NOT NULL |
| department_id | BIGINT UNSIGNED | FK → departments.id, RESTRICT ON DELETE, CASCADE ON UPDATE |
| semester_id | BIGINT UNSIGNED | FK → semesters.id, RESTRICT ON DELETE, CASCADE ON UPDATE |
| created_at | TIMESTAMP | NULLABLE |
| updated_at | TIMESTAMP | NULLABLE |

**Indexes:** student_id, department_id, semester_id

### student_logins (Sifat's Table)

| Column | Type | Constraints |
|--------|------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT |
| student_id | BIGINT UNSIGNED | FK → students.id, CASCADE ON DELETE, CASCADE ON UPDATE |
| username | VARCHAR(255) | NOT NULL, UNIQUE |
| password | VARCHAR(255) | NOT NULL (hashed) |
| created_at | TIMESTAMP | NULLABLE |
| updated_at | TIMESTAMP | NULLABLE |

## 7.4 Key Design Decisions

| Decision | Rationale |
|----------|-----------|
| **Separate student_logins table** | Security - passwords stored separately from student data |
| **UNIQUE on student_id** | Each student has unique ID |
| **UNIQUE on email & phone** | Prevent duplicate contact info |
| **RESTRICT ON DELETE** | Can't delete department/semester with students |
| **CASCADE ON UPDATE** | If department ID changes, student records update automatically |
| **Hashed passwords** | bcrypt hashing for security (never store plain text) |
| **Session-based auth** | Simple, stateless authentication |

## 7.5 Seed Data

The DatabaseSeeder.php dynamically creates sample data:

### Students (4 records)

| ID | Student ID | Name | Email | Department | Semester |
|----|------------|------|-------|------------|----------|
| 1 | S-24001 | Sifat Mazib | sifat.mazib@uni.edu.bd | CSE | Spring 2025 |
| 2 | S-24002 | Tanvir Ahmed | tanvir.ahmed@uni.edu.bd | CSE | Spring 2025 |
| 3 | S-24003 | Samiha Rahman | samiha.rahman@uni.edu.bd | EEE | Summer 2025 |
| 4 | S-24004 | Nusrat Jahan | nusrat.jahan@uni.edu.bd | BBA | Fall 2025 |

### Student Logins (4 records)

| ID | Username | Password (hashed) |
|----|----------|-------------------|
| 1 | S-24001 | bcrypt(password) |
| 2 | S-24002 | bcrypt(password) |
| 3 | S-24003 | bcrypt(password) |
| 4 | S-24004 | bcrypt(password) |

## 7.6 Analytical Queries

```sql
-- Student information with department
SELECT s.student_id, s.full_name, d.department_name
FROM students s
INNER JOIN departments d ON s.department_id = d.id
WHERE s.student_id = '2023200000068';

-- Student GPA calculation query
SELECT 
    s.student_id,
    s.full_name,
    SUM(c.credit_hours) as total_credits,
    SUM(r.grade_point * c.credit_hours) / SUM(c.credit_hours) as gpa
FROM students s
INNER JOIN enrollments e ON s.id = e.student_id
INNER JOIN courses c ON e.course_id = c.id
INNER JOIN results r ON e.id = r.enrollment_id
GROUP BY s.id, s.student_id, s.full_name;

-- Students per department
SELECT d.department_name, COUNT(s.id) as student_count
FROM departments d
LEFT JOIN students s ON d.id = s.department_id
GROUP BY d.department_name;
```

## 7.7 How Sifat's Tables Connect to All Other Team Members' Tables

### My Tables → Emon's Tables:

| My Table | Emon's Table | Relationship |
|----------|--------------|--------------|
| students | departments | Many-to-One (FK: department_id) |
| students | semesters | Many-to-One (FK: semester_id) |
| courses (via enrollments) | departments | Many-to-One |

### My Tables → Nazmul's Tables:

| My Table | Nazmul's Table | Relationship |
|----------|----------------|---------------|
| students | teachers | Both belong to departments |

### My Tables → Oishy's Tables:

| My Table | Oishy's Table | Relationship |
|----------|---------------|--------------|
| students | enrollments | One-to-Many (one student can have many enrollments) |
| enrollments | results | One-to-One (each enrollment has one result) |

### My Tables → Mithila's Tables:

| My Table | Mithila's Table | Relationship |
|----------|-----------------|--------------|
| results | result_histories | One-to-Many (results can be archived) |

---

# 8. System Workflow

## 8.1 Sifat's Module in the System Context

The Student Module is the end-user interface. Other modules feed data that students can view:

```
                    ┌─────────────────┐
                    │   Emon's Module  │
                    │ (Departments,   │
                    │  Semesters,     │
                    │  Courses)       │
                    └────────┬────────┘
                             │
                             ▼
┌──────────────┐     ┌─────────────────┐     ┌─────────────────┐
│   Oishy's    │────►│   Sifat's       │◄────│   Mithila's     │
│   Module     │     │   Module        │     │   Module        │
│ (Enrollments,│     │ (Student        │     │ (Transcript     │
│  Results)    │     │  Dashboard)     │     │  Generation)    │
└──────────────┘     └─────────────────┘     └─────────────────┘
```

## 8.2 Student Login Flow

```
Student → GET /student/login
         │
         └─> POST /student/login (credentials)
               │
               ├─> Find StudentLogin by username
               ├─> Hash::check(password, stored_hash)
               ├─> Success:
               │     ├─> session(['student_id' => ..., 'student_name' => ...])
               │     └─> Redirect to /student/dashboard
               └─> Failure:
                     └─> Return with error
```

## 8.3 Dashboard Data Flow

```
GET /student/dashboard
     │
     ├─> session('student_id') → Get current student
     │
     ├─> Student::with(['department', 'semester'])
     │     └─> Student info with relationships
     │
     ├─> Enrollment::with(['course', 'semester', 'result'])
     │     └─> All enrollments with grades
     │
     ├─> calculateGpa(enrollments)
     │     └─> Loop through enrollments:
     │         - Get credit_hours from course
     │         - Get grade_point from result
     │         - GPA = Σ(grade_point × credits) / Σ(credits)
     │
     └─> Return view with all data
```

## 8.4 Data Flow from Other Modules

```
EMON (Foundation Data):
  departments ──► Used by students (FK)
  semesters ────► Used by students (FK)
  courses ─────► Used by enrollments (via Oishy)

NAZMUL (Teacher Data):
  teachers ─────► Assigned to courses
  teacher_logins ──► Teacher authentication

OISHY (Academic Data):
  enrollments ──► Links students to courses
  results ──────► Grades for each enrollment

SIFAT (Student Interface):
  students ────► View dashboard, profile
  student_logins ──► Authentication

MITHILA (Reporting):
  result_histories ──► Archived results
  transcripts ────► Generated from enrollments/results
```

---

# 9. Key Features Implemented

## 9.1 Authentication System

| Feature | Status |
|---------|--------|
| Login form with validation | ✅ |
| Secure password verification (bcrypt) | ✅ |
| Session management | ✅ |
| Logout with session cleanup | ✅ |
| Demo credentials display | ✅ |
| Error messages for invalid login | ✅ |

## 9.2 Dashboard Features

| Feature | Status |
|---------|--------|
| Display student profile info | ✅ |
| Show department and semester | ✅ |
| Display overall GPA | ✅ |
| List all semester results | ✅ |
| Show per-semester GPA | ✅ |
| Color-coded grade badges | ✅ |
| Transcript download links | ✅ |
| Search by course code | ✅ |
| Filter by semester | ✅ |
| Filter by grade | ✅ |
| Reset filters | ✅ |

## 9.3 Profile Management

| Feature | Status |
|---------|--------|
| View profile information | ✅ |
| Edit name, email, phone | ✅ |
| Change password with verification | ✅ |
| Password confirmation check | ✅ |
| Success/error messages | ✅ |
| Read-only fields (ID, dept, semester) | ✅ |

## 9.4 Data Integrity & Security

| Feature | Status |
|---------|--------|
| Laravel validation rules | ✅ |
| Unique constraints on email/phone/student_id | ✅ |
| Passwords hashed with bcrypt | ✅ |
| Foreign key constraints | ✅ |
| Session-based authentication | ✅ |
| CSRF protection (Laravel built-in) | ✅ |
| SQL injection prevention (Eloquent) | ✅ |

## 9.5 Project Coordination

As **Group Leader**:
- Coordinated task distribution among team members
- Integrated all modules into the main application
- Ensured consistent code structure and naming conventions
- Managed database migrations and foreign key relationships

---

# 10. Code Location Summary

```
Backend (Controllers):
  app/Modules/Sifat/Controllers/StudentAuthController.php
  app/Modules/Sifat/Controllers/StudentDashboardController.php

Frontend (Views):
  resources/views/sifat/student-login.blade.php
  resources/views/sifat/dashboard.blade.php
  resources/views/sifat/profile.blade.php

Database:
  app/Modules/Sifat/Database/students_tables.sql (Reference)
  app/Modules/Sifat/Queries/student_queries.sql (Reference)
  database/migrations/2026_01_01_000003_create_students_table.php
  database/migrations/2026_01_01_000009_create_student_logins_table.php
  database/seeders/DatabaseSeeder.php (Dynamic data)

Routes (student.*):
  student.login (GET)
  student.login.submit (POST)
  student.logout (POST)
  student.dashboard (GET)
  student.profile (GET)
  student.profile.update (PUT)
  student.password.update (PUT)

Shared Models Used:
  app/Models/Student.php
  app/Models/StudentLogin.php
  app/Models/Department.php
  app/Models/Semester.php
  app/Models/Enrollment.php
  app/Models/Course.php
  app/Models/Result.php
```

---

# Appendix: Quick Reference

## Validation Rules Summary

| Controller | Field | Rules |
|------------|-------|-------|
| StudentAuth | `username` | required |
| StudentAuth | `password` | required |
| StudentDashboard | `full_name` | required, string |
| StudentDashboard | `email` | required, email, unique:students,email,{id} |
| StudentDashboard | `phone` | required, string, unique:students,phone,{id} |
| StudentDashboard | `current_password` | required |
| StudentDashboard | `new_password` | required, min:6, confirmed |

## Route Names

| Prefix | Routes |
|--------|--------|
| `student.*` | login, login.submit, logout, dashboard, profile, profile.update, password.update |

## Middleware Protection

Student routes are protected by **StudentAuth middleware**, ensuring only logged-in students can access dashboard, profile, and password change features.

## How My Tables Connect to Other Team Members

| My Table | Connects To | Team Member | Connection Type |
|----------|-------------|-------------|-----------------|
| students | departments | Emon | Foreign Key (department_id) |
| students | semesters | Emon | Foreign Key (semester_id) |
| students | enrollments | Oishy | Via enrollments table (student_id FK) |
| students | results | Oishy | Via enrollments → results chain |
| students | courses | Emon/Oishy | Via enrollments → courses chain |
| student_logins | students | Sifat | Foreign Key (student_id) with CASCADE |

---

**Author:** Sifat Ibne Mazib (Group Leader)
**Student ID:** 2023200000068
**Branch:** `sifat`
**Commit:** `d0bcb8541ca62018ac7c4723cdbe4c440f399258`
**Last Updated:** May 2026