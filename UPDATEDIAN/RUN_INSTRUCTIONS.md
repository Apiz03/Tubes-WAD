# Cara Menjalankan Aplikasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi Canteen System:

## 1. Pastikan Database Aktif
1.  Buka **XAMPP Control Panel**.
2.  Klik **Start** pada bagian **MySQL** dan **Apache**.
3.  Pastikan Anda sudah membuat database kosong bernama `tubes_wad1` di phpMyAdmin (biasanya di `http://localhost/phpmyadmin`).

## 2. Setup Database (Sekali Saja / Jika Reset)
Karena sebelumnya gagal koneksi, jalankan perintah ini di terminal untuk mengisi database:
```bash
php artisan migrate:fresh --seed
```

## 3. Jalankan Aplikasi
Anda perlu menjalankan dua perintah di **dua terminal berbeda**:

**Terminal 1 (Server Laravel):**
```bash
php artisan serve
```

**Terminal 2 (Asset Compiler - Agar tampilan bagus):**
```bash
npm run dev
```

## 4. Akses Aplikasi
Buka browser dan kunjungi:
[http://127.0.0.1:8000](http://127.0.0.1:8000)

**Login Admin:**
-   **Email:** `admin1@gmail.com`
-   **Password:** `admin1`
