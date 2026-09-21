# Requirement Document — Sistem Manajemen Perpustakaan

**Versi:** 1.1  
**Status:** Terimplementasi — Tahap Pengembangan Selesai  
**Terakhir diperbarui:** September 2026  

---

## 1. Latar Belakang & Tujuan

### 1.1 Masalah yang Diselesaikan
Perpustakaan (sekolah/kampus kecil-menengah) masih mencatat peminjaman buku secara manual atau menggunakan Excel, sehingga rawan data hilang, sulit melacak keterlambatan pengembalian, dan sulit membuat laporan.

### 1.2 Tujuan Aplikasi
- Mendigitalisasi proses pencatatan buku, anggota, dan transaksi peminjaman/pengembalian.
- Memudahkan pustakawan memantau stok buku, pengajuan pinjaman, dan keterlambatan.
- Memudahkan anggota mencari ketersediaan buku, mengajukan peminjaman, serta memiliki Kartu Anggota Digital ber-QR Code.

### 1.3 Skala Proyek (Asumsi Kerja)
- Skala: perpustakaan sekolah/kampus kecil-menengah, cabang tunggal.
- Denda keterlambatan dihitung otomatis oleh sistem berdasarkan tanggal jatuh tempo dan konfigurasi denda harian; pembayaran dicatat manual oleh admin.
- Pengaturan durasi pinjam standar dan denda per hari dapat disesuaikan oleh Admin via menu Settings.
- Tidak ada fitur reservasi antar-cabang.

---

## 2. User / Role Sistem

| Role | Deskripsi | Hak Akses Utama |
|---|---|---|
| **Admin/Pustakawan** | Mengelola data buku, anggota, transaksi, dan pengaturan sistem | CRUD buku/kategori, kelola peminjaman (approve/reject/return), suspen anggota, kelola settings, ekspor laporan CSV |
| **Anggota (Member)** | Pengguna yang meminjam buku | Lihat katalog, ajukan/batalkan peminjaman, lihat riwayat & status pinjaman, lihat Kartu Anggota Digital & QR Code ID |

> Catatan: Pengguna bertipe `admin` dan `member` juga memiliki status akun (`active` | `suspended`). Pengguna berstatus `suspended` ditolak aksesnya saat login.

---

## 3. Daftar Fitur

### 3.1 Fitur Utama (Must-Have)

**Autentikasi & Otorisasi**
- Login/logout untuk Admin dan Anggota (Hand-rolled auth)
- Role-based access control (RBAC) via custom middleware `EnsureUserHasRole` & `EnsureUserIsActive`
- Proteksi akun suspended saat login

**Manajemen Buku & Kategori (Admin)**
- CRUD data buku (judul, penulis, ISBN, penerbit, tahun terbit, sinopsis, cover gambar)
- Manajemen eksemplar fisik buku (`book_copies`) dengan status real-time (`available`, `reserved`, `borrowed`, `damaged`, `lost`)
- Manajemen kategori/genre buku (relasi Many-to-Many via `book_category`)

**Manajemen Anggota (Admin)**
- Daftar & pencarian data anggota
- Toggle status keanggotaan (`active` / `suspended`)

**Transaksi Peminjaman & Pengembalian**
- Pengajuan pinjam oleh Anggota (self-service; mengunci eksemplar ke status `reserved`)
- Pembatalan pengajuan pinjam oleh Anggota saat status masih `pending`
- Persetujuan (Approve) atau Penolakan (Reject) transaksi oleh Admin
- Pengembalian buku oleh Admin (menghitung keterlambatan & denda real-time)

**Kartu Anggota Digital & QR Code (Anggota)**
- Tampilan Kartu Anggota Digital interaktif pada halaman Profil Anggota
- QR Code ID unik berbasis `PERPUS-ID-{user_id}` yang dihasilkan secara real-time untuk verifikasi saat kunjungan perpustakaan

**Pencarian & Filter**
- Cari buku berdasarkan judul, penulis, atau kategori
- Filter status ketersediaan buku

**Pengaturan Sistem & Laporan (Admin)**
- Pengaturan durasi peminjaman standar (hari) dan tarif denda per hari
- Laporan riwayat transaksi peminjaman dengan filter rentang tanggal dan status
- Ekspor laporan transaksi ke format file CSV

**Dashboard**
- Admin: total buku, total anggota, peminjaman aktif, pengajuan pending
- Anggota: ringkasan statistik pinjaman, buku sedang dipinjam, status pending, denda aktif

### 3.2 Fitur Tambahan (Nice-to-Have / Future Scope)
- Export laporan ke PDF / Excel terformat
- Notifikasi email mendekati jatuh tempo
- Rating & review buku oleh anggota
- Tabel `reservations` disiapkan di database untuk fitur antrean buku saat stok kosong

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
| FR-10 | Anggota hanya dapat melihat data peminjaman dan profil miliknya sendiri |
| FR-11 | Sistem harus menampilkan Kartu Anggota Digital ber-QR Code ID unik (`PERPUS-ID-{user_id}`) pada profil anggota |
| FR-12 | Sistem harus memungkinkan admin mengatur durasi pinjam standar dan tarif denda harian via menu Settings |
| FR-13 | Sistem harus memungkinkan admin mengekspor laporan transaksi peminjaman ke file CSV |

---

## 5. Non-Functional Requirements

| Aspek | Requirement |
|---|---|
| **Usability** | Antarmuka bersih & modern dengan Tailwind CSS v4, responsif untuk perangkat mobile & desktop |
| **Security** | Password di-hash menggunakan Laravel `hashed` cast (Bcrypt/Argon2); validasi server-side pada seluruh request; proteksi CSRF & rate-limiting pada auth |
| **Performance** | Pencarian buku & pembuatan QR Code SVG/PNG cepat dan tidak membebani server |
| **Maintainability** | Kode mengikuti arsitektur Laravel 12 MVC standar, clean code & linting dengan Laravel Pint |
| **Portability** | Berjalan di lingkungan Laragon (MySQL) serta kompatibel dengan SQLite in-memory untuk pengujian unit |

---

## 6. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal dibuat | Hasil sesi analisis kebutuhan tahap 1 |
| September 2026 | Pembaharuan fitur: Kartu Anggota Digital QR Code, Pembatalan Pengajuan oleh Anggota, Pengaturan Sistem (Settings), Suspen Anggota, Ekspor CSV | Penyesuaian dengan implementasi sistem yang telah diselesaikan |

---

## Catatan
Dokumen ini adalah rujukan resmi yang selalu disesuaikan dengan arsitektur dan fungsionalitas sistem perpustakaan terkini.
