<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - Museum Pusaka Karo</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-red: #7A1B1B;
            --dark-red: #5C1010;
            --gold: #D4AF37;
            --cream: #Fdfbf7;
            --bg-color: #Fdfbf7;
            --surface-bg: #ffffff;
            --surface-light: #f8fafc;
            --border-color: #e2e8f0;
            --text-dark: #2d3748;
            --text-gray: #4a5568;
            --text-light: #f7fafc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-color);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        /* HEADER STYLES */
        header {
            background-color: var(--cream);
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: var(--primary-red);
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary-red);
            color: white;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            font-family: 'Playfair Display', serif;
        }
        
        .logo-text h1 {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
            color: var(--primary-red);
        }
        
        .logo-text p {
            font-size: 11px;
            font-weight: 500;
            color: var(--text-gray);
            letter-spacing: 0.5px;
        }
        
        /* PILL NAVIGATION (Like Image 2) */
        .nav-pill {
            background-color: var(--surface-light);
            border-radius: 50px;
            display: flex;
            align-items: center;
            padding: 5px;
        }
        
        .nav-link {
            text-decoration: none;
            color: var(--text-dark);
            font-size: 14px;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary-red);
        }
        
        .nav-link.active {
            background-color: var(--primary-red);
            color: white;
        }
        
        /* FOOTER (Like Image 1) */
        footer {
            background-color: var(--surface-bg);
            border-top: 1px solid var(--border-color);
            padding: 60px 5% 20px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1.5fr 1.5fr;
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 18px;
            color: var(--text-dark);
        }
        
        .footer-logo i {
            font-size: 24px;
        }
        
        .footer-desc {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 25px;
            line-height: 1.8;
            max-width: 300px;
        }
        
        .social-icons {
            display: flex;
            gap: 10px;
        }
        
        .social-icon {
            width: 36px;
            height: 36px;
            background-color: var(--text-dark);
            color: white;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .social-icon:hover {
            background-color: var(--primary-red);
        }
        
        .footer-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            color: var(--text-dark);
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            text-decoration: none;
            color: var(--text-gray);
            font-size: 14px;
            transition: color 0.2s;
        }
        
        .footer-links a:hover {
            color: var(--primary-red);
        }
        
        .contact-info li {
            display: flex;
            gap: 10px;
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 15px;
        }
        
        .contact-info i {
            margin-top: 3px;
            color: var(--text-dark);
        }
        
        .copyright {
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid #edf2f7;
            font-size: 13px;
            color: var(--text-gray);
        }
        
        /* Utility Classes */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header / Navbar -->
    <header>
        <a href="{{ route('home') }}" class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Museum Pusaka Karo" style="width: 45px; height: 45px; object-fit: contain;">
            <div class="logo-text">
                <h1>Sistem Informasi Warisan<br>Budaya Karo</h1>
                <p>Museum Pusaka Karo</p>
            </div>
        </a>
        
        <div class="nav-pill">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('katalog.index') }}" class="nav-link {{ request()->routeIs('katalog.*') ? 'active' : '' }}">Katalog Warisan</a>
            <a href="{{ route('peta.persebaran') }}" class="nav-link {{ request()->routeIs('peta.persebaran') ? 'active' : '' }}">Peta Persebaran</a>
            <a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang Kami</a>
            <a href="{{ route('login') }}" class="nav-link" style="padding: 10px 15px;"><i class="fa-solid fa-user"></i></a>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 35px; height: 35px; object-fit: contain;"> MUSEUM PUSAKA KARO
                    </div>
                    <p class="footer-desc">
                        Sistem informasi yang menyajikan data dan informasi warisan budaya Karo secara digital untuk melestarikan jejak leluhur agar tak lekang oleh zaman.
                    </p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="footer-title">Menu Utama</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('katalog.index') }}">Katalog Budaya</a></li>
                        <li><a href="{{ route('peta.persebaran') }}">Peta Persebaran</a></li>
                        <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="footer-title">Kontak Kami</h4>
                    <ul class="footer-links contact-info">
                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Jl. Perwira No. 3, Gundaling I, Berastagi, Kabupaten Karo, Sumatera Utara</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <span>(0628) 9123456</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            <span>info@museumpusaka.karo.go.id</span>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="footer-title">Informasi Legal</h4>
                    <ul class="footer-links">
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('login') }}">Login Administrator</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                &copy; {{ date('Y') }} Museum Pusaka Karo. All rights reserved. | Sistem Informasi Warisan Budaya.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
