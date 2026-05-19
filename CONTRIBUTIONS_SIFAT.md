# SIFAT IBNE MAZIB — Student Module

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
10. [Database Relationships - Detailed](#10-database-relationships---detailed)
11. [Code Location Summary](#11-code-location-summary)

---

# 1. Role & Responsibilities

As the **Group Leader** of this project, Sifat was responsible for both technical implementation and project coordination. The Student Module provides the main interface for students to view their academic performance.

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
    if ($request->filled('course_code')) {
        $query->whereHas('course', function ($builder) use ($request) {
            $builder->where('course_code', 'like', '%' . $request->course_code . '%');
        });
    }

    if ($request->filled('semester_id')) {
        $query->where('semester_id', $request->semester_id);
    }

    if ($request->filled('letter_grade')) {
        $query->whereHas('result', function ($builder) use ($request) {
            $builder->where('letter_grade', $request->letter_grade);
        });
    }

    return $query;
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

## 6.2 student-login.blade.php

```
┌─────────────────────────────────────────────┐
│              STUDENT LOGIN                   │
│  ┌─────────────────────────────────────────┐│
│  │         👤                               ││
│  │    Student Login                        ││
│  │  Access your dashboard and transcript  ││
│  ├─────────────────────────────────────────┤│
│  │  Username:  [S-24001          ] 👤      ││
│  │  Password:  [************    ] 🔒       ││
│  │  [Login]                                 ││
│  │  Demo: username S-24001, password       ││
│  └─────────────────────────────────────────┘│
└─────────────────────────────────────────────┘
```

## 6.3 dashboard.blade.php

```
┌─────────────────────────────────────────────┐
│  Profile Card              │  Semester Results│
│  ───────────────────────── │  ─────────────────│
│  👤 Sifat Mazib           │  Sp 2025 │ 3.75 │
│  S-24001                  │  Su 2025 │ 3.50 │
│  Dept: CSE                │  Fa 2025 │ 3.25 │
│  Semester: Spring 2025    │                  │
│  GPA: 3.75                │  [Search Results]│
│  [Edit Profile] [Logout] │  Course│Grade│Pt │
└─────────────────────────────────────────────┘
```

## 6.4 profile.blade.php

```
┌─────────────────────────────────────────────┐
│  UPDATE PROFILE            CHANGE PASSWORD  │
│  ─────────────────────────────────────────  │
│  Student ID: S-24001 [disabled]             │
│  Full Name:  [Sifat Mazib        ]          │
│  Email:      [sifat@uni.edu.bd  ]          │
│  Phone:      [01720000001        ]          │
│  Department: CSE [disabled]                 │
│  Semester:   Spring 2025 [disabled]        │
│  [Save Changes]                            │
│                                             │
│  Current Password: [************]          │
│  New Password:    [************]          │
│  Confirm:         [************]          │
│  [Change Password]                         │
└─────────────────────────────────────────────┘
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
                  │ department_id FK│──────────┐
                  │ semester_id FK  │          │
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
│  │ letter_grade      │    └───────────────────┘                        │
│  │ grade_point       │                                                 │
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
| **Hashed passwords** | bcrypt hashing for security |

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
               ├─> Success → Session created → Redirect to dashboard
               └─> Failure → Return with error
```

## 8.3 Dashboard Data Flow

```
GET /student/dashboard
     │
     ├─> session('student_id') → Get current student
     ├─> Student::with(['department', 'semester'])
     ├─> Enrollment::with(['course', 'semester', 'result'])
     ├─> calculateGpa(enrollments)
     └─> Return view with all data
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
| Error messages for invalid login | ✅ |

## 9.2 Dashboard Features

| Feature | Status |
|---------|--------|
| Display student profile info | ✅ |
| Show department and semester | ✅ |
| Display overall GPA | ✅ |
| List all semester results | ✅ |
| Color-coded grade badges | ✅ |
| Search/filter by course, semester, grade | ✅ |

## 9.3 Profile Management

| Feature | Status |
|---------|--------|
| View profile information | ✅ |
| Edit name, email, phone | ✅ |
| Change password with verification | ✅ |
| Success/error messages | ✅ |

## 9.4 Project Coordination

As **Group Leader**:
- Coordinated task distribution among team members
- Integrated all modules into the main application
- Ensured consistent code structure and naming conventions

---

# 10. Database Relationships - Detailed

## 10.1 My Tables Overview

I designed two main database tables:

### students table
```
students table
│
├── id (Primary Key)
├── student_id (UNIQUE) - Like "S-24001"
├── full_name
├── email (UNIQUE)
├── phone (UNIQUE)
├── batch
├── enrollment_date
├── password
├── department_id (FK) ──► departments(id)
├── semester_id (FK) ────► semesters(id)
└── timestamps
```

### student_logins table
```
student_logins table
│
├── id (Primary Key)
├── student_id (FK) ──────► students(id)
│         │               ON DELETE CASCADE
├── username (UNIQUE)
├── password (bcrypt)
└── timestamps
```

**Why separate?**
- Security: Passwords isolated from personal data
- CASCADE: If student deleted, login auto-deleted

---

## 10.2 Detailed Table-to-Table Relationships

### students → departments (Many-to-One)

```
students                         departments
┌─────────────────┐            ┌─────────────────┐
│ id: 1            │            │ id: 1           │
│ student_id: S-01│            │ department_name │
│ full_name: Sifat│──FK───────►│ : CSE           │
│ department_id: 1 │            └─────────────────┘
└─────────────────┘
```

**SQL Query:**
```sql
SELECT s.student_id, s.full_name, d.department_name
FROM students s
INNER JOIN departments d ON s.department_id = d.id
WHERE s.student_id = 'S-24001';

-- Result: S-24001 | Sifat Ibne Mazib | Computer Science & Engineering
```

- **FK:** department_id → departments.id
- **Constraint:** RESTRICT ON DELETE (cannot delete department if students exist)
- **Constraint:** CASCADE ON UPDATE

### students → semesters (Many-to-One)

```
students                         semesters
┌─────────────────┐            ┌─────────────────┐
│ id: 1            │            │ id: 1           │
│ student_id: S-01│            │ semester_name   │
│ full_name: Sifat│──FK───────►│ : Spring 2025   │
│ semester_id: 1   │            └─────────────────┘
└─────────────────┘
```

- **FK:** semester_id → semesters.id

### student_logins → students (One-to-One)

```
student_logins                   students
┌─────────────────┐            ┌─────────────────┐
│ id: 1           │            │ id: 1           │
│ student_id: 1   │◄───FK──────│ student_id: S-01│
│ username: S-24001│           │ full_name: Sifat│
│ password: $2y... │            └─────────────────┘
└─────────────────┘
```

- **FK:** student_id → students.id
- **ON DELETE CASCADE:** If student deleted, login deleted
- **ON UPDATE CASCADE:** If student id changes, login updates

### students → enrollments → results (Chain)

```
students              enrollments                 results
┌─────────┐          ┌─────────────┐              ┌──────────┐
│ id: 1    │◄──FK────│ student_id  │◄───FK───────│enrollment│
│ S-24001  │          │ = 1         │              │ _id: 1   │
└─────────┘          │ course_id   │              │ A        │
                     │ semester_id │              │ 4.00     │
                     └─────────────┘              └──────────┘
```

**SQL - Get all results for a student:**
```sql
SELECT 
    s.student_id,
    c.course_code,
    c.course_title,
    c.credit_hours,
    r.letter_grade,
    r.grade_point
FROM students s
INNER JOIN enrollments e ON s.id = e.student_id
INNER JOIN courses c ON e.course_id = c.id
INNER JOIN results r ON e.id = r.enrollment_id
WHERE s.student_id = 'S-24001';
```

**Relationship Chain:**
```
students (id) 
    │ hasMany (one student → many enrollments)
    ▼
enrollments (student_id)
    │ hasOne (one enrollment → one result)
    ▼
results (enrollment_id)
```

---

## 10.3 How My Tables Connect to All Team Members

### My Tables → Emon's Tables (Foundation)

```
My students table
    │
    ├──► department_id ──► Emon's departments table
    │
    └──► semester_id ──► Emon's semesters table
              │
              └──► enrollments ──► Emon's courses table
```

- Students need departments to know which department they belong to
- Students need semesters to know which semester they're in
- Enrollments (through Oishy) need courses to know what courses students take

### My Tables → Nazmul's Tables

```
Nazmul's teachers ──► Emon's departments (via department_id)
                          │
                          ▼
                     My students (both belong to departments)
```

- Both teachers and students belong to the same department

### My Tables → Oishy's Tables

```
My students ──► Oishy's enrollments ──► Oishy's results
    │                    │
    │                    └──► grade/marks for each course
    │
    └──► academic records
```

- Students are enrolled in courses by Oishy
- Each enrollment gets a result (grade) from Oishy
- My dashboard displays these results to students

### My Tables → Mithila's Tables

```
Oishy's results ──► Mithila's result_histories
                         │
                         ▼
                   My students' archived results
```

- When results are updated, old results go to result_histories

---

## 10.4 Complete Data Flow Example - Student Dashboard

When a student logs into their dashboard:

```
STEP 1: Authenticate
student_logins ──► students (via student_id)
     │
     ▼
STEP 2: Get Profile
students ──► departments (via department_id)
students ──► semesters (via semester_id)
     │
     ▼
STEP 3: Get Enrollments & Results
students ──► enrollments (via student_id)
     │
     ├──► courses (via course_id) ──► departments (via department_id)
     ├──► semesters (via semester_id)
     └──► results (via enrollment_id)
     │
     ▼
STEP 4: Calculate GPA
For each enrollment:
  - Get credit_hours from course
  - Get grade_point from result
  - GPA = Σ(grade_point × credits) / Σ(credits)
```

---

## 10.5 All Foreign Key Relationships Summary

| My Table | Foreign Key | References | Table Owner | Relationship Type |
|----------|-------------|-------------|--------------|-------------------|
| students | department_id | departments(id) | Emon | Many-to-One |
| students | semester_id | semesters(id) | Emon | Many-to-One |
| student_logins | student_id | students(id) | Sifat (me) | One-to-One |
| enrollments | student_id | students(id) | Oishy | One-to-Many |
| enrollments | course_id | courses(id) | Emon | Many-to-One |
| enrollments | semester_id | semesters(id) | Emon | Many-to-One |
| results | enrollment_id | enrollments(id) | Oishy | One-to-One |

---

## 10.6 Database Architecture - How the System Actually Works

### The Three-Layer System

```
LAYER 1: Laravel Migrations (PHP)
──────────────────────────────────
Creates EMPTY tables automatically:
- students table (no data)
- student_logins table (no data)
- enrollments table (no data)
- results table (no data)

Command: php artisan migrate


LAYER 2: Database Seeder (PHP - Dynamic!)
──────────────────────────────────────────
Populates tables with sample data:

Student::create([
    'student_id' => 'S-24001',
    'full_name' => 'Sifat Mazib',
    'department_id' => 1,  // Links to Emon's department
    'semester_id' => 1,    // Links to Emon's semester
]);

Command: php artisan db:seed


LAYER 3: Eloquent ORM (PHP - Dynamic Queries!)
───────────────────────────────────────────────
Fetch data without writing SQL:

$student = Student::with(['department', 'semester'])
    ->find($studentId);

$enrollments = Enrollment::with(['course', 'result'])
    ->where('student_id', $studentId)
    ->get();
```

### Example Queries in My Code

```php
// From StudentDashboardController.php

// Get student with department and semester
$student = Student::with(['department', 'semester'])
    ->findOrFail($session('student_id'));

// Get all enrollments with course, semester, result
$enrollments = Enrollment::with(['course', 'semester', 'result'])
    ->where('student_id', $studentId)
    ->get();

// Calculate GPA
foreach ($enrollments as $e) {
    $totalCredits += $e->course->credit_hours;
    $totalPoints += $e->result->grade_point * $e->course->credit_hours;
}
$gpa = $totalPoints / $totalCredits;
```

---

## 10.7 Key Points for Teacher Presentation

### "How does your database connect to other modules?"

**Answer:**
"My two tables (students and student_logins) connect to the entire system through foreign keys:

1. **students → departments** (Emon): Every student belongs to one department
2. **students → semesters** (Emon): Every student has a current semester
3. **students → enrollments** (Oishy): One student can enroll in many courses
4. **enrollments → results** (Oishy): Each enrollment has one grade
5. **enrollments → courses** (Emon): Each enrollment links to a course

The students table is the central table - all other academic data connects through it."

### "What makes your database properly designed?"

**Answer:**
1. **Normalization** - No duplicate data
2. **Foreign Keys** - All relationships are defined
3. **Unique Constraints** - No duplicate student IDs, emails, phones
4. **Security** - Passwords are hashed and in a separate table
5. **Referential Integrity** - Cannot delete departments with students

---

# 11. Code Location Summary

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
  student.login, student.login.submit, student.logout
  student.dashboard, student.profile
  student.profile.update, student.password.update

Shared Models:
  Student, StudentLogin, Department, Semester, Enrollment, Course, Result
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

---

**Author:** Sifat Ibne Mazib (Group Leader)
**Student ID:** 2023200000068
**Branch:** `sifat`
**Commit:** `d0bcb8541ca62018ac7c4723cdbe4c440f399258`
**Last Updated:** May 2026