# Requirement Document — Sistem Manajemen Perpustakaan

**Versi:** 1.0
**Status:** Draft — Tahap Analisis
**Terakhir diperbarui:** Agustus 2026

---

## 1. Latar Belakang & Tujuan

### 1.1 Masalah yang Diselesaikan
Perpustakaan (sekolah/kampus kecil-menengah) masih mencatat peminjaman buku secara manual atau menggunakan Excel, sehingga rawan data hilang, sulit melacak keterlambatan pengembalian, dan sulit membuat laporan.

### 1.2 Tujuan Aplikasi
- Mendigitalisasi proses pencatatan buku, anggota, dan transaksi peminjaman/pengembalian.
- Memudahkan pustakawan memantau stok buku dan keterlambatan.
- Memudahkan anggota mencari ketersediaan buku tanpa harus datang langsung.

### 1.3 Skala Proyek (Asumsi Kerja)
- Skala: perpustakaan sekolah/kampus kecil-menengah, cabang tunggal.
- Denda keterlambatan dihitung otomatis oleh sistem; pembayaran dicatat manual oleh admin (tidak ada integrasi payment gateway pada versi MVP).
- Tidak ada fitur reservasi antar-cabang.

---

## 2. User / Role Sistem

| Role | Deskripsi | Hak Akses Utama |
|---|---|---|
| **Admin/Pustakawan** | Mengelola data buku, anggota, transaksi | CRUD buku, kelola peminjaman, lihat laporan |
| **Anggota (Member)** | Pengguna yang meminjam buku | Lihat katalog, cek status pinjaman, riwayat pinjam |

> Superadmin dan role tambahan lain sengaja tidak dimasukkan di MVP — dapat ditambahkan sebagai iterasi berikutnya setelah role inti stabil.

---

## 3. Daftar Fitur

### 3.1 Fitur Utama (Must-Have)

**Autentikasi & Otorisasi**
- Login/logout untuk Admin dan Anggota
- Role-based access control

**Manajemen Buku (Admin)**
- CRUD data buku (judul, penulis, kategori, ISBN, stok, cover gambar)
- Kategori/genre buku

**Manajemen Anggota (Admin)**
- CRUD data anggota

**Transaksi Peminjaman**
- Pinjam buku (mengurangi stok)
- Kembalikan buku (menambah stok)
- Deteksi keterlambatan otomatis
- Perhitungan denda otomatis

**Pencarian & Filter**
- Cari buku berdasarkan judul/penulis/kategori
- Filter status ketersediaan

**Dashboard**
- Admin: total buku, total anggota, buku sedang dipinjam, keterlambatan aktif
- Anggota: buku sedang dipinjam, riwayat, denda (jika ada)

### 3.2 Fitur Tambahan (Nice-to-Have)
- Export laporan ke PDF/Excel
- Notifikasi email mendekati jatuh tempo
- Rating/review buku oleh anggota
- Log aktivitas admin (audit trail)
- Reservasi buku saat stok kosong

---

## 4. Functional Requirements

| ID | Deskripsi |
|---|---|
| FR-01 | Sistem harus memungkinkan admin login menggunakan email & password |
| FR-02 | Sistem harus memungkinkan admin menambah, mengubah, menghapus data buku |
| FR-03 | Sistem harus mencegah peminjaman jika stok buku = 0 |
| FR-04 | Sistem harus menghitung denda otomatis berdasarkan selisih hari dari tanggal jatuh tempo |
| FR-05 | Sistem harus mencatat tanggal pinjam, tanggal jatuh tempo, dan tanggal kembali aktual pada setiap transaksi |
| FR-06 | Anggota hanya dapat melihat data miliknya sendiri, tidak bisa mengakses data anggota lain |
| FR-07 | Sistem harus menampilkan status ketersediaan buku secara real-time berdasarkan stok |

*(Daftar ini akan bertambah seiring detail desain — setiap requirement baru mengikuti format ID berurutan agar mudah ditelusuri saat testing.)*

---

## 5. Non-Functional Requirements

| Aspek | Requirement |
|---|---|
| **Usability** | Antarmuka harus sederhana, dapat digunakan admin non-teknis |
| **Security** | Password harus di-hash; validasi input dilakukan di sisi server |
| **Performance** | Pencarian buku harus responsif untuk data hingga ±1000 judul |
| **Maintainability** | Kode mengikuti struktur MVC Laravel standar |
| **Portability** | Dapat dijalankan di lingkungan local (Laragon) dan di-deploy ke hosting/VPS |

---

## 6. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal dibuat | Hasil sesi analisis kebutuhan tahap 1 |

---

## Catatan
Dokumen ini adalah rujukan resmi untuk tahap perancangan berikutnya (ERD, wireframe, user flow). Setiap perubahan scope proyek sebaiknya dicatat di bagian **Riwayat Perubahan** di atas, bukan langsung diubah tanpa jejak — ini membantu menjelaskan *kenapa* sebuah keputusan diambil saat proyek direview di kemudian hari (misalnya saat wawancara kerja).
