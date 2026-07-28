# 📌 Precision Tasker

**Precision Tasker** adalah aplikasi web manajemen tugas (task management) yang dibangun khusus untuk membantu mahasiswa/pelajar mengelola tugas kuliah dan deadline dengan lebih rapi. Aplikasi ini dibangun menggunakan **Laravel 13**, **Alpine.js**, dan **Tailwind CSS**, serta mendukung **Progressive Web App (PWA)** dengan notifikasi push, sehingga bisa digunakan secara offline dan menerima pengingat langsung di perangkat.

---

## ✨ Fitur Utama

- **🔐 Autentikasi** — Login & registrasi dengan username atau email.
- **📊 Dashboard** — Ringkasan progres tugas (total, selesai, pending), tugas dengan deadline terdekat, tugas prioritas tinggi, serta grafik produktivitas mingguan (Chart.js).
- **✅ Manajemen Tugas (Tasks)**
  - Tambah, ubah, hapus, dan tandai tugas sebagai selesai.
  - Atur prioritas tugas: `Low`, `Medium`, `High`.
  - Atur deadline dan deskripsi tugas.
  - Filter tugas berdasarkan mata kuliah (course).
  - Urutkan tugas berdasarkan deadline atau prioritas.
- **📚 Manajemen Mata Kuliah (Courses)** — Kelompokkan tugas berdasarkan mata kuliah, lengkap dengan kode dan ikon.
- **🗄️ Arsip Tugas** — Tugas yang sudah selesai otomatis masuk ke arsip, dikelompokkan menjadi *baru selesai* (≤7 hari), *bulan lalu* (≤30 hari), dan *lebih lama*. Tugas juga dapat dipulihkan (restore) ke status pending, dan tersedia statistik penyelesaian tugas per mata kuliah.
- **🔔 Push Notification** — Dukungan notifikasi push berbasis Web Push (VAPID) untuk mengingatkan tugas.
- **🌐 Multi-bahasa** — Tersedia dalam Bahasa Inggris (`en`) dan Bahasa Indonesia (`id`).
- **📱 PWA & Offline Support** — Dapat di-*install* ke perangkat (mobile/desktop) dan memiliki halaman fallback saat offline (service worker).

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | [Laravel 13](https://laravel.com) (PHP 8.3+) |
| Frontend | Blade Templates, [Alpine.js](https://alpinejs.dev), [Tailwind CSS](https://tailwindcss.com) |
| Build Tool | [Vite](https://vitejs.dev) |
| Grafik | [Chart.js](https://www.chartjs.org) |
| Notifikasi | [laravel-notification-channels/webpush](https://github.com/laravel-notification-channels/webpush) |
| Database | SQLite (default), dapat dikonfigurasi ke MySQL/PostgreSQL |
| PWA | Web App Manifest + Service Worker |

---

## 📂 Struktur Proyek (Ringkas)

```
app/
├── Http/Controllers/
│   ├── AuthController.php       # Login, registrasi, logout
│   ├── DashboardController.php  # Ringkasan & statistik
│   ├── TaskController.php       # CRUD tugas
│   ├── CourseController.php     # CRUD mata kuliah
│   ├── ArchiveController.php    # Arsip tugas selesai
│   └── PushController.php       # Langganan push notification
├── Models/
│   ├── User.php
│   ├── Task.php
│   └── Course.php
└── Notifications/
    └── TestNotif.php

database/migrations/     # Skema tabel users, courses, tasks, push_subscriptions
resources/views/         # Tampilan Blade (dashboard, tasks, courses, archive, auth)
routes/web.php           # Definisi routing
lang/en, lang/id          # Berkas terjemahan
```

---

## 🗃️ Skema Data Inti

- **User** — memiliki banyak `Course` dan `Task`.
- **Course** — `name`, `code`, `icon_string`, milik satu `User`, memiliki banyak `Task`.
- **Task** — `title`, `description`, `priority` (Low/Medium/High), `deadline`, `status_task` (Pending/Completed), `completed_at`, terhubung ke `User` dan (opsional) `Course`.

---

## 🚀 Instalasi & Menjalankan Proyek

### Prasyarat
- PHP 8.3 atau lebih baru
- Composer
- Node.js & NPM
- Ekstensi PHP standar Laravel (mbstring, pdo_sqlite, dll.)

### Langkah-langkah

1. **Clone repository**
   ```bash
   git clone https://github.com/Chandrafebriyanto/Precision-Tasker.git
   cd Precision-Tasker
   ```

2. **Install dependencies PHP & JavaScript**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Secara default, aplikasi menggunakan database **SQLite**. Pastikan file database tersedia:
   ```bash
   touch database/database.sqlite
   ```
   Jika ingin menggunakan MySQL/PostgreSQL, sesuaikan variabel `DB_*` pada file `.env`.

4. **(Opsional) Konfigurasi Web Push Notification**
   Untuk mengaktifkan fitur notifikasi push, generate VAPID keys dan tambahkan ke `.env`:
   ```
   VAPID_SUBJECT=mailto:youremail@example.com
   VAPID_PUBLIC_KEY=
   VAPID_PRIVATE_KEY=
   ```

5. **Jalankan migrasi database**
   ```bash
   php artisan migrate
   ```

6. **Build asset front-end**
   ```bash
   npm run build
   # atau untuk mode pengembangan:
   npm run dev
   ```

7. **Jalankan server lokal**

   Gunakan script `dev` bawaan (menjalankan server, queue listener, log viewer, dan Vite secara bersamaan):
   ```bash
   composer dev
   ```
   Atau jalankan secara manual:
   ```bash
   php artisan serve
   ```

8. **Akses aplikasi**
   Buka browser dan kunjungi `http://localhost:8000` (atau sesuai `APP_URL`).

---

## 🧪 Menjalankan Test

```bash
composer test
```

---

## 🌍 Mengganti Bahasa

Aplikasi mendukung dua bahasa. Ganti bahasa melalui route berikut:

```
/lang/en   → Bahasa Inggris
/lang/id   → Bahasa Indonesia
```

---

## 📄 Lisensi

Proyek ini dibangun di atas framework [Laravel](https://laravel.com), yang dirilis di bawah lisensi [MIT](https://opensource.org/licenses/MIT).

---

## 🙌 Kontribusi

Kontribusi dalam bentuk *pull request* atau *issue* sangat terbuka. Silakan fork repository ini dan ajukan perubahan yang diinginkan.
