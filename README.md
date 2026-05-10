# SRMS

Student Result Management System (SRMS) built with Laravel. This project covers student and teacher logins, result management, GPA calculation, transcripts, and admin tools.

## Features

- Student, teacher, and coordinator authentication
- Department, course, semester, and enrollment management
- Result entry, GPA and grade calculation
- Result history tracking and transcript downloads
- Teacher panel with assigned courses

## Tech Stack

- Laravel (PHP)
- MySQL (XAMPP supported)
- Bootstrap 5

## Requirements

- PHP 8.2+ (XAMPP PHP is fine)
- Composer
- MySQL (XAMPP or standalone)
- Node.js (optional, only if you plan to build assets)

## Setup (Windows + XAMPP)

1. Start Apache and MySQL from XAMPP.
2. Create a database named `srms` in phpMyAdmin.
3. Copy `.env.example` to `.env` and update DB values:

	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=srms
	DB_USERNAME=root
	DB_PASSWORD=

4. Install dependencies:

	composer install

5. Generate the app key:

	php artisan key:generate

6. Run migrations and seeders:

	php artisan migrate --seed

7. Start the development server:

	php artisan serve

Open http://127.0.0.1:8000

## If php is not recognized

If you rely on XAMPP PHP, run:

set PATH=C:\xampp\php;%PATH%

Then re-run the artisan commands.

## Seeded Logins

- Student: S-24001 / password
- Teacher: T-1001 / password
- Coordinator: C-9001 / password

## Modules

- Sifat: student module
- Nazmul: teacher and coordinator module
- Emon: departments and semesters
- Oishy: enrollments and results
- Mithila: result history and transcripts

## Troubleshooting

- Migration errors: verify database name/credentials in `.env`.
- Cache issues: run `php artisan config:clear`.
