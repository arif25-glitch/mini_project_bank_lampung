# 🏦 Aplikasi Mini Project Bank Lampung

![Logo Bank Lampung](https://via.placeholder.com/200x100?text=Logo+Bank+Lampung)

[![React](https://img.shields.io/badge/React-61DAFB?style=for-the-badge&logo=react&logoColor=black)](https://reactjs.org/)
[![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Redux](https://img.shields.io/badge/Redux-764ABC?style=for-the-badge&logo=redux&logoColor=white)](https://redux.js.org/)

## 📝 Deskripsi Proyek

Mini Project Aplikasi Bank Lampung adalah sistem fullstack yang menggabungkan backend Laravel dengan frontend React untuk pengelolaan pengguna dan integrasi API cuaca. Proyek ini mencakup sistem autentikasi, manajemen pengguna, dan akses data cuaca berdasarkan lokasi pengguna.

### ⏱️ Durasi Pengerjaan
**5 Hari Setelah Email diterima**

## 🛠️ Tech Stack

### Frontend
- **React** - Library JavaScript untuk membangun antarmuka pengguna
- **Vite** - Build tool yang cepat untuk pengembangan modern
- **Tailwind CSS** - Framework CSS utility-first
- **Framer Motion** - Library animasi untuk React
- **Redux** - State management library

### Backend
- **Laravel** - PHP framework untuk backend
- **MySQL** - Database relational
- **Laravel Sanctum** - Autentikasi berbasis token

## ✨ Fitur Utama

### 🔐 Autentikasi & Otorisasi
- Registrasi dan login pengguna
- Autentikasi berbasis token dengan Laravel Sanctum
- Manajemen peran (admin dan user biasa)

### 👥 Manajemen Pengguna
- CRUD operasi untuk pengguna
- Profil pengguna dengan informasi lengkap
- Akses terbatas berdasarkan peran

### 🌤️ Integrasi Cuaca
- Informasi cuaca real-time dari OpenWeatherMap API
- Penyimpanan data cuaca untuk mengurangi API requests
- Tampilan visual kondisi cuaca

## 📋 Persyaratan Proyek

### 1. Setup Backend dan Koneksi ke Database
- Konfigurasi koneksi database menggunakan MySQL
- Tabel users dengan kolom id, name, email, password, dan role
- Tabel info pengguna untuk menyimpan data nama lengkap, tanggal lahir, alamat tempat tinggal

### 2. Autentikasi dan Otorisasi
- Implementasi autentikasi menggunakan Laravel Sanctum
- Pengaturan akses endpoint berdasarkan status autentikasi
- Middleware untuk memastikan hanya admin yang dapat mengubah data pengguna

### 3. Manajemen Data Pengguna
- Implementasi CRUD untuk entitas pengguna
- Endpoint:
  - `POST /api/register` - untuk mendaftarkan pengguna baru
  - `POST /api/login` - untuk proses login
  - `POST /api/logout` - untuk logout
  - `GET /api/users` - daftar semua pengguna (hanya admin)
  - `POST /api/users` - membuat pengguna baru
  - `GET /api/users/{id}` - detail pengguna tertentu
  - `PUT /api/users/{id}` - update data pengguna tertentu
  - `DELETE /api/users/{id}` - hapus pengguna tertentu (hanya admin)
  - `POST /api/users/{id}/info` - membuat atau update info pengguna
  - `GET /api/users/{id}/info` - mendapatkan info pengguna

### 4. Tampilan Halaman dan Manajemen
- Halaman Login dan Registrasi
- Penyimpanan token autentikasi setelah login
- Penggunaan Axios untuk komunikasi dengan backend
- Tampilan manajemen pengguna

### 5. Integrasi API Cuaca
- Integrasi dengan OpenWeatherMap API
- Endpoint:
  - `POST /api/weather` - mendapatkan data cuaca
  - `GET /api/weather/{city}` - mendapatkan data cuaca berdasarkan nama kota
- Penyimpanan hasil API di database
- Tampilan kondisi cuaca

### 6. Keamanan dan Optimasi
- Rate Limiting untuk membatasi request ke API cuaca
- Enkripsi password dengan bcrypt
- Validasi input pada semua request
- Skeleton Loading atau Spinner saat memuat data
- Implementasi Lazy Loading untuk performa aplikasi

## 🚀 Instalasi & Pengaturan

### Backend (Laravel)
```bash
# Clone repositori
git clone https://github.com/username/bank-lampung-project.git

# Pindah ke direktori backend
cd bank-lampung-project/backend

# Instal dependensi
composer install

# Salin file .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Jalankan server development
php artisan serve
```

### Frontend (React + Vite)
```bash
# Pindah ke direktori frontend
cd ../frontend

# Instal dependensi
npm install

# Jalankan server development
npm run dev
```

### Akun Demo
Berikut adalah kredensial yang tersedia untuk testing:

| Peran | Email | Password |
|-------|-------|----------|
| Admin | admin@admin.com | admin123 |
| User | test@test.com | testuser123 |

## 📸 Screenshot

### Halaman Login
![Halaman Login](https://via.placeholder.com/800x400?text=Halaman+Login)

### Dashboard Admin
![Dashboard Admin](https://via.placeholder.com/800x400?text=Dashboard+Admin)

### Informasi Cuaca
![Informasi Cuaca](https://via.placeholder.com/800x400?text=Informasi+Cuaca)

## 🤝 Kontributor
- [Arif Nur Listanto](https://github.com/arif25-glitch) - Developer

## 📄 Lisensi
Hak Cipta © 2025 Bank Lampung. Seluruh hak dilindungi.
