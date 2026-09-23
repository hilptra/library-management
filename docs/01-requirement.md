# Requirement Document — Sistem Manajemen Perpustakaan

**Versi:** 1.2  
**Status:** Terimplementasi — Tahap Pengembangan Selesai  
**Terakhir diperbarui:** September 2026  

---

## 1. Latar Belakang & Tujuan

### 1.1 Masalah yang Diselesaikan
Perpustakaan (sekolah/kampus kecil-menengah) masih mencatat peminjaman buku secara manual atau menggunakan Excel, sehingga rawan data hilang, sulit melacak keterlambatan pengembalian, dan sulit membuat laporan.

### 1.2 Tujuan Aplikasi
- Mendigitalisasi proses pencatatan buku, anggota, dan transaksi peminjaman/pengembalian.
- Memudahkan pustakawan memantau stok buku, pengajuan pinjaman, ulasan pembaca, dan keterlambatan.
- Memudahkan anggota mencari ketersediaan buku, mengumpulkan buku ke daftar keinginan (*wishlist*), memberi ulasan & rating, menguji batas peminjaman, serta memiliki Kartu Anggota Digital ber-QR Code.

### 1.3 Skala Proyek (Asumsi Kerja)
- Skala: perpustakaan sekolah/kampus kecil-menengah, cabang tunggal.
- Denda keterlambatan dihitung otomatis oleh sistem berdasarkan tanggal jatuh tempo dan konfigurasi denda harian; pembayaran dicatat manual oleh admin.
- Pengaturan durasi pinjam standar, denda per hari, dan batas peminjaman aktif dapat disesuaikan oleh Admin via menu Settings dan tersambung secara dinamis ke beranda member.
- Fitur Ulasan & Rating tersedia bagi member yang pernah meminjam dan mengembalikan buku terkait.

---

## 2. User / Role Sistem

| Role | Deskripsi | Hak Akses Utama |
|---|---|---|
| **Admin/Pustakawan** | Mengelola data buku, anggota, transaksi, ulasan pembaca, dan pengaturan sistem | CRUD buku/kategori, kelola peminjaman (approve/reject/return), suspen anggota, pantau ulasan pembaca, kelola settings, ekspor laporan CSV |
| **Anggota (Member)** | Pengguna yang meminjam buku | Lihat katalog (Card Grid), ajukan/batalkan peminjaman, kelola wishlist, beri/update rating & ulasan buku, lihat notifikasi, lihat Kartu Anggota Digital & QR Code ID |

> Catatan: Pengguna bertipe `admin` dan `member` memiliki status akun (`active` | `suspended`). Pengguna berstatus `suspended` ditolak aksesnya saat login.

---

## 3. Daftar Fitur

### 3.1 Fitur Utama (Must-Have)

**Autentikasi & Otorisasi**
- Login/logout untuk Admin dan Anggota (Hand-rolled auth).
- Role-based access control (RBAC) via custom middleware `EnsureUserHasRole` & `EnsureUserIsActive`.
- Proteksi akun suspended saat login.

**Beranda Member Interaktif**
- Ringkasan peminjaman aktif dengan hitung mundur sisa hari pengembalian (*"Sisa X Hari Lagi"*, *"Jatuh Tempo Hari Ini!"*, *"Terlambat X Hari!"*).
- Akses Cepat (*Quick Actions*) ke Katalog, Peminjaman, Wishlist, dan Profil.
- Kartu informasi & aturan sirkulasi perpustakaan yang terhubung secara **dinamis** dengan konfigurasi Admin.
- Etalase buku terbaru dan pratinjau daftar keinginan (*Wishlist*).

**Manajemen Buku & Kategori (Admin)**
- CRUD data buku (judul, penulis, ISBN, penerbit, tahun terbit, sinopsis, cover gambar).
- Manajemen eksemplar fisik buku (`book_copies`) dengan status real-time (`available`, `reserved`, `borrowed`, `damaged`, `lost`).
- Manajemen kategori/genre buku (relasi Many-to-Many via `book_category`).

**Katalog Buku & Wishlist (Anggota)**
- Tampilan *Card Grid* responsif (seragam dengan halaman Wishlist) dilengkapi badge stok eksemplar, tombol wishlist melayang, indikator rating bintang, dan tombol aksi ("Detail" & "Pinjam").
- Manajemen Daftar Keinginan (*Wishlist*): simpan buku favorit dari katalog untuk diajukan peminjaman cepat.

**Ulasan & Rating Buku**
- Anggota yang pernah meminjam & mengembalikan buku dapat memberikan/memperbarui rating (1-5 bintang) dan komentar ulasan.
- Komponen bintang rating (`partials/star-display`) menampilkan skor rata-rata numerik dan jumlah ulasan di seluruh kartu katalog dan detail buku.
- Admin dapat melihat daftar lengkap ulasan dan rating pembaca pada setiap halaman detail buku admin (`/admin/books/{id}`).

**Pusat Notifikasi & Lonceng Navbar**
- Notifikasi real-time persetujuan/penolakan peminjaman.
- Notifikasi pengembalian buku yang secara otomatis mengajak member memberikan rating/ulasan, dengan navigasi langsung ke detail ulasan buku.

**Transaksi Peminjaman & Pengembalian**
- Pengajuan pinjam oleh Anggota (self-service; mengunci eksemplar ke status `reserved`).
- Pembatalan pengajuan pinjam oleh Anggota saat status masih `pending`.
- Persetujuan (*Approve*) atau Penolakan (*Reject*) transaksi oleh Admin.
- Pengembalian buku oleh Admin (menghitung keterlambatan & denda real-time).

**Kartu Anggota Digital & QR Code (Anggota)**
- Tampilan Kartu Anggota Digital interaktif pada halaman Profil Anggota.
- QR Code ID unik berbasis `PERPUS-ID-{user_id}` yang dihasilkan secara real-time untuk verifikasi saat kunjungan perpustakaan.

**Pengaturan Sistem & Laporan (Admin)**
- Pengaturan durasi peminjaman standar (hari), tarif denda per hari, dan batas maksimal pinjam aktif (`fine_per_day`, `loan_duration_days`, `max_active_loans`).
- Laporan riwayat transaksi peminjaman dengan filter rentang tanggal dan status.
- Ekspor laporan transaksi ke format file CSV.

---

## 4. Functional Requirements

| ID | Deskripsi |
|---|---|
| FR-01 | Sistem harus memungkinkan pengguna login menggunakan email & password sesuai role |
| FR-02 | Sistem harus menolak login pengguna yang berstatus `suspended` |
| FR-03 | Sistem harus memungkinkan admin melakukan CRUD pada data buku, eksemplar fisik, dan kategori |
| FR-04 | Sistem harus mencegah peminjaman jika tidak ada eksemplar berstatus `available` |
| FR-05 | Sistem harus mengalokasikan eksemplar ke status `reserved` saat anggota membuat pengajuan `pending` |
| FR-06 | Sistem harus memungkinkan anggota membatalkan pengajuan berstatus `pending` dan mengembalikan status eksemplar ke `available` |
| FR-07 | Sistem harus memungkinkan admin menyetujui (approve) atau menolak (reject) pengajuan pinjaman |
| FR-08 | Sistem harus menghitung denda otomatis berdasarkan selisih hari dari tanggal jatuh tempo dan tarif denda aktif saat pengembalian diproses |
| FR-09 | Sistem harus mencatat tanggal pinjam, tanggal jatuh tempo, dan tanggal kembali aktual pada setiap transaksi |
| FR-10 | Anggota hanya dapat melihat data peminjaman, wishlist, dan profil miliknya sendiri |
| FR-11 | Sistem harus menampilkan Kartu Anggota Digital ber-QR Code ID unik (`PERPUS-ID-{user_id}`) pada profil anggota |
| FR-12 | Sistem harus memungkinkan admin mengatur durasi pinjam standar, tarif denda harian, dan batas pinjam aktif via menu Settings |
| FR-13 | Sistem harus memungkinkan admin mengekspor laporan transaksi peminjaman ke file CSV |
| FR-14 | Sistem harus memuat ulasan & rating bintang bagi anggota yang pernah mengembalikan buku, serta menampilkan ulasan tersebut untuk Admin dan umum |
| FR-15 | Sistem harus memungkinkan anggota mengelola daftar keinginan (wishlist) buku |
| FR-16 | Sistem harus mengirim notifikasi pengembalian buku dan mengarahkan member langsung ke halaman ulasan saat notifikasi dibuka |

---

## 5. Non-Functional Requirements

| Aspek | Requirement |
|---|---|
| **Usability** | Antarmuka bersih & modern dengan Tailwind CSS v4, responsif untuk perangkat mobile & desktop dengan UI Card Grid |
| **Security** | Password di-hash menggunakan Laravel `hashed` cast; validasi server-side pada seluruh request; proteksi CSRF & rate-limiting |
| **Performance** | Eager loading rating average & review count (`withAvg`, `withCount`) untuk mencegah masalah N+1 query pada katalog |
| **Maintainability** | Kode mengikuti arsitektur Laravel 12 MVC standar, clean code & linting dengan Laravel Pint |
| **Portability** | Berjalan di lingkungan Laragon (MySQL) serta kompatibel dengan SQLite in-memory untuk pengujian unit |

---

## 6. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal dibuat | Hasil sesi analisis kebutuhan tahap 1 |
| September 2026 | Pembaharuan fitur: Kartu Anggota Digital QR Code, Cancel Loan, Settings Admin, Suspen Anggota, Ekspor CSV | Penyesuaian dengan implementasi sistem |
| September 2026 | Pembaharuan fitur lanjutan: Ulasan & Rating Buku, Wishlist, Redesign Katalog Card Grid, Beranda Member Interaktif dengan hitung mundur sisa hari, Notifikasi Pengembalian Buku, dan Peninjau Ulasan Admin | Penyesuaian fitur terbaru yang diimplementasikan pada aplikasi |
