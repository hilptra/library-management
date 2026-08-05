# User Flow — Sistem Manajemen Perpustakaan

**Versi:** 1.0
**Status:** Draft — Tahap Perancangan
**Terakhir diperbarui:** Agustus 2026

---

## 1. Flow Anggota — Mengajukan Peminjaman

1. Anggota login ke sistem
2. Buka Katalog Buku, cari/filter judul yang diinginkan
3. Buka Detail Buku, lihat ketersediaan eksemplar
4. Klik "Ajukan Pinjam"
   - Sistem mencari 1 eksemplar dengan status `available` untuk judul tersebut
   - Sistem membuat baris baru di `loans` dengan status `pending`, `book_copy_id` sudah terisi
   - Status eksemplar itu diubah dari `available` menjadi `reserved`
5. Anggota menunggu persetujuan — bisa dipantau di Dashboard / Riwayat Peminjaman Saya
6. Admin memproses (lihat Flow Admin di bawah), dengan dua kemungkinan hasil:
   - **Disetujui** → status `loans` jadi `borrowed`, eksemplar jadi `borrowed`
   - **Ditolak** → status `loans` jadi `rejected`, eksemplar kembali jadi `available`

---

## 2. Flow Admin — Memproses Persetujuan Peminjaman

1. Admin login ke sistem
2. Buka halaman Persetujuan Peminjaman, melihat daftar permintaan berstatus `pending`
3. Memilih satu permintaan, meninjau data anggota dan eksemplar yang sudah dialokasikan sistem
4. Mengambil keputusan:
   - **Approve** → sistem set `loan_date` (hari ini) dan `due_date` (hari ini + durasi pinjam standar), status `loans` jadi `borrowed`
   - **Reject** → status `loans` jadi `rejected`, status eksemplar kembali `available`

---

## 3. Flow Admin — Memproses Pengembalian (di luar cakupan approval)

1. Admin membuka Peminjaman Aktif, melihat daftar transaksi berstatus `borrowed`
2. Memilih transaksi yang bukunya sudah dikembalikan secara fisik
3. Klik "Proses Pengembalian"
   - Sistem mengisi `return_date` dengan tanggal hari ini
   - Sistem menghitung `fine_amount` otomatis jika `return_date` melewati `due_date`
   - Status `loans` jadi `returned`
   - Status eksemplar kembali menjadi `available`

---

## 4. Temuan Penting dari Penyusunan Flow Ini

Saat menyusun flow anggota, ditemukan potensi konflik: dua anggota bisa saja mengajukan pinjam untuk judul yang sama sebelum admin sempat memproses permintaan pertama, sehingga admin bisa menghadapi dua permintaan pending untuk satu eksemplar yang sama.

**Solusi:** eksemplar dialokasikan sistem **saat pengajuan** (bukan saat approval), dan statusnya langsung diubah menjadi `reserved` — sehingga eksemplar itu otomatis tidak muncul lagi sebagai pilihan untuk anggota lain sampai admin memutuskan approve/reject. Ini berdampak ke ERD: ditambahkan nilai `reserved` pada `book_copies.status` (lihat `docs/02-erd.md`).

---

## 5. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal flow anggota & admin | Hasil sesi penyusunan user flow |
| Agustus 2026 | Ditemukan kebutuhan status `reserved` pada eksemplar | Mencegah alokasi ganda pada eksemplar yang sama |