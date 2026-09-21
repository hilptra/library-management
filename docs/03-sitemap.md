# Sitemap — Sistem Manajemen Perpustakaan

**Versi:** 1.1  
**Status:** Terimplementasi  
**Terakhir diperbarui:** September 2026  

---

## 1. Model Peminjaman & Akses

1. **Self-service dengan Approval Admin**: Anggota mengajukan peminjaman dari katalog (`pending`), lalu Admin menyetujui (`borrowed`) atau menolak (`rejected`). Anggota juga dapat membatalkan pengajuan yang masih berstatus `pending` (`cancelled`).
2. **Role-Based & Active Middleware**:
   - `admin`: Mengakses seluruh fitur manajemen backend (`/admin/*`).
   - `member`: Mengakses katalog, riwayat peminjaman, dan profil pribadi (`/member/*`).
   - status `suspended`: Akun yang ditangguhkan oleh Admin akan ditolak saat login.

---

## 2. Struktur Halaman & Rute

```
Landing / Auth
├── / login                (Guest — Form Login & Proses Auth)
├── / register             (Guest — Form Registrasi Anggota Baru)
└── / logout               (Auth — Logout Session)

[ADMIN AREA] — Middleware: auth, active, role:admin
├── /admin/dashboard       (Dashboard Admin: Ringkasan statistik & statistik pengajuan)
├── /admin/categories      (Manajemen Kategori Buku: Index, Modal Store, Update, Delete)
├── /admin/books           (Manajemen Buku: Index, Create, Edit, Store, Update, Destroy)
│   └── /admin/books/{id}  (Detail Buku & Kelola Eksemplar Fisik / book_copies)
├── /admin/loans           (Kelola Transaksi Peminjaman)
│   ├── Approve            (PATCH /admin/loans/{id}/approve — Set loan_date & due_date)
│   ├── Reject             (PATCH /admin/loans/{id}/reject — Kembalikan eksemplar ke available)
│   └── Return             (PATCH /admin/loans/{id}/return — Hitung denda & proses pengembalian)
├── /admin/users           (Manajemen Anggota: Daftar anggota & Filter)
│   └── Toggle Status      (PATCH /admin/users/{id}/toggle-status — Ubah active/suspended)
├── /admin/settings        (Pengaturan Sistem: Form Durasi Pinjam Standar & Tarif Denda Harian)
└── /admin/reports         (Laporan Transaksi: Filter Tanggal & Status)
    └── Export CSV         (GET /admin/reports/export — Download file CSV laporan)

[MEMBER AREA] — Middleware: auth, active, role:member
├── /member/dashboard      (Dashboard Anggota: Ringkasan pinjaman & statistik pribadi)
├── /member/books          (Katalog Buku: Pencarian, Filter Kategori, & Grid Buku)
│   └── /member/books/{id} (Detail Buku & Tombol "Ajukan Pinjam")
├── /member/loans          (Riwayat Peminjaman Saya: Tab status pending / borrowed / returned / rejected / cancelled)
│   └── Batalkan Pengajuan (PATCH /member/loans/{id}/cancel — Pembatalan saat status pending)
└── /member/profile        (Profil Saya & Kartu Anggota Digital ber-QR Code ID)
    ├── /member/profile/edit (Edit Form: Ubah Nama & No HP/WA)
    └── Password Update    (PATCH /member/profile/password — Form Ganti Password)
```

---

## 3. Keputusan Desain & Fitur Terintegrasi

| Keputusan / Fitur | Alasan & Deskripsi |
|---|---|
| **Kartu Anggota Digital ber-QR Code** | Anggota memiliki Kartu Anggota Digital di profil dengan QR Code ID unik (`PERPUS-ID-{user_id}`) berbasis SVG/PNG (*Endroid QrCode v6*) untuk verifikasi fisik di perpustakaan. |
| **Pembatalan Pengajuan (`cancel`)** | Anggota dapat membatalkan pengajuan pinjaman sendiri jika belum diproses oleh Admin, mengembalikan status eksemplar dari `reserved` ke `available`. |
| **Suspen Anggota (`active`/`suspended`)** | Admin dapat menangguhkan hak akses anggota yang melanggar aturan tanpa menghapus data riwayat transaksi anggota tersebut. |
| **Dynamic System Settings** | Durasi peminjaman dan denda per hari disimpan di tabel `settings`, sehingga dapat disesuaikan tanpa perlu mengubah kode program. |
| **Status Rejected & Cancelled Dipertahankan** | Jejak transaksi tidak dihapus fisik demi integritas data dan audit riwayat laporan. |

---

## 4. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal sitemap | Asumsi awal alur aplikasi |
| Agustus 2026 | Revisi ke model self-service + approval | Menyediakan alur peminjaman mandiri bagi anggota |
| September 2026 | Pembaharuan sitemap lengkap: Kartu Anggota Digital QR Code, Cancel Loan, Toggle User Status, Settings Admin, Export CSV | Menyesuaikan struktur halaman dan rute aplikasi dengan implementasi final |