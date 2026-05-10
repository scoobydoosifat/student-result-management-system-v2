<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>SRMS</title>
    <style>
        :root {
            --bg: #f3f4f2;
            --surface: #ffffff;
            --surface-muted: #f8f9fb;
            --text: #0f172a;
            --muted: #5b6475;
            --border: #e2e6ea;
            --accent: #0f766e;
            --accent-strong: #0c5f59;
            --accent-soft: #e7f4f2;
            --danger: #b42318;
            --shadow: 0 18px 36px rgba(15, 23, 42, 0.08);
        }

        body {
            font-family: "IBM Plex Sans", "Segoe UI", system-ui, -apple-system, sans-serif;
            background-color: var(--bg);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Ccircle cx='2' cy='2' r='1.5' fill='%23dde3e8'/%3E%3C/svg%3E");
            background-size: 120px 120px;
            color: var(--text);
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, .brand {
            font-family: "Space Grotesk", "Segoe UI", system-ui, sans-serif;
            letter-spacing: -0.02em;
        }

        .app-nav {
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
        }

        .brand {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--text) !important;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .brand-mark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--accent-soft);
            color: var(--accent-strong);
            font-weight: 700;
            font-size: 0.85rem;
        }

        .navbar .nav-link {
            color: var(--muted);
            font-weight: 500;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: var(--text);
        }

        .app-main {
            max-width: 1100px;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            background: var(--surface);
        }

        .card-body {
            padding: 1.5rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
            background: var(--surface-muted);
        }

        .table td,
        .table th {
            border-color: var(--border);
            padding: 0.85rem 0.9rem;
            vertical-align: middle;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background: var(--surface-muted);
        }

        .btn-primary {
            background: var(--accent);
            border-color: var(--accent);
            font-weight: 600;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--accent-strong);
            border-color: var(--accent-strong);
        }

        .btn-outline-primary {
            border-color: var(--accent);
            color: var(--accent);
            font-weight: 600;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary:focus {
            background: var(--accent);
            border-color: var(--accent);
            color: #ffffff;
        }

        .btn-outline-secondary {
            border-color: var(--border);
            color: var(--text);
        }

        .btn-outline-danger {
            border-color: var(--danger);
            color: var(--danger);
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border-color: var(--border);
            padding: 0.65rem 0.75rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(15, 118, 110, 0.12);
        }

        .text-muted {
            color: var(--muted) !important;
        }

        .hero {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
            align-items: center;
        }

        .hero-copy .eyebrow {
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--muted);
        }

        .hero-copy .display-title {
            font-size: clamp(2rem, 4vw, 3rem);
            margin: 0.6rem 0 1rem;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-top: 1.5rem;
        }

        .hero-card {
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .auth-shell {
            display: grid;
            place-items: center;
            min-height: 70vh;
        }

        .auth-card {
            width: min(440px, 100%);
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 600;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            border: 1px solid var(--border);
            font-size: 0.75rem;
            color: var(--muted);
            background: var(--surface);
        }

        .stagger > * {
            animation: rise 0.5s ease both;
        }

        .stagger > *:nth-child(2) { animation-delay: 0.05s; }
        .stagger > *:nth-child(3) { animation-delay: 0.1s; }
        .stagger > *:nth-child(4) { animation-delay: 0.15s; }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .navbar .nav-link {
                padding-left: 0;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg app-nav">
    <div class="container-fluid">
        <a class="navbar-brand brand" href="/">
            <span class="brand-mark">SR</span>MS
        </a>
        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if (session('student_id'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('student.dashboard') }}">Dashboard</a></li>
                @elseif (session('teacher_id') && session('teacher_role') === 'coordinator')
                    <li class="nav-item"><a class="nav-link" href="{{ route('coordinator.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('teacher.students.create') }}">Add Student</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('coordinator.teachers.create') }}">Add Teacher</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('departments.index') }}">Departments</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('semesters.index') }}">Semesters</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('courses.index') }}">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('enrollments.index') }}">Enrollments</a></li>
                @elseif (session('teacher_id') && session('teacher_role') === 'teacher')
                    <li class="nav-item"><a class="nav-link" href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('results.index') }}">Results</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('result-histories.index') }}">Result History</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('teacher.enrollments.index') }}">Drop From Course</a></li>
                @endif
            </ul>
            <div class="d-flex gap-2">
                @if (session('student_id'))
                    <form method="post" action="{{ route('student.logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                @elseif (session('teacher_id') && session('teacher_role') === 'coordinator')
                    <form method="post" action="{{ route('coordinator.logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                @elseif (session('teacher_id') && session('teacher_role') === 'teacher')
                    <form method="post" action="{{ route('teacher.logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                @else
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('student.login') }}">Student Login</a>
                    <a class="btn btn-sm btn-primary" href="{{ route('coordinator.login') }}">Coordinator Login</a>
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('teacher.login') }}">Teacher Login</a>
                @endif
            </div>
        </div>
    </div>
</nav>
<main class="container app-main py-4">
    @yield('content')
</main>
</body>
</html>
