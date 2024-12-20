<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel App')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg-color: #333333;
            --sidebar-text-color: white;
            --sidebar-brand-font-size: 28px;
            --sidebar-padding: 20px;
            --sidebar-link-hover-bg: #495057;
            --sidebar-width: 250px;
            --collapsed-sidebar-width: 60px;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #333333;
        }

        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }

        .navbar .collapse {
            transition: all 0.3s ease;
        }

        .navbar-collapsed .navbar-collapse {
            display: none;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
        }

        .footer a {
            color: #ffffff;
            text-decoration: underline;
        }

        .sidebar {
            background-color: var(--sidebar-bg-color);
            color: var(--sidebar-text-color);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            padding-top: var(--sidebar-padding);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            transition: width 0.3s ease;
        }

        .sidebar .brand {
            font-size: var(--sidebar-brand-font-size);
            font-weight: bold;
            color: var(--sidebar-text-color);
            margin-bottom: 20px;
            text-align: center;
            cursor: pointer;
        }

        .sidebar hr {
            border-top: 1px solid #495057;
            margin-bottom: 20px;
            width: 100%;
        }

        .sidebar a {
            color: var(--sidebar-text-color);
            text-decoration: none;
            display: block;
            padding: 10px;
            margin: 5px 0; 
            border-radius: 4px;
            text-align: center;
            font-weight: bold; 
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: var(--sidebar-link-hover-bg);
        }

        .content-wrapper {
            margin-left: calc(var(--sidebar-width) + 20px);
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .sidebar .brand:hover {
            transform: scale(1.1);
        }

        .sidebar.collapsed .products-link {
            display: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <span class="navbar-brand">‎>‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ ‎ 🗣️αвѕσυℓυтє вσσкιмα</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ auth()->user()->profile_picture_url }}" alt="Profile Image" class="rounded-circle" width="40" height="40">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    </ul>
                </li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <div class="brand" id="sidebar-toggle">🦶🦶🏻🦶🏽🦶🏼</div>
        <hr>
        <a href="{{ route('home') }}" class="view-link">Home</a>
        <a href="{{ route('products.index') }}" class="products-link">Products</a>
        @if(auth()->user()->hasRole('Admin'))
        <a href="{{ route('users.index') }}" class="user-management-link">User Management</a>
        @endif
    </div>

    <div class="content-wrapper" id="content-wrapper">
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    const sidebar = document.getElementById('sidebar');
    const contentWrapper = document.getElementById('content-wrapper');
    const toggleButton = document.getElementById('sidebar-toggle');
    const navbar = document.querySelector('.navbar');

    let isSidebarCollapsed = false;

    toggleButton.addEventListener('click', function () {
        if (isSidebarCollapsed) {
            sidebar.style.width = 'var(--sidebar-width)';
            contentWrapper.style.marginLeft = 'calc(var(--sidebar-width) + 20px)';
            sidebar.classList.remove('collapsed');
            navbar.classList.remove('navbar-collapsed');
        } else {
            sidebar.style.width = 'var(--collapsed-sidebar-width)';
            contentWrapper.style.marginLeft = 'calc(var(--collapsed-sidebar-width) + 20px)';
            sidebar.classList.add('collapsed');
            navbar.classList.add('navbar-collapsed');
        }
        isSidebarCollapsed = !isSidebarCollapsed;
    });

    window.addEventListener('DOMContentLoaded', () => {
        if (window.innerWidth <= 768) {
            sidebar.style.width = 'var(--collapsed-sidebar-width)';
            contentWrapper.style.marginLeft = 'calc(var(--collapsed-sidebar-width) + 20px)';
            sidebar.classList.add('collapsed');
            navbar.classList.add('navbar-collapsed');
            isSidebarCollapsed = true;
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768 && !isSidebarCollapsed) {
            sidebar.style.width = 'var(--collapsed-sidebar-width)';
            contentWrapper.style.marginLeft = 'calc(var(--collapsed-sidebar-width) + 20px)';
            sidebar.classList.add('collapsed');
            navbar.classList.add('navbar-collapsed');
            isSidebarCollapsed = true;
        } else if (window.innerWidth > 768 && isSidebarCollapsed) {
            sidebar.style.width = 'var(--sidebar-width)';
            contentWrapper.style.marginLeft = 'calc(var(--sidebar-width) + 20px)';
            sidebar.classList.remove('collapsed');
            navbar.classList.remove('navbar-collapsed');
            isSidebarCollapsed = false;
        }
    });
    </script>

</body>
</html>
