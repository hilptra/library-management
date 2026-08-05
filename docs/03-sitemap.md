# Sitemap — Sistem Manajemen Perpustakaan

**Versi:** 1.0
**Status:** Draft — Tahap Perancangan
**Terakhir diperbarui:** Agustus 2026

---

## 1. Model Peminjaman yang Dipilih

**Self-service dengan approval admin.** Anggota mengajukan permintaan pinjam dari katalog, admin memverifikasi dan menyetujui/menolak sebelum buku resmi dianggap dipinjam. Lihat detail alur status di `docs/02-erd.md` bagian tabel `loans`.

---

## 2. Struktur Halaman

```
Landing / Auth
├── Login
├── Register (khusus Anggota — Admin dibuat manual/seeder)

[ADMIN AREA]
├── Dashboard Admin
│   └── Ringkasan: total buku, total anggota, peminjaman aktif, permintaan pending
├── Manajemen Buku
│   ├── Daftar Buku
│   ├── Tambah Buku
│   ├── Edit Buku
│   └── Detail Buku (termasuk daftar eksemplar & statusnya)
├── Manajemen Kategori
│   ├── Daftar Kategori
│   └── Tambah/Edit Kategori
├── Manajemen Anggota
│   ├── Daftar Anggota
│   └── Tambah/Edit Anggota
├── Persetujuan Peminjaman
│   └── Daftar permintaan berstatus pending → aksi Approve / Reject
├── Peminjaman Aktif
│   └── Daftar berstatus borrowed → aksi Proses Pengembalian
└── Laporan
    └── Riwayat Transaksi (filter tanggal, status)

[MEMBER AREA]
├── Dashboard Anggota
│   └── Ringkasan: pinjaman aktif, status pending, denda jika ada
├── Katalog Buku
│   ├── Daftar Buku (pencarian & filter kategori)
│   └── Detail Buku → tombol "Ajukan Pinjam"
├── Riwayat Peminjaman Saya
│   └── Daftar dengan status: pending / borrowed / returned / rejected
└── Profil Saya
```

---

## 3. Keputusan Desain

| Keputusan | Alasan |
|---|---|
| CRUD dipecah jadi halaman terpisah (index/create/edit) | Mengikuti pola resource controller standar Laravel |
| Admin tidak bisa didaftarkan lewat Register | Mencegah pendaftaran admin sembarangan; akun admin dibuat lewat seeder |
| Peminjaman self-service + approval | Lebih realistis dan modern dibanding pencatatan manual oleh admin, sekaligus tetap memberi admin kontrol sebelum buku keluar |
| Status `rejected` dipertahankan (tidak dihapus) | Menjaga jejak riwayat untuk kebutuhan laporan |

---

## 4. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal: model admin-driven | Asumsi awal sebelum dikonfirmasi |
| Agustus 2026 | Revisi ke self-service + approval admin | Keputusan final setelah diskusi trade-off |