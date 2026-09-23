# 📚 Sistem Manajemen Perpustakaan Kota

Aplikasi Sistem Manajemen Perpustakaan (*Library Management System*) berbasis web modern yang dibangun dengan **Laravel 12**, **Tailwind CSS v4**, **Alpine.js**, dan **MySQL**. Aplikasi ini menyediakan fitur lengkap untuk pengelolaan koleksi buku, sirkulasi peminjaman & pengembalian, kalkulasi denda otomatis, ulasan & rating pembaca, daftar keinginan (wishlist), kartu anggota digital ber-QR Code, serta dashboard statistik bagi Admin (Pustakawan) dan Anggota (*Member*).

---

## 🌟 Fitur Utama

### 👤 1. Area Anggota (Member)
- **Beranda Member Interaktif**:
  - Ringkasan peminjaman aktif beserta hitung mundur sisa batas waktu pengembalian (*"Sisa X Hari Lagi"*, *"Jatuh Tempo Hari Ini!"*, *"Terlambat X Hari!"*).
  - Akses cepat (*Quick Actions*) ke Katalog, Peminjaman, Wishlist, dan Profil.
  - Kartu informasi & aturan sirkulasi perpustakaan yang terhubung secara **dinamis** dengan konfigurasi Admin.
  - Etalase buku terbaru dan pratinjau daftar keinginan (*Wishlist*).
- **Katalog Buku & Pencarian**: Tampilan *Card Grid* responsif dilengkapi filter kategori, pencarian cepat, status stok eksemplar real-time, dan indikator rating bintang.
- **Daftar Keinginan (Wishlist)**: Simpan buku favorit untuk peminjaman cepat di kemudian hari.
- **Review & Rating Buku**: Member yang telah meminjam dan mengembalikan buku dapat memberikan rating (1-5 bintang) serta ulasan/komentar interaktif.
- **Pusat Notifikasi**: Notifikasi otomatis untuk persetujuan/penolakan pinjaman serta ajakan mengulas setelah pengembalian buku (langsung mengarah ke halaman ulasan buku).
- **Kartu Anggota Digital & QR Code ID**: Generasi QR Code ID unik berbasis `PERPUS-ID-{user_id}` untuk verifikasi identitas di lokasi perpustakaan.

### 🛡️ 2. Area Admin (Pustakawan)
- **Dashboard Admin**: Ringkasan statistik total buku, anggota aktif, buku sedang dipinjam, keterlambatan pengembalian, serta aktivitas transaksi terbaru.
- **Manajemen Buku & Eksemplar Fisik**: CRUD data buku (judul, penulis, ISBN, penerbit, tahun terbit, sinopsis, cover) & alokasi kode inventaris eksemplar fisik (`book_copies`).
- **Peninjau Ulasan Pembaca**: Admin dapat melihat detail semua rating & ulasan dari pembaca pada setiap halaman detail buku admin.
- **Kelola Transaksi Sirkulasi**: Persetujuan (*Approve*), Penolakan (*Reject*), dan Pengembalian (*Return*) buku dengan kalkulasi denda keterlambatan otomatis.
- **Manajemen Anggota**: Daftar anggota dan penangguhan akses akun (*Toggle Status Active / Suspended*).
- **Pengaturan Sistem (Settings)**: Pengaturan durasi standar peminjaman (hari), tarif denda keterlambatan per hari, dan batas maksimal buku aktif.
- **Laporan & Ekspor CSV**: Laporan riwayat transaksi dengan filter rentang tanggal dan status, serta ekspor file CSV.

---

## 🛠️ Teknologi yang Digunakan

- **Framework Backend**: [Laravel 12](https://laravel.com)
- **Frontend & Styling**: Tailwind CSS v4, Alpine.js
- **Database**: MySQL (Pengembangan / Laragon) & SQLite (Testing `:memory:`)
- **Fitur Tambahan**: Endroid QR Code v6, Hand-rolled Authentication & Custom Middleware RBAC

---

## 🚀 Panduan Instalasi & Penggunaan

### 1. Prasyarat Sistem
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database MySQL (Laragon / XAMPP)

### 2. Langkah Instalasi

1. **Clone repositori**:
   ```bash
   git clone https://github.com/hilptra/library-management.git
   cd library-management
   ```

2. **Install dependensi PHP & Node.js**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan pengaturan koneksi database MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=library_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi & Seeder Database**:
   ```bash
   php artisan migrate --seed
   ```

6. **Buat Symlink Storage Cover**:
   ```bash
   php artisan storage:link
   ```

---

## 🔑 Akun Demo (Default Seeders)

Setelah menjalankan `db:seed`, Anda dapat menggunakan akun pengujian berikut:

| Role | Email | Password | Hak Akses |
|---|---|---|---|
| **Admin** | `admin@example.com` | `admin123` | Pengelolaan penuh data buku, transaksi, anggota, dan pengaturan |
| **Member** | `member@gmail.com` | `password` | Katalog buku, peminjaman, wishlist, ulasan, & kartu anggota |

---

## 🏃 Menjalankan Aplikasi

Jalankan perintah berikut untuk memulai server pengembang (*artisan serve*, *vite*, *queue listener*, dan *pail* secara bersamaan):

```bash
composer run dev
```

Buka peramban web dan akses: `http://127.0.0.1:8000`

---

## 🧪 Pengujian Unit & Fitur

Untuk menjalankan suite pengujian otomatis:

```bash
composer test
```

---

## 📂 Dokumentasi Proyek (`docs/`)

Dokumentasi rancangan & spesifikasi sistem lengkap dapat diakses pada direktori `docs/`:
- [`docs/01-requirement.md`](docs/01-requirement.md): Kebutuhan Fungsional & Non-Fungsional Sistem
- [`docs/02-erd.md`](docs/02-erd.md): Entity Relationship Diagram & Schema Tabel Database
- [`docs/03-sitemap.md`](docs/03-sitemap.md): Struktur Navigasi Halaman & Route Map
- [`docs/04-userflow.md`](docs/04-userflow.md): Alur Kerja Pengguna (Admin & Member)

---

## 📜 Lisensi
Sistem Manajemen Perpustakaan ini dibuat untuk tujuan pengembangan dan berlisensi [MIT License](LICENSE).
