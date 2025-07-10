# Aplikasi Pemesanan Kendaraan - Tambang Nikel

## 👤 User Login

| Role     | email                 | Password  |
|----------|-----------------------|-----------|
| Admin    | admin@vechile.app     | password  |
| Approver | approval@vechile.app  | password  |
| Reviewer | reviewer@vechile.app  | password  |
| driver | driver1@vechile.app     | password  |
| driver | driver2@vechile.app     | password  |

## 💾 Tech Stack
- PHP 8.4
- Laravel 12
- PostgreSQL / MySQL
- Laravel Excel
- Boostrap CSS

## 📚 Panduan Penggunaan
1. Login sebagai Admin → Buat Pemesanan/booking
2. Reviewer  → reviewer
3. Approver → approver
4. Driver → klik nama kendaraan untuk melakukan activity
5. Lihat riwayat dan export laporan dari menu "Laporan"

## Table of Contents

- [Setup](#setup)
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
php artisan serve --port=8000
```


