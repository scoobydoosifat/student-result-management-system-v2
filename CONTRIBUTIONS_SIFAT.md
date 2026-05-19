# Contribution Details - Sifat Ibne Mazib

## Project: Student Result Management System (SRMS)
**Student ID:** 2023200000068
**Role:** Group Leader & Backend/Frontend Developer

---

## Summary of Contributions

As the group leader of this project, I have contributed to the database design, backend logic, and frontend development for the Student Module. My work spans from designing database tables to implementing complete authentication and dashboard functionality.

---

## 1. Database Design & Implementation

### Tables Created:
- **`students`** - Main student information table
  - Fields: student_id, full_name, email, phone, batch, enrollment_date, department_id, semester_id
  - Indexes on student_id, department, semester for performance
  - Foreign key constraints for data integrity

- **`student_logins`** - Student authentication credentials
  - Fields: student_id (FK), username (unique), password (hashed)
  - Linked to students table with CASCADE delete

### Database Features:
- Created seed data with sample students across different departments
- Pre-populated departments (CSE, EEE, BBA, etc.)
- Pre-populated semesters (Spring 2025, Summer 2025, Fall 2025)
- SQL scripts with INSERT, UPDATE, DELETE operations for testing

**File:** `app/Modules/Sifat/Database/students_tables.sql`

---

## 2. Backend Development (PHP/Laravel)

### Controllers Created:

#### StudentAuthController.php
- `showLoginForm()` - Display student login page
- `login()` - Handle student authentication with validation
- `logout()` - Clear session and redirect to login

#### StudentDashboardController.php
- `index()` - Main dashboard with enrollment data, GPA calculation
- `profile()` - View student profile with department/semester info
- `updateProfile()` - Update student personal information
- `changePassword()` - Allow students to change their password
- `applyFilters()` - Filter results by course code, semester, grade
- `buildSemesterStats()` - Group enrollments by semester with GPA
- `calculateGpa()` - Calculate GPA using credit hours and grade points

**Key Features:**
- Session-based authentication
- Hashing passwords using Laravel's Hash facade
- Form validation with error messages
- Dynamic GPA calculation based on grades and credit hours

---

## 3. Frontend Development (Blade Templates)

### Views Created:

#### student-login.blade.php
- Clean, modern login form with icons
- Input validation feedback
- Demo credentials display for testing

#### dashboard.blade.php
- Student profile card with avatar
- Overall GPA display with badge
- Semester-wise results table with GPA
- Download transcript buttons per semester
- Advanced search/filter functionality (by course, semester, grade)
- Color-coded grade badges (A, B, C, D, F)
- Logout button with POST protection

#### profile.blade.php
- Edit profile form (name, email, phone)
- Change password form with confirmation
- Department and semester display (read-only)
- Success/error message handling

**UI Features:**
- Responsive design with Bootstrap 5
- Gradient profile headers
- Interactive search filters
- Form validation with error messages
- Logout functionality

---

## 4. SQL Queries

### Student Queries Created:
- Student information retrieval with department join
- Student login verification queries

**File:** `app/Modules/Sifat/Queries/student_queries.sql`

---

## 5. Technical Stack Used

- **Backend:** PHP 8.x, Laravel 10.x
- **Frontend:** HTML5, Bootstrap 5, Blade Templates
- **Database:** MySQL
- **Authentication:** Session-based with Hash::check()
- **Validation:** Laravel Form Request validation

---

## 6. Project Coordination & Integration

As the **Group Leader**, I coordinated the entire project and integrated all team members' modules together:
- Organized task distribution among team members
- Ensured consistent code structure and naming conventions across all modules
- Integrated all module files (routes, controllers, views) into the main application
- Managed database migrations and ensured foreign key relationships work across modules
- Reviewed and merged code from different team members
- Handled overall project structure and module organization

---

## 7. Files Added to Project

| File Path | Description |
|-----------|-------------|
| `app/Modules/Sifat/Controllers/StudentAuthController.php` | Authentication controller |
| `app/Modules/Sifat/Controllers/StudentDashboardController.php` | Dashboard & profile controller |
| `app/Modules/Sifat/Database/students_tables.sql` | Database schema & seed data |
| `app/Modules/Sifat/Queries/student_queries.sql` | SQL query examples |
| `app/Modules/Sifat/Documentation/README.md` | Module documentation |
| `resources/views/sifat/student-login.blade.php` | Login page |
| `resources/views/sifat/dashboard.blade.php` | Dashboard view |
| `resources/views/sifat/profile.blade.php` | Profile page |

---

## 8. Key Functionalities Implemented

1. **Student Login System** - Secure authentication with username/password
2. **Dashboard Display** - Shows student info, department, semester, GPA
3. **Semester Results** - View grades per semester with individual GPA
4. **Result Filtering** - Search by course code, semester, or grade
5. **Transcript Download** - Per-semester transcript generation links
6. **Profile Management** - Update name, email, phone
7. **Password Change** - Secure password update with verification

---

## Contribution Summary

- **Database:** 2 tables (students, student_logins) with full schema
- **Backend:** 2 controllers, 8+ methods, GPA calculation logic
- **Frontend:** 3 complete views with modern UI/UX
- **Total Files:** 8 new files created
- **Leadership:** Coordinated whole project and integrated all modules

This module provides a complete student portal where students can log in, view their academic performance, check semester-wise GPA, search their results, update their profile, and manage their password securely.

---

## 9. Database Relationships - How My Tables Connect to Other Tables

### My Tables: students & student_logins

These are the tables I designed that form the foundation of the student data in the system.

#### students table - Relationships with Other Tables

```
students table (My Primary Table)
├── id (PK) - Primary Key
├── student_id (UNIQUE) - Unique student identifier
├── full_name, email, phone, batch, enrollment_date
├── department_id (FK) ────────────────► departments (id)
├── semester_id (FK) ───────────────────► semesters (id)
└── created_at, updated_at
```

**Relationships:**

| From | To | Type | Description |
|------|-----|------|-------------|
| students | departments | Many-to-One | Each student belongs to ONE department |
| students | semesters | Many-to-One | Each student belongs to ONE current semester |
| students | enrollments | One-to-Many | One student can have MANY course enrollments |
| students | student_logins | One-to-One | One student has ONE login credential |

#### student_logins table - Security Table

```
student_logins table (Authentication)
├── id (PK)
├── student_id (FK) ──────────────────► students (id)
│         │                            ON DELETE CASCADE
│         │                            ON UPDATE CASCADE
├── username (UNIQUE)
├── password (bcrypt hashed)
└── created_at, updated_at
```

**Why separate table?**
- Security: Passwords are isolated from main student data
- If student is deleted, login is automatically deleted (CASCADE)
- Prevents accidental exposure of passwords

### How students connects to ALL other tables in the system:

```
                        ┌─────────────┐
                        │ departments │ ◄── Emon's Module
                        └──────┬──────┘
                               │ (FK)
                               ▼
┌──────────────┐     ┌─────────────────┐     ┌─────────────┐
│  semesters   │────►│    students     │◄────│  teachers   │
│ (Emon's)     │     │   (My Table)    │     │ (Nazmul's)  │
└──────┬───────┘     └────────┬────────┘     └──────┬──────┘
       │                       │                    │
       │                       │ (FK)               │ (FK)
       │                       ▼                    ▼
       │              ┌─────────────────┐     ┌─────────────┐
       │              │ student_logins  │     │   courses   │
       │              │   (My Table)    │     │ (Emon's)    │
       │              └─────────────────┘     └──────┬──────┘
       │                                            │
       │                 ┌──────────────────────────┘
       │                 │
       │                 ▼
       │         ┌───────────────┐
       │         │  enrollments  │ ◄── Oishy's Module
       │         └───────┬───────┘
       │                 │ (FK)
       │                 ▼
       │         ┌───────────────┐
       │         │   results     │ ◄── Oishy's Module
       │         └───────────────┘
       │
       ▼
All connected through FOREIGN KEYS
```

### Detailed Table-to-Table Relationships

#### 1. students → departments (Many-to-One)

```sql
-- A student belongs to ONE department
SELECT s.full_name, d.department_name
FROM students s
INNER JOIN departments d ON s.department_id = d.id
WHERE s.student_id = '2023200000068';
```

- **FK in students:** `department_id` references `departments(id)`
- **Constraint:** RESTRICT ON DELETE (can't delete department if students exist)
- **Constraint:** CASCADE ON UPDATE

#### 2. students → semesters (Many-to-One)

```sql
-- A student belongs to ONE current semester
SELECT s.full_name, sem.semester_name
FROM students s
INNER JOIN semesters sem ON s.semester_id = sem.id;
```

- **FK in students:** `semester_id` references `semesters(id)`

#### 3. students → enrollments (One-to-Many)

```sql
-- One student can enroll in MANY courses across semesters
SELECT c.course_code, c.course_title, sem.semester_name
FROM enrollments e
INNER JOIN courses c ON e.course_id = c.id
INNER JOIN semesters sem ON e.semester_id = sem.id
WHERE e.student_id = 1;
```

- **FK in enrollments:** `student_id` references `students(id)`
- **One student can have:** Multiple enrollments (one per course per semester)

#### 4. enrollments → results (One-to-One)

```sql
-- Each enrollment has ONE result (grade)
SELECT c.course_code, r.letter_grade, r.grade_point
FROM enrollments e
INNER JOIN results r ON e.id = r.enrollment_id
WHERE e.student_id = 1;
```

- **FK in results:** `enrollment_id` references `enrollments(id)`

#### 5. enrollments → courses (Many-to-One)

- **FK in enrollments:** `course_id` references `courses(id)`

#### 6. courses → teachers (Many-to-One)

- **FK in courses:** `teacher_id` references `teachers(id)`

#### 7. courses → departments (Many-to-One)

- **FK in courses:** `department_id` references `departments(id)`

### Full Query Example - Dashboard Data Retrieval

This is how my dashboard fetches all the data using relationships:

```php
// In StudentDashboardController.php - Complete data fetching

// 1. Get student with department and semester
$student = Student::with(['department', 'semester'])->findOrFail($studentId);

// 2. Get all enrollments with course, semester, and result
$enrollments = Enrollment::with(['course', 'semester', 'result'])
    ->where('student_id', $studentId)
    ->get();

// 3. For each enrollment, we can access:
// $enrollment->course->course_code (from courses table)
// $enrollment->course->credit_hours (from courses table)
// $enrollment->semester->semester_name (from semesters table)
// $enrollment->result->letter_grade (from results table)
// $enrollment->result->grade_point (from results table)
```

### Summary - How My Tables Connect

| My Table | Connects To | Connection Type |
|----------|-------------|-----------------|
| students | departments | Foreign Key (department_id) |
| students | semesters | Foreign Key (semester_id) |
| students | enrollments | Via enrollments table (student_id FK) |
| students | results | Via enrollments → results chain |
| students | courses | Via enrollments → courses chain |
| student_logins | students | Foreign Key (student_id) with CASCADE |

### Key Points for Presentation:

1. **students is the central table** - All student data flows through it
2. **Foreign keys create relationships** - No data duplication
3. **One student can have many enrollments** - Each course per semester
4. **Each enrollment has one result** - Grade for that course
5. **Everything connects through relationships** - No isolated data
6. **Properly normalized database** - The way real systems are built!

---

## 10. Database Architecture Explanation

### How the Database Works in This Project

#### A) Laravel Migrations (Dynamic Database - The Real System)

The actual database is created using **Laravel Migrations** - PHP files that create the tables automatically when running `php artisan migrate`.

**Tables created via migrations:**
1. `departments` - Stores all departments
2. `semesters` - Stores semesters
3. `students` - Main student information table
4. `student_logins` - Student authentication credentials
5. `teachers` - Teacher information
6. `teacher_logins` - Teacher authentication
7. `courses` - All courses with credit hours
8. `enrollments` - Links students to courses per semester
9. `results` - Stores marks, grades, GPA per enrollment

**Why migrations are dynamic?**
- They create the TABLE STRUCTURE only (empty tables)
- No static data - tables are empty after migration
- Data is inserted via Seeders (PHP code)

#### B) Database Seeder (Dynamic Data Population)

The `DatabaseSeeder.php` dynamically populates the database with sample data when running `php artisan db:seed`.

**What the seeder does:**
- Creates departments (CSE, EEE, BBA)
- Creates semesters (Spring 2025, Summer 2025, Fall 2025)
- Creates teachers and coordinator
- Creates courses assigned to teachers
- Creates students
- Creates login credentials for all users
- Creates enrollments and generates results with marks
- Auto-calculates grades and GPA based on marks

**This is dynamic because:**
- Every run can create different data
- Uses Laravel's Eloquent ORM to create records
- Hashes passwords using bcrypt for security

#### C) SQL File (students_tables.sql) - Reference/Documentation

The SQL file in my module is a **reference document** showing:
- The exact SQL commands that Laravel migrations generate
- Example of how the tables look with data
- Used for understanding and manual database creation if needed
- Not used by the actual application - it's for learning purposes

#### D) Eloquent ORM - How the System Uses Database Dynamically

The real magic happens through **Laravel Eloquent ORM**. Instead of writing raw SQL, we use PHP models.

**Example from my StudentDashboardController:**

```php
// Dynamic query - fetches all enrollments with course, semester, result
$enrollments = Enrollment::with(['course', 'semester', 'result'])
    ->where('student_id', $studentId)
    ->get();

// Dynamic GPA calculation using relationships
foreach ($enrollments as $enrollment) {
    $credits = $enrollment->course->credit_hours;
    $totalPoints += $enrollment->result->grade_point * $credits;
}
```

**Model Relationships (Dynamic):**
- `Student` → belongsTo `Department`, belongsTo `Semester`
- `Student` → hasMany `Enrollment`
- `Enrollment` → belongsTo `Student`, belongsTo `Course`, belongsTo `Semester`
- `Enrollment` → hasOne `Result`
- `Result` → belongsTo `Enrollment`

**Benefits of Eloquent:**
- No raw SQL needed - all queries are dynamic
- Automatic table joining through relationships
- Security against SQL injection
- Easy to read and maintain

### Answer for Teacher: "How does the database work?"

**Answer:**
"Our project uses Laravel's Eloquent ORM for dynamic database operations. The system has:

1. **Migration Files** - PHP files that create the database tables automatically

2. **Seeder** - PHP code that populates the database with sample data

3. **Eloquent Models** - PHP classes that represent database tables. Instead of writing SQL queries, we use model methods like:
   - `Student::with(['department', 'semester'])->find($id)`
   - `Enrollment::with(['course', 'result'])->where('student_id', $id)->get()`

4. **Relationships** - Models are linked through relationships (belongsTo, hasMany, hasOne)

The SQL file in our module is a reference document showing the underlying SQL structure, but the actual system uses Laravel's dynamic ORM approach."

---

*Generated for academic submission*
*Student Result Management System v2*