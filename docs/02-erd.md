# ERD — Sistem Manajemen Perpustakaan

**Versi:** 1.4  
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
| `settings` | Konfigurasi parameter sistem (durasi peminjaman standar, tarif denda harian) |
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

*(Ketersediaan buku dihitung secara dinamik dari jumlah eksemplar berstatus `available` pada `book_copies`.)*

### 2.4 `book_copies`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| book_id | bigint, FK → books.id | Referensi ke judul buku (CASCADE delete) |
| inventory_code | varchar, unique | Kode unik inventaris fisik eksemplar |
| status | enum('available','reserved','borrowed','damaged','lost') | Status fisik / alokasi eksemplar |
| created_at, updated_at | timestamp | |

**Alur status eksemplar:**
- `available` → Siap diajukan oleh Anggota dari katalog.
- `reserved` → Dikunci sementara karena ada pengajuan pinjam berstatus `pending` dari Anggota.
- `borrowed` → Disetujui (approve) oleh Admin, buku resmi keluar dipinjam.
- Kembali ke `available` jika:
  - Admin menolak (`reject`) pengajuan pinjaman.
  - Anggota membatalkan (`cancel`) pengajuan pinjaman.
  - Admin memproses pengembalian (`return`) buku.
- `damaged` / `lost` → Diubah manual oleh Admin jika kondisi fisik buku rusak atau hilang.

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

**Alur status peminjaman:**
```
pending → (admin approve)   → borrowed → (admin proses kembali) → returned
pending → (admin reject)    → rejected
pending → (anggota cancel)  → cancelled
```
- `pending`: Anggota mengajukan pinjaman (`loan_date` & `due_date` masih null).
- `borrowed`: Admin menyetujui permintaan, `loan_date` dan `due_date` diisi otomatis.
- `returned`: Admin memproses pengembalian fisik, `return_date` diisi, denda dihitung jika `return_date > due_date`.
- `rejected`: Admin menolak pengajuan.
- `cancelled`: Anggota membatalkan pengajuan saat status masih `pending`.

> Catatan: Status keterlambatan **tidak** disimpan sebagai enum terpisah. Keterlambatan dan denda dihitung secara real-time berdasarkan selisih hari antara `due_date` dan tanggal hari ini (atau `return_date`) dikali nilai denda per hari dari tabel `settings`.

### 2.7 `settings`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| key | varchar, unique | Kunci konfigurasi (misal: `borrow_duration_days`, `fine_per_day`) |
| value | string | Nilai konfigurasi |
| created_at, updated_at | timestamp | |

### 2.8 `reservations`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | Auto increment |
| user_id | bigint, FK → users.id | |
| book_id | bigint, FK → books.id | |
| reservation_date | date | |
| status | enum('waiting','fulfilled','cancelled') | |
| created_at, updated_at | timestamp | |

*(Tabel disiapkan untuk pengembangan fitur reservasi di masa depan.)*

---

## 3. Relasi Antar Tabel

```
users        (1) ─────< (N) loans
users        (1) ─────< (N) reservations
book_copies  (1) ─────< (N) loans
books        (1) ─────< (N) book_copies
books        (1) ─────< (N) reservations
books        (N) ─────< book_category >───── (N) categories
settings     (Konfigurasi Sistem Standalone)
```

---

## 4. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal: users, books, book_copies, categories, loans | Perancangan awal |
| Agustus 2026 | Revisi: books–categories jadi Many-to-Many via `book_category` | Requirement 1 buku bisa punya banyak kategori |
| Agustus 2026 | Revisi: `loans.status` jadi 4 nilai (pending, borrowed, returned, rejected) | Alur peminjaman self-service dengan approval admin |
| Agustus 2026 | Revisi: status `reserved` di `book_copies` | Mencegah konflik pengajuan ganda pada eksemplar yang sama |
| September 2026 | Pembaharuan: Tambah status `suspended` pada `users.status`, status `cancelled` pada `loans.status`, dan tabel `settings` | Penyesuaian dengan fitur pembatalan pinjaman oleh anggota, suspen anggota, dan konfigurasi denda/durasi |