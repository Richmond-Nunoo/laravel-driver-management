<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

# 🚚 Driver Registration System – Laravel Project

A lightweight Driver Registration & Admin Dashboard system built with Laravel. Designed and developed as a 24-hour MVP to quickly manage driver registrations, including document uploads, email confirmations, and admin review/export.

---

## 🌐 Live Demo

- **Driver Registration:** [https://driver.qredisave.com](https://driver.qredisave.com)
- **Admin Login:** [https://driver.qredisave.com/admin/login](https://driver.qredisave.com/admin/login)

---

## 👨‍✈️ Driver Features

- Clean, mobile-friendly UI
- Driver registration with:
  - Full name
  - Email (must be unique)
  - Phone (10 digits)
  - Truck type
  - Document upload (PDF, JPG, PNG)
- Email confirmation after submission
- Check registration status via phone/email
- Driver dashboard confirmation view

---

## 🛡️ Admin Features

- Dedicated admin login via `/admin/login`
- View all registered drivers in dashboard
- Export drivers list to PDF
- Protected admin routes using custom guard

---

## 🔐 Default Admin Login (for testing)

- Email: admin@example.com Password: password123


> ⚠️ Please change these credentials before deploying to production.

---

## 🚀 Getting Started Locally

### 1. Clone the Repository

```bash
git clone https://github.com/Richmond-Nunoo/laravel-driver-management.git
cd driver-management


2. Install Dependencies
composer install
npm install && npm run dev


3. Environment Setup
cp .env.example .env
php artisan key:generate

4. Run Migrations & Seed Default Admin
php artisan migrate --seed

5. Start Development Server
php artisan serve


Local Driver URL: http://127.0.0.1:8000

Local Admin URL: http://127.0.0.1:8000/admin/login


📸 Screenshots


🛠️ Tech Stack
Laravel 10.x

Bootstrap 5 (UI)

DomPDF (PDF export)

Laravel Mail (for confirmation)

📁 Folder Structure
app/
 ├── Http/Controllers/
 │    ├── DriverController.php
 │    └── Admin/
 │         └── AuthController.php
 ├── Models/
 │    ├── Driver.php
 │    └── Admin.php
resources/views/
 ├── index.blade.php
 ├── drivers/
 └── admin/
 
🤝 Contributing
Pull requests are welcome!
For major changes, please open an issue first to discuss what you'd like to contribute.
