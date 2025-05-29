# DARIKITA Project

Proyek ini dibangun menggunakan [Laravel](https://laravel.com/), sebuah framework PHP untuk pengembangan aplikasi web yang elegan dan efisien.

## Persyaratan Sistem

Sebelum memulai instalasi, pastikan sistem Anda telah memenuhi persyaratan berikut:

-   PHP >= 8.2
-   Composer
-   MySQL
-   NPM

## Langkah Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek Laravel ini di lokal Anda:

### 1. Clone Repository

```bash
git clone https://github.com/Safarqwerty/darikita.git
cd darikita
```

### 2. Install Dependency

```bash
composer install
npm install
```

### 3. Copy File .env

```bash
cp .env.example .env
```

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Symlink

```bash
php artisan storage:link
```

### 6. Konfigurasi Database

Edit file .env dan sesuaikan pengaturan database:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 7. Jalankan migrasi

```bash
npm run dev
php artisan migrate
```

### 8. Jalankan server lokal

```bash
php artisan serve
```
