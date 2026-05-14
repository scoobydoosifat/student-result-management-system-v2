<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>SRMS - Student Result Management System</title>
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --surface-muted: #f1f5f9;
            --text: #0f172a;
            --text-light: #475569;
            --muted: #64748b;
            --border: #e2e8f0;
            --accent: #0ea5e9;
            --accent-strong: #0284c7;
            --accent-soft: #e0f2fe;
            --success: #10b981;
            --success-soft: #d1fae5;
            --warning: #f59e0b;
            --warning-soft: #fef3c7;
            --danger: #ef4444;
            --danger-soft: #fee2e2;
            --purple: #8b5cf6;
            --purple-soft: #ede9fe;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: "IBM Plex Sans", "Segoe UI", system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, .brand {
            font-family: "Space Grotesk", "Segoe UI", system-ui, sans-serif;
            letter-spacing: -0.02em;
        }

        .app-nav {
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow);
        }

        .brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .brand-mark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--purple) 100%);
            color: white;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .navbar .nav-link {
            color: var(--muted);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .navbar .nav-link:hover, .navbar .nav-link:focus {
            color: var(--accent);
            background: var(--accent-soft);
        }

        .app-main {
            max-width: 1200px;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            background: var(--surface);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--muted);
            border-bottom: 2px solid var(--border);
            background: var(--surface-muted);
            font-weight: 600;
            padding: 1rem;
        }

        .table td, .table th {
            border-color: var(--border);
            padding: 1rem;
            vertical-align: middle;
        }

        .table-hover tbody tr {
            transition: background 0.15s;
        }

        .table-hover tbody tr:hover {
            background: var(--surface-muted);
        }

        .btn {
            font-weight: 600;
            padding: 0.6rem 1.25rem;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-strong) 100%);
            border: none;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.25);
        }

        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, var(--accent-strong) 0%, #0369a1 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);
        }

        .btn-outline-primary {
            border: 2px solid var(--accent);
            color: var(--accent);
            background: transparent;
        }

        .btn-outline-primary:hover, .btn-outline-primary:focus {
            background: var(--accent);
            color: white;
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border-color: var(--border);
            color: var(--text-light);
        }

        .btn-outline-secondary:hover {
            background: var(--surface-muted);
            color: var(--text);
        }

        .btn-outline-danger {
            border-color: var(--danger);
            color: var(--danger);
        }

        .btn-outline-danger:hover {
            background: var(--danger);
            color: white;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid var(--border);
            padding: 0.75rem 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .text-muted { color: var(--muted) !important; }

        .hero {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 3rem;
            align-items: center;
            min-height: 60vh;
        }

        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; text-align: center; }
        }

        .hero-copy .eyebrow {
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--accent);
            background: var(--accent-soft);
            padding: 0.4rem 1rem;
            border-radius: 999px;
            margin-bottom: 1rem;
        }

        .hero-copy .display-title {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            margin: 0.5rem 0 1.5rem;
            line-height: 1.1;
            background: linear-gradient(135deg, var(--text) 0%, var(--accent-strong) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-copy p {
            font-size: 1.15rem;
            color: var(--text-light);
            line-height: 1.7;
            max-width: 500px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .hero-card {
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow-lg);
        }

        .hero-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .hero-card p {
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .login-option {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 12px;
            border: 2px solid var(--border);
            text-decoration: none;
            color: var(--text);
            transition: all 0.2s;
            margin-bottom: 0.75rem;
        }

        .login-option:hover {
            border-color: var(--accent);
            background: var(--accent-soft);
            transform: translateX(4px);
        }

        .login-option .icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .login-option.student .icon { background: var(--accent-soft); color: var(--accent); }
        .login-option.coordinator .icon { background: var(--purple-soft); color: var(--purple); }
        .login-option.teacher .icon { background: var(--success-soft); color: var(--success); }

        .auth-shell {
            display: grid;
            place-items: center;
            min-height: calc(100vh - 80px);
            padding: 2rem;
        }

        .auth-card {
            width: min(420px, 100%);
        }

        .auth-card .card-header {
            text-align: center;
            padding: 2rem 2rem 1rem;
        }

        .auth-card h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .auth-card .card-body {
            padding: 1rem 2rem 2rem;
        }

        .auth-card .form-label {
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            border: 1px solid var(--border);
            font-size: 0.8rem;
            color: var(--muted);
            background: var(--surface);
        }

        .stat-card {
            border-radius: 16px;
            padding: 1.5rem;
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .profile-card {
            border-radius: 20px;
            overflow: hidden;
        }

        .profile-card .profile-header {
            padding: 2rem;
            background: linear-gradient(135deg, var(--accent) 0%, var(--purple) 100%);
            color: white;
            text-align: center;
        }

        .profile-card .profile-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 600;
            margin: 0 auto 1rem;
            border: 3px solid rgba(255,255,255,0.3);
        }

        .profile-card .profile-body {
            padding: 1.5rem;
        }

        .profile-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
        }

        .profile-item:last-child { border-bottom: none; }

        .profile-item span:first-child {
            color: var(--muted);
            font-weight: 500;
        }

        .profile-item span:last-child {
            font-weight: 600;
            color: var(--text);
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .action-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            padding: 1.5rem;
            border-radius: 16px;
            border: 2px solid var(--border);
            text-decoration: none;
            color: var(--text);
            transition: all 0.2s;
        }

        .action-card:hover {
            border-color: var(--accent);
            background: var(--accent-soft);
            transform: translateY(-3px);
        }

        .action-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .action-card.manage .icon { background: var(--accent-soft); color: var(--accent); }
        .action-card.history .icon { background: var(--purple-soft); color: var(--purple); }
        .action-card.drop .icon { background: var(--danger-soft); color: var(--danger); }

        .stagger > * { animation: rise 0.5s ease both; }
        .stagger > *:nth-child(2) { animation-delay: 0.05s; }
        .stagger > *:nth-child(3) { animation-delay: 0.1s; }
        .stagger > *:nth-child(4) { animation-delay: 0.15s; }
        .stagger > *:nth-child(5) { animation-delay: 0.2s; }

        @keyframes rise {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .badge-grade {
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .badge-grade.A { background: var(--success-soft); color: #047857; }
        .badge-grade.B { background: var(--accent-soft); color: #0369a1; }
        .badge-grade.C { background: var(--warning-soft); color: #b45309; }
        .badge-grade.D { background: #fef3c7; color: #d97706; }
        .badge-grade.F { background: var(--danger-soft); color: #b91c1c; }

        .empty-state {
            text-align: center;
            padding: 3rem;
        }

        .empty-state .icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--surface-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }

        @media (max-width: 768px) {
            .navbar .nav-link { padding-left: 0; }
            .hero { padding: 1rem; }
            .card-body { padding: 1rem; }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg app-nav sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand brand" href="/">
            <span class="brand-mark">SR</span>MS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if (session('student_id'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('student.dashboard') }}"><i class="bi bi-house-door me-1"></i>Dashboard</a></li>
                @elseif (session('teacher_id') && session('teacher_role') === 'coordinator')
                    <li class="nav-item"><a class="nav-link" href="{{ route('coordinator.dashboard') }}"><i class="bi bi-house-door me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('teacher.students.create') }}"><i class="bi bi-person-plus me-1"></i>Add Student</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('coordinator.teachers.create') }}"><i class="bi bi-person-badge me-1"></i>Add Teacher</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('departments.index') }}"><i class="bi bi-building me-1"></i>Departments</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('semesters.index') }}"><i class="bi bi-calendar3 me-1"></i>Semesters</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('courses.index') }}"><i class="bi bi-book me-1"></i>Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('enrollments.index') }}"><i class="bi bi-clipboard me-1"></i>Enrollments</a></li>
                @elseif (session('teacher_id') && session('teacher_role') === 'teacher')
                    <li class="nav-item"><a class="nav-link" href="{{ route('teacher.dashboard') }}"><i class="bi bi-house-door me-1"></i>Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('results.index') }}"><i class="bi bi-clipboard-data me-1"></i>Results</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('result-histories.index') }}"><i class="bi bi-clock-history me-1"></i>Result History</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('teacher.enrollments.index') }}"><i class="bi bi-person-dash me-1"></i>Drop From Course</a></li>
                @endif
            </ul>
            <div class="d-flex gap-2">
                @if (session('student_id'))
                    <form method="post" action="{{ route('student.logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                    </form>
                @elseif (session('teacher_id') && session('teacher_role') === 'coordinator')
                    <form method="post" action="{{ route('coordinator.logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                    </form>
                @elseif (session('teacher_id') && session('teacher_role') === 'teacher')
                    <form method="post" action="{{ route('teacher.logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                    </form>
                @else
                    <a class="btn btn-sm btn-primary" href="{{ route('student.login') }}"><i class="bi bi-person me-1"></i>Student</a>
                    <a class="btn btn-sm btn-primary" href="{{ route('coordinator.login') }}"><i class="bi bi-shield-check me-1"></i>Coordinator</a>
                    <a class="btn btn-sm btn-primary" href="{{ route('teacher.login') }}"><i class="bi bi-mortarboard me-1"></i>Teacher</a>
                @endif
            </div>
        </div>
    </div>
</nav>
<main class="container app-main py-4">
    @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
