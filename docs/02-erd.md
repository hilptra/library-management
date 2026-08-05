# ERD — Sistem Manajemen Perpustakaan

**Versi:** 1.3
**Status:** Draft — Tahap Perancangan
**Terakhir diperbarui:** Agustus 2026

---

## 1. Daftar Entitas

| Entitas | Deskripsi |
|---|---|
| `users` | Data login Admin dan Anggota (dibedakan lewat kolom `role`) |
| `categories` | Kategori/genre buku |
| `books` | Data judul buku |
| `book_copies` | Data eksemplar fisik tiap judul buku |
| `book_category` | Tabel pivot relasi many-to-many antara `books` dan `categories` |
| `loans` | Transaksi peminjaman & pengembalian eksemplar buku |
| `reservations` | Pemesanan judul buku (fitur Nice-to-Have, disiapkan sejak awal) |

---

## 2. Struktur Tabel

### 2.1 `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| name | varchar | nama lengkap |
| email | varchar, unique | dipakai untuk login |
| password | varchar | di-hash otomatis oleh Laravel |
| role | enum('admin','member') | pembeda hak akses |
| phone | varchar, nullable | kontak |
| created_at, updated_at | timestamp | |

### 2.2 `categories`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| name | varchar | contoh: "Fiksi", "Sains" |
| created_at, updated_at | timestamp | |

### 2.3 `books`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| title | varchar | judul buku |
| author | varchar | nama penulis |
| isbn | varchar, unique | identitas unik terbitan |
| publisher | varchar, nullable | penerbit |
| published_year | year, nullable | tahun terbit |
| cover_image | varchar, nullable | path file gambar cover |
| description | text, nullable | sinopsis |
| created_at, updated_at | timestamp | |

*(Tidak ada kolom stok — ketersediaan dihitung dari status di `book_copies`.)*

### 2.4 `book_copies`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| book_id | bigint, FK → books.id | |
| inventory_code | varchar, unique | kode inventaris fisik |
| status | enum('available','reserved','borrowed','damaged','lost') | lihat penjelasan alur di bawah |
| created_at, updated_at | timestamp | |

**Alur status eksemplar:**
- `available` → bisa diajukan anggota
- `reserved` → sedang ada permintaan pinjam berstatus `pending` untuknya (dikunci sementara agar tidak diajukan anggota lain)
- `borrowed` → admin sudah approve, buku resmi berada di luar
- Kembali ke `available` jika admin reject permintaan, atau setelah admin memproses pengembalian
- `damaged` / `lost` → diubah manual oleh admin saat kondisi eksemplar berubah

### 2.5 `book_category` (pivot)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| book_id | bigint, FK → books.id | |
| category_id | bigint, FK → categories.id | |

### 2.6 `loans`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| user_id | bigint, FK → users.id | |
| book_copy_id | bigint, FK → book_copies.id | eksemplar spesifik yang dipinjam/diajukan |
| loan_date | date, nullable | diisi saat admin approve, bukan saat request |
| due_date | date, nullable | dihitung saat approval (loan_date + durasi pinjam) |
| return_date | date, nullable | null berarti masih dipinjam |
| fine_amount | decimal, default 0 | dihitung otomatis |
| status | enum('pending','borrowed','returned','rejected') | lihat alur status di bawah |
| created_at, updated_at | timestamp | |

**Alur status peminjaman (self-service dengan approval admin):**
```
pending → (admin approve) → borrowed → (admin proses kembali) → returned
pending → (admin reject)  → rejected
```
- `pending`: anggota mengajukan pinjam, `loan_date` & `due_date` masih kosong
- `borrowed`: admin approve, `loan_date` & `due_date` di-set saat itu juga
- `returned`: admin proses pengembalian, `return_date` diisi
- `rejected`: admin menolak permintaan (jejak riwayat tetap tersimpan, tidak dihapus)

> Status "telat" **tidak** disimpan sebagai nilai terpisah — dihitung real-time dari perbandingan `due_date` vs tanggal hari ini, selama status masih `borrowed` dan `return_date` kosong.

### 2.7 `reservations`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| user_id | bigint, FK → users.id | |
| book_id | bigint, FK → books.id | judul yang dipesan (bukan eksemplar spesifik) |
| reservation_date | date | |
| status | enum('waiting','fulfilled','cancelled') | |
| created_at, updated_at | timestamp | |

*(Belum dibangun fiturnya di MVP — tabel disiapkan untuk pengembangan lanjutan.)*

---

## 3. Relasi Antar Tabel

```
users        (1) ─────< (N) loans
users        (1) ─────< (N) reservations
book_copies  (1) ─────< (N) loans
books        (1) ─────< (N) book_copies
books        (1) ─────< (N) reservations
books        (N) ─────< book_category >───── (N) categories
```

---

## 4. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal: users, books, book_copies, categories, loans | Hasil sesi perancangan awal |
| Agustus 2026 | Revisi: books–categories jadi many-to-many via `book_category` | Requirement berubah — 1 buku bisa punya banyak kategori |
| Agustus 2026 | Revisi: kolom status di `loans` disederhanakan jadi 2 nilai | Status "telat" dipilih dihitung real-time, bukan disimpan |
| Agustus 2026 | Penambahan: tabel `reservations` | Menyiapkan struktur untuk fitur Nice-to-Have di masa depan |
| Agustus 2026 | Revisi: `loans.status` jadi 4 nilai (pending, borrowed, returned, rejected); `loan_date`/`due_date` jadi nullable | Peminjaman diubah jadi self-service dengan approval admin |
| Agustus 2026 | Revisi: tambah nilai `reserved` di `book_copies.status` | Ditemukan saat menyusun user flow — mencegah 2 anggota mengajukan eksemplar yang sama sebelum admin approve |