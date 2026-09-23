# Sitemap — Sistem Manajemen Perpustakaan

**Versi:** 1.2  
**Status:** Terimplementasi  
**Terakhir diperbarui:** September 2026  

---

## 1. Model Peminjaman & Akses

1. **Self-service dengan Approval Admin**: Anggota mengajukan peminjaman dari katalog (`pending`), lalu Admin menyetujui (`borrowed`) atau menolak (`rejected`). Anggota dapat membatalkan pengajuan yang masih berstatus `pending` (`cancelled`).
2. **Ulasan & Rating Buku**: Member yang telah mengembalikan buku dapat menulis ulasan & memberikan bintang rating.
3. **Wishlist (Daftar Keinginan)**: Anggota dapat menandai buku favorit untuk dipantau ketersediaannya.
4. **Role-Based & Active Middleware**:
   - `admin`: Mengakses seluruh fitur manajemen backend (`/admin/*`).
   - `member`: Mengakses beranda, katalog, wishlist, ulasan, riwayat peminjaman, notifikasi, dan profil pribadi (`/member/*`).
   - status `suspended`: Akun yang ditangguhkan oleh Admin akan ditolak saat login.

---

## 2. Struktur Halaman & Rute

```
Landing / Auth
├── / login                (Guest — Form Login & Proses Auth)
├── / register             (Guest — Form Registrasi Anggota Baru)
├── / catalog              (Public — Katalog Publik Buku)
│   └── /catalog/{id}      (Public — Detail Buku)
├── /books/{id}/reviews    (Public — Halaman Semua Ulasan Pembaca Buku)
└── / logout               (Auth — Logout Session)

[ADMIN AREA] — Middleware: auth, active, role:admin
├── /admin/dashboard       (Dashboard Admin: Ringkasan statistik & aktivitas transaksi)
├── /admin/categories      (Manajemen Kategori Buku: Index, Modal Store, Update, Delete)
├── /admin/books           (Manajemen Buku: Index, Create, Edit, Store, Update, Destroy)
│   └── /admin/books/{id}  (Detail Buku, Kelola Eksemplar Fisik, & Peninjau Ulasan Pembaca)
├── /admin/loans           (Kelola Transaksi Peminjaman)
│   ├── Approve            (PATCH /admin/loans/{id}/approve — Set loan_date & due_date)
│   ├── Reject             (PATCH /admin/loans/{id}/reject — Kembalikan eksemplar ke available)
│   └── Return             (PATCH /admin/loans/{id}/return — Hitung denda, proses kembali & pemicu notifikasi ulasan)
├── /admin/users           (Manajemen Anggota: Daftar anggota & Filter)
│   └── Toggle Status      (PATCH /admin/users/{id}/toggle-status — Ubah active/suspended)
├── /admin/settings        (Pengaturan Sistem: Form Durasi Pinjam, Tarif Denda, & Batas Pinjam)
└── /admin/reports         (Laporan Transaksi: Filter Tanggal & Status)
    └── Export CSV         (GET /admin/reports/export — Download file CSV laporan)

[MEMBER AREA] — Middleware: auth, active, role:member
├── /member/dashboard      (Beranda Member: Peminjaman aktif dengan sisa hari, Akses cepat, Pengumuman dinamis, Buku terbaru, & Wishlist preview)
├── /member/books          (Katalog Buku: Grid Kartu Responsif, Filter Kategori, Bintang Rating, Status Stok, & Wishlist Button)
│   ├── /member/books/{id} (Detail Buku, Sinopsis, Stok, & Form Ulasan/Rating Interaktif)
│   └── Reviews Store      (POST /member/books/{id}/reviews — Simpan/Update Rating & Ulasan)
├── /member/wishlist       (Daftar Keinginan Saya: Grid Kartu Buku Favorit & Akses Pinjam Cepat)
│   └── Toggle Wishlist    (POST /member/wishlist/{id}/toggle — Tambah/Hapus dari Wishlist)
├── /member/loans          (Riwayat Peminjaman Saya: Tab status pending / borrowed / returned / rejected / cancelled)
│   └── Batalkan Pengajuan (PATCH /member/loans/{id}/cancel — Pembatalan saat status pending)
├── /member/notifications  (Pusat Notifikasi: List Notifikasi & Filter)
│   └── Buka Notifikasi    (GET /member/notifications/{id}/open — Tandai dibaca & redirect ke Ulasan/Buku)
└── /member/profile        (Profil Saya & Kartu Anggota Digital ber-QR Code ID)
    ├── /member/profile/edit (Edit Form: Ubah Nama & No HP/WA)
    └── Password Update    (PATCH /member/profile/password — Form Ganti Password)
```

---

## 3. Keputusan Desain & Fitur Terintegrasi

| Keputusan / Fitur | Alasan & Deskripsi |
|---|---|
| **Beranda Member Interaktif** | Menampilkan hitung mundur sisa hari batas waktu pengembalian buku dipinjam, aturan sirkulasi dinamis dari `settings`, etalase buku terbaru, dan pratinjau wishlist. |
| **Card Grid Katalog & Wishlist** | Katalog member menggunakan tampilan grid kartu responsif selaras dengan UI Wishlist, dengan indikator stok & rating bintang SVG. |
| **Ulasan & Rating Pembaca** | Member yang telah mengembalikan buku dapat memberi rating 1-5 bintang & ulasan. Rating di-eager load (`withAvg`, `withCount`) untuk performa tinggi. Admin dapat membaca seluruh ulasan pengguna. |
| **Notifikasi Direct Open** | Pengembalian buku memicu notifikasi yang saat dibuka mengarahkan pengguna secara otomatis ke halaman ulasan buku. |
| **Kartu Anggota Digital ber-QR Code** | Anggota memiliki Kartu Anggota Digital di profil dengan QR Code ID unik (`PERPUS-ID-{user_id}`) berbasis SVG/PNG (*Endroid QrCode v6*). |
| **Dynamic System Settings** | Durasi peminjaman, denda per hari, dan max pinjam disimpan di tabel `settings` dan berlaku dinamis di beranda member dan transaksi. |

---

## 4. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal sitemap | Asumsi awal alur aplikasi |
| September 2026 | Pembaharuan sitemap: Kartu QR Code, Cancel Loan, Toggle User Status, Settings Admin, Export CSV | Menyesuaikan struktur halaman final |
| September 2026 | Pembaharuan sitemap lanjutan: Rute Wishlist, Rute Review/Rating, Rute Notifikasi Direct Open, Peninjau Ulasan Admin, dan Beranda Member Interaktif | Menyesuaikan sitemap dengan implementasi fitur terkini |