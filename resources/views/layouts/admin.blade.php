<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Museum Pusaka Karo</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-red: #B91C1C; 
            --primary-red-hover: #991B1B;
            --bg-color: #f8f9fa; /* Lighter background like wireframe */
            --sidebar-bg: #ffffff;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --border-color: #e5e7eb;
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar-logo-container {
            width: 80px;
            height: 80px;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .sidebar-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .sidebar-logo-placeholder {
            color: #9ca3af;
            font-size: 24px;
        }

        .sidebar-logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-dark);
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .sidebar-subtitle {
            font-size: 9px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.4;
        }

        .nav-menu {
            list-style: none;
            padding: 15px 0;
            flex: 1;
        }

        .nav-item {
            margin-bottom: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link i {
            width: 24px;
            margin-right: 10px;
            color: var(--text-gray);
            font-size: 16px;
            text-align: center;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #fef2f2;
            color: var(--primary-red);
            border-right: 3px solid var(--primary-red);
        }

        .nav-link:hover i, .nav-link.active i {
            color: var(--primary-red);
        }

        .sidebar-footer {
            padding: 15px 25px;
            border-top: 1px solid var(--border-color);
        }
        
        .btn-logout {
            display: flex;
            align-items: center;
            width: 100%;
            background: none;
            border: none;
            color: var(--text-gray);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            padding: 10px 0;
            transition: color 0.2s;
        }
        
        .btn-logout i {
            width: 24px;
            margin-right: 10px;
            font-size: 16px;
        }

        .btn-logout:hover {
            color: var(--primary-red);
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-width));
        }

        /* Top Header */
        .top-header {
            height: var(--header-height);
            background-color: var(--sidebar-bg);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
        }

        .header-title h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-name {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-gray);
        }

        .avatar {
            width: 32px;
            height: 32px;
            background-color: #e5e7eb;
            color: var(--text-gray);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        /* Content Area */
        .content-area {
            padding: 40px;
            flex: 1;
        }

        /* Utility Classes */
        .card {
            background-color: var(--sidebar-bg);
            border-radius: 6px;
            border: 1px solid var(--border-color);
            box-shadow: none;
            padding: 30px;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <!-- Logo area matching wireframe -->
            <div class="sidebar-logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="sidebar-logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <i class="fa-regular fa-image sidebar-logo-placeholder" style="display: none;"></i>
            </div>
            
            <div class="sidebar-logo-text">MUSEUM PUSAKA KARO</div>
            <div class="sidebar-subtitle">SISTEM INFORMASI WARISAN<br>BUDAYA</div>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group"></i> Kategori Budaya
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('warisan.index') }}" class="nav-link {{ request()->routeIs('warisan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open"></i> Warisan Budaya
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('media.index') }}" class="nav-link {{ request()->routeIs('media.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-images"></i> Media Dokumentasi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('komentar.index') }}" class="nav-link {{ request()->routeIs('komentar.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-comments"></i> Komentar
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-title">
                <h2>@yield('header_title', 'Dashboard')</h2>
            </div>
            
            <div class="header-actions">
                <div class="admin-profile">
                    <span class="admin-name">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</span>
                    <div class="avatar">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content -->
        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>
