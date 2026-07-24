<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Museum Pusaka Karo</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Warna Merah Kustom sesuai permintaan */
            --primary-red: #B91C1C; 
            --primary-red-hover: #991B1B;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --border-color: #e5e7eb;
            --input-bg: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text-dark);
        }

        .login-container {
            background-color: var(--card-bg);
            width: 100%;
            max-width: 420px;
            padding: 50px 40px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .logo-placeholder {
            width: 70px;
            height: 70px;
            border: 1px solid var(--text-dark);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
            color: var(--text-dark);
        }

        .subtitle {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-gray);
            margin-bottom: 35px;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            text-align: center;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--text-dark);
        }

        .divider:not(:empty)::before {
            margin-right: 15px;
        }

        .divider:not(:empty)::after {
            margin-left: 15px;
        }

        .form-group {
            position: relative;
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: var(--input-bg);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-red);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-red); /* Warna merah kustom */
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
            margin-top: 15px;
        }

        .btn-login:hover {
            background-color: var(--primary-red-hover);
        }
        
        .btn-login:active {
            transform: scale(0.98);
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: left;
            border: 1px solid #f87171;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Logo -->
        <div style="margin-bottom: 20px;">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Museum" style="width: 80px; height: auto;">
        </div>

        <!-- Typography -->
        <h1 class="title">MUSEUM PUSAKA KARO</h1>
        <p class="subtitle">Sistem Informasi Warisan Budaya Karo</p>

        <!-- Divider with Text -->
        <div class="divider">LOGIN ADMIN</div>

        <!-- Alert for Validation Errors -->
        @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <i class="fa-regular fa-envelope"></i>
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
        </form>
    </div>

</body>
</html>
