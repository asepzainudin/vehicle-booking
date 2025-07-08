# Aplikasi Pemesanan Kendaraan - Tambang Nikel

## 👤 User Login

| Role     | Username     | Password  |
|----------|--------------|-----------|
| Admin    | admin        | password  |
| Approver | approver     | password  |
| Reviewer | reviewer     | password  |

## 💾 Tech Stack
- PHP 8.4
- Laravel 12
- Postgresql
- Laravel Excel
- Boostrap CSS

## 📚 Panduan Penggunaan
1. Login sebagai Admin → Buat Pemesanan/booking
2. Approver → approver
3. Reviewer  → reviewer
4. Lihat riwayat dan export laporan dari menu "Laporan"

## Table of Contents

- [Setup](#setup)
- [Naming Conventions](#naming-conventions)
- [Migrations](#migrations)
- [General Notes](#general-notes)

## Setup

```bash
git clone https://github.com/asepzainudin/vehicle-booking.git

composer install

cp .env.example .env
# after that set up your .env

# generate new app key
php artisan key:generate

php artisan migrate
php artisan db:seed
```

then start your development server

```bash
php artisan serve
# with port
php artisan serve --port=8080
```
