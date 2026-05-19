# Contribution Details - Sifat Ibne Mazib

## Project: Student Result Management System (SRMS)
**Student ID:** 2023200000068
**Role:** Group Leader & Backend/Frontend Developer

---

# Database Relationships - How My Tables Connect to All Other Tables

## 1. My Tables Overview

I designed two main database tables for the Student Module:

### Table 1: students
This is the primary table storing all student information.

```
students table
│
├── id (Primary Key) - Auto increment
├── student_id (UNIQUE) - Student's unique ID like "S-24001"
├── full_name - Student's full name
├── email (UNIQUE) - Student's email address
├── phone (UNIQUE) - Contact number
├── batch - Batch year like "2024"
├── enrollment_date - When the student enrolled
├── password - Hashed password for security
├── department_id (Foreign Key) ──────► departments(id)
├── semester_id (Foreign Key) ─────────► semesters(id)
├── created_at
└── updated_at
```

### Table 2: student_logins
This table handles student authentication, kept separate for security.

```
student_logins table
│
├── id (Primary Key)
├── student_id (Foreign Key) ──────────► students(id)
│         │                            ON DELETE CASCADE
│         │                            ON UPDATE CASCADE
├── username (UNIQUE) - Same as student_id
├── password (bcrypt hashed)
├── created_at
└── updated_at
```

**Why separate student_logins table?**
- Security: If student account is deleted, login is automatically deleted
- Isolation: Passwords are separated from personal information
- No accidental exposure of password hashes

---

## 2. Complete Database Relationship Diagram

This diagram shows how ALL tables in the project connect together, including my tables:

```
                                    ┌──────────────────────────────────┐
                                    │         EMON'S TABLES            │
                                    │   (Departments, Semesters,     │
                                    │         Courses)                │
                                    └──────────────┬───────────────────┘
                                                   │
                    ┌──────────────────────────────┼──────────────────────┐
                    │                              │                      │
                    ▼                              ▼                      ▼
        ┌───────────────────┐        ┌───────────────────┐    ┌───────────────────┐
        │    departments    │        │    semesters      │    │     courses       │
        ├───────────────────┤        ├───────────────────┤    ├───────────────────┤
        │ id (PK) ◄─────────┼────────│ id (PK) ◄─────────┼────│ id (PK)           │
        │ department_name   │        │ semester_name     │    │ course_code       │
        └─────────┬─────────┘        └─────────┬─────────┘    │ course_title      │
                  │                            │               │ credit_hours      │
                  │                            │               │ department_id FK──┼──►
                  │                            │               │ teacher_id FK─────┼──►
                  │                            │               └─────────┬─────────┘
                  │                            │                         │
                  │                            │                         │
                  ▼                            ▼                         ▼
        ┌───────────────────┐        ┌───────────────────┐    ┌───────────────────┐
        │    teachers       │        │    students       │    │   SIFAT'S TABLES  │
        │  (Nazmul's)       │        │   (MY TABLE)      │    │                    │
        ├───────────────────┤        ├───────────────────┤    │  ┌─────────────┐  │
        │ id (PK)           │◄───────│ id (PK)           │    │  │ students   │  │
        │ teacher_id        │        │ student_id (UK)  │    │  ├─────────────┤  │
        │ full_name         │        │ full_name        │    │  │ id (PK)    │  │
        │ department_id FK──┼────────│ email (UK)       │    │  │ student_id │  │
        │ ...               │        │ phone (UK)       │    │  │ full_name  │  │
        └───────────────────┘        │ department_id FK─┼────┤  │ email      │  │
                                      │ semester_id FK───┼────┤  │ phone      │  │
                                      └────────┬─────────┘    │  │ batch      │  │
                                               │              │  │ dept_id FK─┼───►departments
                                               │              │  │ sem_id FK──┼───►semesters
                                               │              │  └───────────┘  │
                                               │              │                │
                                               │              │  ┌─────────────┐  │
                                               │              │  │student_logins│ │
                                               │              │  ├─────────────┤  │
                                               │              │  │ id (PK)     │  │
                                               │              │  │student_id FK┴──►students
                                               │              │  │ username    │  │
                                               │              │  │ password    │  │
                                               │              │  └─────────────┘  │
                                               │              └────────────────────┘
                                               │
                                               ▼
                                ┌────────────────────────────────┐
                                │       OISHY'S TABLES          │
                                │   (Enrollments, Results)       │
                                └──────────────┬─────────────────┘
                                               │
                    ┌───────────────────────────┼───────────────────────────┐
                    │                           │                           │
                    ▼                           ▼                           ▼
        ┌───────────────────┐        ┌───────────────────┐    ┌───────────────────┐
        │   enrollments     │        │    results        │    │ result_histories  │
        ├───────────────────┤        ├───────────────────┤    │   (Mithila's)     │
        │ id (PK)           │◄───────│ enrollment_id(FK) │    ├───────────────────┤
        │ student_id FK─────┼────────│ id (PK)           │    │ id (PK)           │
        │ course_id FK──────┼───────►│ mid_marks         │    │ old_enrollment_id │
        │ semester_id FK─────┼────────│ final_marks       │    │ old_result_id     │
        │ enrollment_date   │        │ assignment_marks  │    │ ...               │
        └─────────┬─────────┘        │ attendance_marks  │    └───────────────────┘
                  │                  │ total_marks       │
                  │                  │ letter_grade      │
                  │                  │ grade_point       │
                  │                  │ gpa               │
                  │                  └───────────────────┘
                  │
                  └──────────────────► NAZMUL'S TABLES (teacher_logins)
                                     (linked via teachers → courses)
```

---

## 3. Detailed Table-by-Table Relationships

### 3.1 My students table → Emon's tables

#### students → departments (Many-to-One)

```
students                         departments
┌─────────────────┐            ┌─────────────────┐
│ id: 1            │            │ id: 1           │
│ student_id: S-01│            │ department_name │
│ full_name: Sifat│──FK───────►│ : CSE           │
│ department_id: 1│            └─────────────────┘
└─────────────────┘
```

**SQL Query:**
```sql
SELECT s.student_id, s.full_name, d.department_name
FROM students s
INNER JOIN departments d ON s.department_id = d.id
WHERE s.student_id = 'S-24001';

-- Result:
-- S-24001 | Sifat Ibne Mazib | Computer Science & Engineering
```

**Explanation:** Each student belongs to ONE department. The department_id in students table points to the id in departments table.

- **Foreign Key:** `department_id` in students references `id` in departments
- **Constraint:** RESTRICT ON DELETE (cannot delete department if students exist)
- **Constraint:** CASCADE ON UPDATE (if department id changes, student records update automatically)

#### students → semesters (Many-to-One)

```
students                         semesters
┌─────────────────┐            ┌─────────────────┐
│ id: 1            │            │ id: 1           │
│ student_id: S-01│            │ semester_name   │
│ full_name: Sifat│──FK───────►│ : Spring 2025   │
│ semester_id: 1   │            └─────────────────┘
└─────────────────┘
```

**SQL Query:**
```sql
SELECT s.full_name, s.student_id, sem.semester_name
FROM students s
INNER JOIN semesters sem ON s.semester_id = sem.id;
```

**Explanation:** Each student is assigned to ONE current semester (the semester they are currently studying in).

- **Foreign Key:** `semester_id` in students references `id` in semesters

---

### 3.2 My student_logins table → My students table

#### student_logins → students (One-to-One)

```
student_logins                   students
┌─────────────────┐            ┌─────────────────┐
│ id: 1           │            │ id: 1           │
│ student_id: 1   │◄───FK──────│ student_id: S-01│
│ username: S-24001│           │ full_name: Sifat│
│ password: $2y... │            └─────────────────┘
└─────────────────┘
```

**SQL Query:**
```sql
SELECT sl.username, s.full_name, s.email
FROM student_logins sl
INNER JOIN students s ON sl.student_id = s.id
WHERE sl.username = 'S-24001';
```

**Explanation:** Each student has exactly ONE login credential. The student_id in student_logins links to the id in students.

- **Foreign Key:** `student_id` in student_logins references `id` in students
- **ON DELETE CASCADE:** If student is deleted, login is automatically deleted
- **ON UPDATE CASCADE:** If student id changes, login updates automatically

---

### 3.3 My tables → Oishy's tables (via relationships)

#### students → enrollments → results (One-to-Many-to-One)

```
students              enrollments                 results
┌─────────┐          ┌─────────────┐              ┌──────────┐
│ id: 1    │◄──FK────│ student_id  │◄───FK───────│enrollment│
│ S-24001  │          │ = 1         │              │ _id: 1   │
└─────────┘          │ course_id   │              │ A        │
                     │ semester_id │              │ 4.00     │
                     └─────────────┘              └──────────┘
```

**SQL Query - Get all results for a student:**
```sql
SELECT 
    s.student_id,
    s.full_name,
    c.course_code,
    c.course_title,
    c.credit_hours,
    r.letter_grade,
    r.grade_point
FROM students s
INNER JOIN enrollments e ON s.id = e.student_id
INNER JOIN courses c ON e.course_id = c.id
INNER JOIN results r ON e.id = r.enrollment_id
WHERE s.student_id = 'S-24001'
ORDER BY c.course_code;
```

**Explanation:**
1. One student can have MANY enrollments (one per course per semester)
2. Each enrollment has ONE result (the grade for that course)
3. The chain is: students → enrollments → results

**Relationship Chain:**
```
students (id) 
    │
    │ hasMany (one student → many enrollments)
    ▼
enrollments (student_id)
    │
    │ hasOne (one enrollment → one result)
    ▼
results (enrollment_id)
```

---

### 3.4 My tables → Emon's courses table (indirectly)

#### enrollments → courses (Many-to-One)

```
enrollments                 courses (Emon's table)
┌─────────────┐            ┌─────────────────┐
│ student_id  │            │ id: 1           │
│ course_id: 1 │──FK──────►│ course_code:    │
│ semester_id │            │ CSE101          │
└─────────────┘            │ course_title:   │
                           │ Programming      │
                           │ credit_hours: 3  │
                           └─────────────────┘
```

**SQL Query - Get student's enrolled courses:**
```sql
SELECT 
    s.full_name,
    c.course_code,
    c.course_title,
    c.credit_hours
FROM students s
INNER JOIN enrollments e ON s.id = e.student_id
INNER JOIN courses c ON e.course_id = c.id
WHERE s.student_id = 'S-24001';
```

---

### 3.5 Complete Data Flow Example - Student Dashboard

When a student logs into their dashboard, this is the data flow through relationships:

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

## 4. All Foreign Key Relationships Summary

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

## 5. How My Tables Connect to Each Team Member

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

**Connection:**
- My students need departments to know which department they belong to
- My students need semesters to know which semester they're in
- My enrollments (through Oishy) need courses to know what courses students take

### My Tables → Nazmul's Tables

```
Nazmul's teachers ──► Emon's departments (via department_id)
                          │
                          ▼
                     My students (both belong to departments)
```

**Connection:**
- Both teachers and students belong to the same department
- Teachers are assigned to courses (which students enroll in)

### My Tables → Oishy's Tables

```
My students ──► Oishy's enrollments ──► Oishy's results
    │                    │
    │                    └──► grade/marks for each course
    │
    └──► academic records
```

**Connection:**
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

**Connection:**
- When results are updated, old results go to result_histories
- Mithila's transcripts can show current and historical results

---

## 6. Database Architecture - How the System Actually Works

### The Three-Layer System

Many students wonder: "The SQL file has static values, so how does the system work dynamically?"

**Answer:**

```
LAYER 1: Laravel Migrations (PHP)
─────────────────────────────
Creates EMPTY tables automatically:
- students table (no data)
- student_logins table (no data)
- enrollments table (no data)
- results table (no data)
etc.

Command: php artisan migrate


LAYER 2: Database Seeder (PHP - Dynamic!)
─────────────────────────────
Populates tables with sample data:

Student::create([
    'student_id' => 'S-24001',
    'full_name' => 'Sifat Mazib',
    'department_id' => 1,  // Links to Emon's department
    'semester_id' => 1,    // Links to Emon's semester
    ...
]);

Command: php artisan db:seed


LAYER 3: Eloquent ORM (PHP - Dynamic Queries!)
─────────────────────────────
Fetch data without writing SQL:

$student = Student::with(['department', 'semester'])
    ->find($studentId);

$enrollments = Enrollment::with(['course', 'result'])
    ->where('student_id', $studentId)
    ->get();

This is NOT raw SQL - it's Laravel's Eloquent!
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

// Filter by course code
$enrollments->whereHas('course', function($q) use($request) {
    $q->where('course_code', 'like', '%' . $request->course_code . '%');
});

// Calculate GPA
foreach ($enrollments as $e) {
    $totalCredits += $e->course->credit_hours;
    $totalPoints += $e->result->grade_point * $e->course->credit_hours;
}
$gpa = $totalPoints / $totalCredits;
```

**Benefits of Eloquent ORM:**
- No SQL injection (automatically escaped)
- Easy relationships (belongsTo, hasMany, hasOne)
- Readable and maintainable code
- Works across different database systems (MySQL, PostgreSQL, etc.)

---

## 7. Key Points for Teacher Presentation

### Question: "How does your database connect to other modules?"

**Answer:**
"My two tables (students and student_logins) connect to the entire system through foreign keys:

1. **students → departments** (Emon): Every student belongs to one department
2. **students → semesters** (Emon): Every student has a current semester
3. **students → enrollments** (Oishy): One student can enroll in many courses
4. **enrollments → results** (Oishy): Each enrollment has one grade
5. **enrollments → courses** (Emon): Each enrollment links to a course

The students table is the central table - all other academic data connects through it."

### Question: "What makes your database properly designed?"

**Answer:**
1. **Normalization** - No duplicate data
2. **Foreign Keys** - All relationships are defined
3. **Unique Constraints** - No duplicate student IDs, emails, phones
4. **Security** - Passwords are hashed and in a separate table
5. **Referential Integrity** - Cannot delete departments with students

---

## Summary

- **My Tables:** students, student_logins
- **Direct Connections:** departments, semesters (via FK)
- **Indirect Connections:** courses, teachers, enrollments, results
- **All Team Members Connected:** Emon → Nazmul → Oishy → Mithila → Sifat

This is how the entire Student Result Management System database is connected through relationships!

---

*Generated for academic submission*
*Student Result Management System v2*
*Author: Sifat Ibne Mazib*