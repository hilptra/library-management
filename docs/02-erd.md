# ERD — Sistem Manajemen Perpustakaan

**Versi:** 1.5  
**Status:** Terimplementasi  
**Terakhir diperbarui:** September 2026  

---

## 1. Daftar Entitas

| Entitas | Deskripsi |
|---|---|
| `users` | Data akun Admin dan Anggota (dibedakan lewat kolom `role` dan status `status`) |
| `categories` | Kategori/genre buku |
| `books` | Data judul buku |
| `book_copies` | Data eksemplar fisik tiap judul buku |
| `book_category` | Tabel pivot relasi Many-to-Many antara `books` dan `categories` |
| `loans` | Transaksi peminjaman, persetujuan, pembatalan & pengembalian eksemplar buku |
| `reviews` | Ulasan & rating bintang (1-5) dari anggota untuk judul buku |
| `wishlists` | Tabel pivot daftar keinginan (wishlist) favorit anggota |
| `notifications` | Notifikasi sistem & aktivitas transaksi pengguna (Laravel Database Notifications) |
| `settings` | Konfigurasi parameter sistem (durasi peminjaman standar, tarif denda harian, max pinjam) |
| `reservations` | Pemesanan judul buku (tabel disiapkan untuk pengembangan tingkat lanjut) |

---

## 2. Struktur Tabel

### 2.1 `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| name | varchar | Nama lengkap |
| email | varchar, unique | Alamat email (ID unik login) |
| password | varchar | Kata sandi di-hash oleh Laravel |
| role | enum('admin','member') | Pembeda hak akses role |
| status | enum('active','suspended') | Status akun (default: `active`; `suspended` menolak login) |
| phone | varchar, nullable | Nomor telepon / WhatsApp |
| created_at, updated_at | timestamp | Waktu pembuatan & pembaruan |

### 2.2 `categories`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| name | varchar | Nama kategori (contoh: "Fiksi", "Teknologi") |
| created_at, updated_at | timestamp | |

### 2.3 `books`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| title | varchar | Judul buku |
| author | varchar | Nama penulis |
| isbn | varchar, unique | Identitas unik terbitan (ISBN) |
| publisher | varchar, nullable | Nama penerbit |
| published_year | year, nullable | Tahun terbit |
| cover_image | varchar, nullable | Path file gambar cover di storage |
| description | text, nullable | Sinopsis / deskripsi singkat buku |
| created_at, updated_at | timestamp | |

*(Ketersediaan buku dihitung secara dinamik dari eksemplar berstatus `available` pada `book_copies`. Rata-rata rating dihitung dari tabel `reviews`.)*

### 2.4 `book_copies`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| book_id | bigint, FK → books.id | Referensi ke judul buku (CASCADE delete) |
| inventory_code | varchar, unique | Kode unik inventaris fisik eksemplar |
| status | enum('available','reserved','borrowed','damaged','lost') | Status fisik / alokasi eksemplar |
| created_at, updated_at | timestamp | |

### 2.5 `book_category` (Pivot)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| book_id | bigint, FK → books.id | Referensi buku (CASCADE delete) |
| category_id | bigint, FK → categories.id | Referensi kategori (CASCADE delete) |

### 2.6 `loans`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| user_id | bigint, FK → users.id | Referensi pengguna yang meminjam |
| book_copy_id | bigint, FK → book_copies.id | Referensi eksemplar spesifik |
| loan_date | date, nullable | Diisi tanggal saat Admin menyetujui (approve) |
| due_date | date, nullable | Dihitung saat approval (`loan_date` + durasi pinjam di `settings`) |
| return_date | date, nullable | Tanggal aktual pengembalian oleh Admin |
| fine_amount | decimal, default 0 | Nominal denda yang dihitung otomatis saat pengembalian |
| status | enum('pending','borrowed','returned','rejected','cancelled') | Status transaksi peminjaman |
| created_at, updated_at | timestamp | |

### 2.7 `reviews`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| user_id | bigint, FK → users.id | Referensi anggota pemberi ulasan |
| book_id | bigint, FK → books.id | Referensi buku yang diulas |
| rating | unsignedTinyInteger | Nilai rating 1 hingga 5 bintang |
| comment | text, nullable | Komentar atau ulasan bebas |
| created_at, updated_at | timestamp | |

### 2.8 `wishlists` (Pivot)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| user_id | bigint, FK → users.id | Referensi anggota |
| book_id | bigint, FK → books.id | Referensi buku |
| created_at, updated_at | timestamp | |

### 2.9 `notifications`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | char(36), PK | UUID Notifikasi |
| type | varchar | Class Notification (misal: `App\Notifications\LoanStatusChanged`) |
| notifiable_type, notifiable_id | varchar, bigint | Morph model (`App\Models\User`) |
| data | text / json | Data notifikasi (`title`, `message`, `action`, `book_id`, dsb) |
| read_at | timestamp, nullable | Waktu notifikasi dibaca |
| created_at, updated_at | timestamp | |

### 2.10 `settings`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| key | varchar, unique | Kunci konfigurasi (`loan_duration_days`, `fine_per_day`, `max_active_loans`) |
| value | string | Nilai konfigurasi |
| created_at, updated_at | timestamp | |

### 2.11 `reservations`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| user_id | bigint, FK → users.id | |
| book_id | bigint, FK → books.id | |
| reservation_date | date | |
| status | enum('waiting','fulfilled','cancelled') | |
| created_at, updated_at | timestamp | |

---

## 3. Relasi Antar Tabel

```
users        (1) ─────< (N) loans
users        (1) ─────< (N) reviews
users        (1) ─────< (N) reservations
users        (N) ─────< wishlists >───── (N) books
book_copies  (1) ─────< (N) loans
books        (1) ─────< (N) book_copies
books        (1) ─────< (N) reviews
books        (1) ─────< (N) reservations
books        (N) ─────< book_category >───── (N) categories
settings     (Konfigurasi Sistem Standalone)
notifications(Polymorphic MorphTo User)
```

---

## 4. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal: users, books, book_copies, categories, loans | Perancangan awal |
| Agustus 2026 | Revisi: books–categories jadi Many-to-Many via `book_category` | Requirement 1 buku bisa punya banyak kategori |
| September 2026 | Pembaharuan: Status `suspended`, `cancelled`, dan tabel `settings` | Penyesuaian fitur pembatalan, suspen, dan settings |
| September 2026 | Pembaharuan ERD: Tambah entitas `reviews`, `wishlists`, dan `notifications` | Penyesuaian dengan implementasi fitur ulasan/rating, wishlist, dan notifikasi |