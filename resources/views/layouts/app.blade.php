<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary: #6366f1;   /* Indigo */
            --primary-dark: #4f46e5;
            --secondary: #6b7280;
            --danger: #ef4444;
            --success: #22c55e;
            --gray-light: #f9fafb;
            --gray-dark: #1f2937;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-light);
            color: var(--gray-dark);
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: var(--white);
            border-right: 1px solid #e5e7eb;
            padding: 1rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-header {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .nav-link {
            display: block;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            color: var(--gray-dark);
            font-weight: 500;
            transition: background 0.2s;
        }
        .nav-link:hover {
            background: var(--gray-light);
        }
        .nav-link.active {
            background: var(--primary);
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        input, textarea, select {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
        }
        input:focus, textarea:focus, select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 2px rgb(99 102 241 / 0.2);
        }

        /* Buttons */
        .btn {
            background: var(--primary);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn:hover { background: var(--primary-dark); }
        .btn-secondary {
            background: #f3f4f6;
            color: var(--gray-dark);
        }
        .btn-secondary:hover { background: #e5e7eb; }
        .btn-danger { background: var(--danger); }
        .btn-danger:hover { background: #dc2626; }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .alert-success {
            background: #ecfdf5;
            border: 1px solid var(--success);
            color: #065f46;
        }
        .alert-danger {
            background: #fef2f2;
            border: 1px solid var(--danger);
            color: #991b1b;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-header">📚 Softvence</div>
            <nav>
                <a href="{{ route('courses.create') }}" class="nav-link {{ request()->routeIs('courses.create') ? 'active' : '' }}">
                    ➕ Create Course
                </a>
                <!-- Future navigation links here -->
            </nav>
        </aside>

        <main class="main-content">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>
