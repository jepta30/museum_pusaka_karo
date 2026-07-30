<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Sistem Informasi Museum Pusaka Karo

Aplikasi web untuk pengelolaan data dan katalog warisan budaya pada Museum Pusaka Karo. Dibangun menggunakan Laravel 11.

## Cara Instalasi (Mencegah Error Login & Database)

Penting: **JANGAN** meng-import file `.sql` secara manual ke phpMyAdmin jika Anda meng-clone repositori ini. Gunakan fitur Migration dan Seeder bawaan Laravel agar semua konfigurasi (termasuk *password hashing*) berjalan dengan benar.

Ikuti langkah-langkah berikut secara berurutan:

1. **Clone Repositori**
   ```bash
   git clone <url-repositori-anda>
   cd museum_pusaka_karo
   ```

2. **Install Dependensi PHP & Node.js**
   ```bash
   composer install
   npm install
   ```

3. **Siapkan Konfigurasi Lingkungan (.env)**
   Copy file contoh konfigurasi menjadi file `.env` asli:
   ```bash
   cp .env.example .env
   ```
   Lalu buka file `.env` di teks editor, dan sesuaikan pengaturan database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**
   Langkah ini sangat penting agar fitur keamanan (termasuk sesi login) berfungsi:
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Buat Akun Admin**
   Jalankan perintah ini untuk membuat semua tabel otomatis beserta data defaultnya (termasuk akun Admin):
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(Perintah di atas akan mengeksekusi `AdminSeeder` yang membuat akun default)*

6. **Build Asset & Jalankan Server**
   ```bash
   npm run build
   php artisan serve
   ```

## Kredensial Akses Default

Setelah mengikuti langkah di atas, Anda bisa login ke halaman admin menggunakan:
- **Email:** `admin@museum.com`
- **Password:** `password123`
