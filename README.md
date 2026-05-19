# EMON Module — Department, Semester & Course Management

**Student Result Management System (SRMS)**
**Developer:** Emon
**Branch:** `Emon`
**Commit:** `eb7deb8` — *"Add Emon module - departments, semesters, courses CRUD"*

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

Emon was responsible for designing and implementing the foundational data structures of SRMS — the **Department**, **Semester**, and **Course** management modules. These three entities form the backbone of the entire system, as every student, teacher, enrollment, and result ultimately depends on them.

| Responsibility | Description |
|---------------|-------------|
| **Department Management** | Full CRUD operations for academic departments |
| **Semester Management** | Full CRUD operations for academic semesters |
| **Course Management** | Full CRUD operations with department and teacher assignment |
| **Database Design** | Schema definition, foreign key constraints, and seed data |
| **Normalization** | Ensuring all tables follow Third Normal Form (3NF) |
| **Query Optimization** | Analytical queries for reporting and statistics |

---

# 2. Module Overview

Emon's module consists of **3 controllers**, **9 Blade views**, **2 SQL files**, and **shared model usage** that together provide complete management of core academic entities.

```
┌──────────────────────────────────────────────────────────────┐
│                      EMON MODULE                               │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│   ┌──────────────┐    ┌──────────────┐    ┌──────────────┐   │
│   │  Department   │    │   Semester   │    │    Course    │   │
│   │  Controller   │    │  Controller  │    │  Controller  │   │
│   └──────┬───────┘    └──────┬───────┘    └──────┬───────┘   │
│          │                   │                   │          │
│          ▼                   ▼                   ▼          │
│   ┌──────────────┐    ┌──────────────┐    ┌──────────────┐   │
│   │  Department   │    │   Semester   │    │    Course    │   │
│   │  Views (3)    │    │  Views (3)   │    │  Views (3)   │   │
│   └──────────────┘    └──────────────┘    └──────────────┘   │
│                                                              │
└──────────────────────────────────────────────────────────────┘
```

---

# 3. Technical Contributions

## 3.1 Controllers Built

| Controller | File | Lines | Methods |
|------------|------|-------|---------|
| `DepartmentController` | `app/Modules/Emon/Controllers/DepartmentController.php` | 43 | index, create, store, edit, update, destroy |
| `SemesterController` | `app/Modules/Emon/Controllers/SemesterController.php` | 43 | index, create, store, edit, update, destroy |
| `CourseController` | `app/Modules/Emon/Controllers/CourseController.php` | 73 | index, create, store, edit, update, destroy |

## 3.2 Views Built

| View | Purpose |
|------|---------|
| `resources/views/emon/departments/index.blade.php` | Department list with Edit/Delete actions |
| `resources/views/emon/departments/create.blade.php` | Create department form |
| `resources/views/emon/departments/edit.blade.php` | Edit department form |
| `resources/views/emon/semesters/index.blade.php` | Semester list with Edit/Delete actions |
| `resources/views/emon/semesters/create.blade.php` | Create semester form |
| `resources/views/emon/semesters/edit.blade.php` | Edit semester form |
| `resources/views/emon/courses/index.blade.php` | Course list with department & teacher info |
| `resources/views/emon/courses/create.blade.php` | Create course form (dropdowns for dep/teacher) |
| `resources/views/emon/courses/edit.blade.php` | Edit course form |

## 3.3 Database Files

| File | Purpose |
|------|---------|
| `database/migrations/2026_01_01_000001_create_departments_table.php` | Departments migration (shared) |
| `database/migrations/2026_01_01_000002_create_semesters_table.php` | Semesters migration (shared) |
| `database/migrations/2026_01_01_000005_create_courses_table.php` | Courses migration with foreign keys (shared) |
| `app/Modules/Emon/Database/department_semester_tables.sql` | Standalone SQL schema with seed data |
| `app/Modules/Emon/Queries/department_semester_queries.sql` | Analytical SQL query examples |

## 3.4 Shared Models Used

| Model | Usage in Emon's Controllers |
|-------|----------------------------|
| `App\Models\Department` | Department CRUD, course creation dropdown |
| `App\Models\Semester` | Semester CRUD |
| `App\Models\Course` | Course CRUD with eager loading |
| `App\Models\Teacher` | Course creation dropdown (filtered by role=teacher) |

---

# 4. File Structure

```
📁 app/Modules/Emon/
├── 📁 Controllers/
│   ├── DepartmentController.php
│   ├── SemesterController.php
│   └── CourseController.php
├── 📁 Database/
│   └── department_semester_tables.sql
├── 📁 Documentation/
│   └── README.md
└── 📁 Queries/
    └── department_semester_queries.sql

📁 resources/views/emon/
├── 📁 departments/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
├── 📁 semesters/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── 📁 courses/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

---

# 5. Controllers & Backend Logic

## 5.1 DepartmentController

The `DepartmentController` provides full CRUD for academic departments with server-side validation and uniqueness constraints.

```php
// Validation on store
'department_name' => 'required|string|unique:departments'

// Validation on update (excludes current record)
'department_name' => 'required|string|unique:departments,department_name,' . $department->id
```

**Route names defined:** `departments.index`, `departments.create`, `departments.store`, `departments.edit`, `departments.update`, `departments.destroy`

### Methods Breakdown

| Method | HTTP Verb | URI | Description |
|--------|-----------|-----|-------------|
| `index()` | GET | `/departments` | List all departments |
| `create()` | GET | `/departments/create` | Show create form |
| `store()` | POST | `/departments` | Store new department |
| `edit()` | GET | `/departments/{department}/edit` | Show edit form |
| `update()` | PUT/PATCH | `/departments/{department}` | Update department |
| `destroy()` | DELETE | `/departments/{department}` | Delete department |

### Workflow

```
User (Coordinator) → GET /departments
       │
       ├─> View all departments (index)
       │
       ├─> GET /departments/create → Fill form → POST /departments
       │       └─> Validation passes → Department created → Redirect to index
       │       └─> Validation fails → Return with errors
       │
       ├─> GET /departments/{id}/edit → Modify form → PUT /departments/{id}
       │       └─> Validation passes → Department updated → Redirect to index
       │
       └─> DELETE /departments/{id}
               └─> Department has related records? → RESTRICT (DB blocks)
               └─> No related records → Department deleted
```

## 5.2 SemesterController

The `SemesterController` mirrors the Department controller with identical CRUD operations for academic semesters.

```php
// Validation on store
'semester_name' => 'required|string|unique:semesters'
```

**Route names defined:** `semesters.index`, `semesters.create`, `semesters.store`, `semesters.edit`, `semesters.update`, `semesters.destroy`

### Methods Breakdown

| Method | HTTP Verb | URI | Description |
|--------|-----------|-----|-------------|
| `index()` | GET | `/semesters` | List all semesters |
| `create()` | GET | `/semesters/create` | Show create form |
| `store()` | POST | `/semesters` | Store new semester |
| `edit()` | GET | `/semesters/{semester}/edit` | Show edit form |
| `update()` | PUT/PATCH | `/semesters/{semester}` | Update semester |
| `destroy()` | DELETE | `/semesters/{semester}` | Delete semester |

## 5.3 CourseController

The `CourseController` is the most complex of Emon's three controllers. It handles course creation with foreign key relationships to both `departments` and `teachers`, and enforces multi-field validation.

```php
// Validation rules
'course_code'   => 'required|string|unique:courses,course_code',
'course_title'  => 'required|string',
'credit_hours'  => 'required|integer|min:1|max:6',
'department_id' => 'required|exists:departments,id',
'teacher_id'    => 'required|exists:teachers,id',
```

**Key implementation details:**

1. **Eager Loading**: `index()` uses `Course::with(['department', 'teacher'])` to avoid N+1 queries
2. **Ordered Results**: Courses are ordered by `course_code` for consistent display
3. **Filtered Dropdowns**: `create()` and `edit()` pass `Teacher::where('role', 'teacher')` so only actual teachers (not coordinators) appear in the assignment dropdown
4. **Relationship Validation**: `exists:departments,id` and `exists:teachers,id` ensure referential integrity at the application layer

### Methods Breakdown

| Method | HTTP Verb | URI | Description |
|--------|-----------|-----|-------------|
| `index()` | GET | `/courses` | List all courses with department/teacher |
| `create()` | GET | `/courses/create` | Show form with department/teacher dropdowns |
| `store()` | POST | `/courses` | Store new course with validation |
| `edit()` | GET | `/courses/{course}/edit` | Show edit form with preselected values |
| `update()` | PUT/PATCH | `/courses/{course}` | Update course with validation |
| `destroy()` | DELETE | `/courses/{course}` | Delete course |

### Workflow

```
User (Coordinator) → GET /courses
       │
       ├─> Display table with:
       │     Course Code | Course Title | Credits | Department | Teacher
       │
       ├─> GET /courses/create
       │     ├─> Department dropdown (ordered by name)
       │     └─> Teacher dropdown (only role=teacher, ordered by ID)
       │
       ├─> POST /courses
       │     ├─> Validates: code unique, title string, credits 1-6, dept exists, teacher exists
       │     ├─> Success → Course created → Redirect to index
       │     └─> Failure → Return with validation errors
       │
       └─> DELETE /courses/{id}
             └─> Course deleted (no cascade restrictions on courses table)
```

---

# 6. Frontend Views

## 6.1 Design Principles

- **Consistent Layout**: All views extend `layouts.app` (Bootstrap 5 base)
- **Responsive Tables**: `table table-striped` for index views
- **Form Validation**: Client-side HTML5 validation + Laravel server-side validation
- **Empty States**: Graceful handling when no records exist (`@forelse` with `@empty`)
- **Bootstrap Icons**: Edit (pencil) and Delete (trash) action icons

## 6.2 Department Views

### index.blade.php
```
┌─────────────────────────────────────────────────────┐
│  Departments                                         │
│  ┌─────────────────────────────────────────────────┐ │
│  │  + Add New Department    (button)               │ │
│  ├─────────────────────────────────────────────────┤ │
│  │  #  │ Department Name                   │ Actions│ │
│  ├────┼─────────────────────────────────────┼────────┤ │
│  │  1  │ Computer Science & Engineering     │ ✏️ 🗑️ │ │
│  │  2  │ Electrical & Electronic Engineering │ ✏️ 🗑️ │ │
│  │  3  │ Business Administration            │ ✏️ 🗑️ │ │
│  └────┴─────────────────────────────────────┴────────┘ │
└─────────────────────────────────────────────────────┘
```

### create.blade.php
```
┌───────────────────────────────────────┐
│  Add New Department                   │
│                                       │
│  Department Name:  [_______________]  │
│                                       │
│  [Create Department]                  │
└───────────────────────────────────────┘
```

## 6.3 Semester Views

Semester views follow the same pattern as departments, displaying `semester_name` in a single-column table with action buttons.

## 6.4 Course Views

### index.blade.php
```
┌─────────────────────────────────────────────────────────────────────────┐
│  Courses                                                                │
│  ┌─────────────────────────────────────────────────────────────────────┐│
│  │  + Add New Course          (button)                                ││
│  ├─────────────────────────────────────────────────────────────────────┤│
│  │  #  │ Course               │ Credits │ Department │ Teacher │ Actions│
│  ├────┼───────────────────────┼─────────┼────────────┼─────────┼────────┤
│  │  1  │ CSE-101              │    3    │ CSE        │ T-1001  │ ✏️ 🗑️ │
│  │     │ Intro to CS          │         │            │ Md.Rahman       │
│  │  2  │ CSE-201              │    4    │ CSE        │ T-1002  │ ✏️ 🗑️ │
│  │     │ Data Structures      │         │            │ M.Hasan         │
│  └────┴───────────────────────┴─────────┴────────────┴─────────┴────────┘│
└─────────────────────────────────────────────────────────────────────────┘
```

### create.blade.php
```
┌───────────────────────────────────────────────┐
│  Add New Course                                │
│                                               │
│  Course Code:   [CSE-301        ]             │
│  Course Title:  [Database Systems ]           │
│  Credit Hours:  [3        ▼]                  │
│  Department:    [CSE      ▼]                  │
│  Teacher:       [T-1001 - Md. Rahman  ▼]      │
│                                               │
│  [Create Course]                              │
└───────────────────────────────────────────────┘
```

---

# 7. Database Design

## 7.1 Entity Relationship Diagram

```
┌───────────────────┐
│   departments     │
├───────────────────┤
│ id (PK)           │──┐
│ department_name   │  │
│ created_at        │  │
│ updated_at        │  │
└───────────────────┘  │
                       │
┌───────────────────┐  │
│    courses        │  │
├───────────────────┤  │
│ id (PK)           │  │
│ course_code       │  │
│ course_title      │  │
│ credit_hours      │  │
│ department_id (FK)│──┤
│ teacher_id (FK)   │  │
│ created_at        │  │
│ updated_at        │  │
└───────────────────┘  │
                       │
┌───────────────────┐  │
│   semesters       │  │
├───────────────────┤  │
│ id (PK)           │  │
│ semester_name     │  │
│ created_at        │  │
│ updated_at        │  │
└───────────────────┘  │
                       │
┌───────────────────┐  │
│    teachers       │  │
├───────────────────┤  │
│ id (PK)           │  │
│ teacher_id        │  │
│ department_id (FK)│──┘
│ ...               │
└───────────────────┘
```

## 7.2 Schema Definitions

### departments

| Column | Type | Constraints |
|--------|------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT |
| department_name | VARCHAR(255) | NOT NULL, UNIQUE |
| created_at | TIMESTAMP | NULLABLE |
| updated_at | TIMESTAMP | NULLABLE |

### semesters

| Column | Type | Constraints |
|--------|------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT |
| semester_name | VARCHAR(255) | NOT NULL, UNIQUE |
| created_at | TIMESTAMP | NULLABLE |
| updated_at | TIMESTAMP | NULLABLE |

### courses

| Column | Type | Constraints |
|--------|------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT |
| course_code | VARCHAR(255) | NOT NULL, UNIQUE |
| course_title | VARCHAR(255) | NOT NULL |
| credit_hours | TINYINT UNSIGNED | NOT NULL, 1-6 |
| department_id | BIGINT UNSIGNED | FK → departments.id, RESTRICT ON DELETE, CASCADE ON UPDATE |
| teacher_id | BIGINT UNSIGNED | FK → teachers.id |
| created_at | TIMESTAMP | NULLABLE |
| updated_at | TIMESTAMP | NULLABLE |

## 7.3 Key Design Decisions

| Decision | Rationale |
|----------|-----------|
| **UNIQUE on department_name** | Prevents duplicate department entries |
| **UNIQUE on semester_name** | Prevents duplicate semester entries (e.g., two "Spring 2025") |
| **UNIQUE on course_code** | Ensures each course has a unique identifier across all departments |
| **RESTRICT ON DELETE (department FK)** | Prevents deletion of departments that still have associated courses — maintains referential integrity |
| **CASCADE ON UPDATE (department FK)** | If a department ID changes (unlikely but possible), courses automatically update |
| **credit_hours min:1 max:6** | Validation ensures academic consistency (standard university range) |
| **Eager Loading** | `Course::with(['department', 'teacher'])` prevents N+1 query problem |
| **Teacher role filter** | Only teachers (not coordinators) appear in course assignment dropdown |

## 7.4 Seed Data

Emon's SQL file includes comprehensive seed data for testing and development:

### Departments (8 records)

| ID | Department Name |
|----|----------------|
| 1 | Computer Science & Engineering |
| 2 | Electrical & Electronic Engineering |
| 3 | Civil Engineering |
| 4 | Mechanical Engineering |
| 5 | Business Administration |
| 6 | English |
| 7 | Mathematics |
| 8 | Physics (deleted in example) |

### Semesters (7 records)

| ID | Semester Name |
|----|--------------|
| 1 | Spring 2024 |
| 2 | Summer 2024 |
| 3 | Autumn 2024 |
| 4 | Spring 2025 |
| 5 | Summer 2025 |
| 6 | Autumn 2025 |
| 7 | Spring 2026 |

### Courses (5 records)

| Code | Title | Credits | Department |
|------|-------|---------|------------|
| CSE-101 | Introduction to Computer Science | 3 | CSE |
| CSE-201 | Data Structures and Algorithms | 4 | CSE |
| EEE-101 | Basic Electrical Engineering | 3 | EEE |
| CIV-101 | Civil Engineering Fundamentals | 3 | Civil |
| BUS-101 | Introduction to Business | 3 | BBA |

## 7.5 Analytical Queries

Emon also provided analytical SQL queries for reporting:

```sql
-- Student count per department
SELECT d.department_name, COUNT(s.id) AS student_count
FROM departments d
LEFT JOIN students s ON s.department_id = d.id
GROUP BY d.department_name;

-- Enrollment statistics per semester
SELECT sem.semester_name,
       COUNT(DISTINCT e.student_id) as total_students,
       COUNT(DISTINCT e.course_id) as total_courses
FROM semesters sem
LEFT JOIN enrollments e ON sem.id = e.semester_id
GROUP BY sem.id, sem.semester_name;

-- Department-wise teacher and student counts
SELECT department_name,
       (SELECT COUNT(*) FROM students WHERE department_id = departments.id) as student_count,
       (SELECT COUNT(*) FROM teachers WHERE department_id = departments.id) as teacher_count
FROM departments;
```

---

# 8. System Workflow

## 8.1 Emon's Module in the System Context

Emon's module provides the foundational setup that all other modules depend on:

```
COORDINATOR SETUP PHASE (Emon's Module)
│
├─> 1. CREATE DEPARTMENTS
│       → DepartmentController@store
│       → Validates unique name
│       → Creates foundation for students, teachers, courses
│
├─> 2. CREATE SEMESTERS
│       → SemesterController@store
│       → Validates unique name
│       → Creates time periods for enrollments and results
│
└─> 3. CREATE COURSES
        → CourseController@store
        → Assigns department + teacher
        → Courses are the container for enrollments and results

        ↓

DEPENDENT MODULES USE THIS DATA:
├─> Nazmul's Module: Teachers belong to departments, assigned to courses
├─> Sifat's Module: Students belong to departments and semesters
├─> Oishy's Module: Enrollments link students to courses per semester
└─> Mithila's Module: Transcripts display courses with department info
```

## 8.2 CRUD Workflow Diagram

```
                     ┌─────────────────────────────┐
                     │      Coordinator Logs In      │
                     └─────────────┬───────────────┘
                                   │
                     ┌─────────────▼───────────────┐
                     │   Dashboard (Coordinator)    │
                     └─────┬───────┬───────┬───────┘
                           │       │       │
              ┌────────────▼──┐ ┌──▼────────┐ ┌▼────────────┐
              │  Departments  │ │ Semesters  │ │  Courses    │
              │  Management   │ │ Management │ │ Management  │
              └───────┬───────┘ └──────┬─────┘ └──────┬──────┘
                      │                │               │
         ┌────────────┼─────────────┬──┘          ┌────┴────┐
         ▼            ▼             ▼              ▼         ▼
   ┌──────────┐ ┌──────────┐ ┌──────────┐  ┌──────────┐ ┌──────────┐
   │  Create  │ │   Edit   │ │   List   │  │  Assign  │ │  View    │
   │ Dept     │ │ Dept     │ │ All Depts│  │ Teacher  │ │ Students │
   └──────────┘ └──────────┘ └──────────┘  └──────────┘ └──────────┘
```

---

# 9. Key Features Implemented

## 9.1 Complete CRUD Operations

Every controller implements the full **Create, Read, Update, Delete** lifecycle:

| Operation | Department | Semester | Course |
|-----------|------------|----------|--------|
| **Create** | ✅ Unique name validation | ✅ Unique name validation | ✅ 5-field validation with FK checks |
| **Read** | ✅ All records with sort | ✅ All records with sort | ✅ Eager-loaded with relations |
| **Update** | ✅ Name change with uniqueness | ✅ Name change with uniqueness | ✅ All fields editable |
| **Delete** | ✅ With FK restriction | ✅ With FK restriction | ✅ Cascade-free deletion |

## 9.2 Data Integrity

- **Application-level validation**: Laravel `validate()` with `unique`, `exists`, `min`, `max` rules
- **Database-level constraints**: UNIQUE indexes, FOREIGN KEY with RESTRICT/CASCADE
- **Referential integrity**: Cannot delete a department that still has courses

## 9.3 User Experience

- **Bootstrap 5 UI**: Consistent with the rest of SRMS
- **Empty states**: User-friendly messages when no data exists
- **Inline actions**: Edit/Delete buttons on every table row
- **Form validation feedback**: Both client-side HTML5 and server-side Laravel errors

## 9.4 Performance

- **Eager loading**: Prevents N+1 queries in Course listing
- **Ordered results**: Consistent display order for all entities
- **Filtered queries**: Teacher dropdown only shows role=teacher

---

# 10. Code Location Summary

```
Backend (Controllers):
  app/Modules/Emon/Controllers/DepartmentController.php
  app/Modules/Emon/Controllers/SemesterController.php
  app/Modules/Emon/Controllers/CourseController.php

Frontend (Views):
  resources/views/emon/departments/index.blade.php
  resources/views/emon/departments/create.blade.php
  resources/views/emon/departments/edit.blade.php
  resources/views/emon/semesters/index.blade.php
  resources/views/emon/semesters/create.blade.php
  resources/views/emon/semesters/edit.blade.php
  resources/views/emon/courses/index.blade.php
  resources/views/emon/courses/create.blade.php
  resources/views/emon/courses/edit.blade.php

Database:
  app/Modules/Emon/Database/department_semester_tables.sql
  app/Modules/Emon/Queries/department_semester_queries.sql

Documentation:
  app/Modules/Emon/Documentation/README.md

Shared Models Used:
  app/Models/Department.php
  app/Models/Semester.php
  app/Models/Course.php

Routes (defined in main project routes/web.php):
  departments.* (6 routes)
  semesters.* (6 routes)
  courses.* (6 routes)
```

---

# Appendix: Quick Reference

## Validation Rules Summary

| Controller | Field | Rules |
|-----------|-------|-------|
| Department | `department_name` | required, string, unique:departments |
| Semester | `semester_name` | required, string, unique:semesters |
| Course | `course_code` | required, string, unique:courses |
| Course | `course_title` | required, string |
| Course | `credit_hours` | required, integer, min:1, max:6 |
| Course | `department_id` | required, exists:departments,id |
| Course | `teacher_id` | required, exists:teachers,id |

## Route Names

| Prefix | Routes |
|--------|--------|
| `departments.*` | index, create, store, edit, update, destroy |
| `semesters.*` | index, create, store, edit, update, destroy |
| `courses.*` | index, create, store, edit, update, destroy |

## Middleware Protection

All routes in Emon's module are protected by the **CoordinatorAuth** middleware, ensuring only logged-in coordinators can manage departments, semesters, and courses.

---

**Author:** Emon
**Branch:** `Emon`
**Commit:** `eb7deb8374bb2255823a7ebc15ee96578f08a289`
**Last Updated:** May 2026
