# User Flow — Sistem Manajemen Perpustakaan

**Versi:** 1.1  
**Status:** Terimplementasi  
**Terakhir diperbarui:** September 2026  

---

## 1. Flow Anggota — Mengajukan & Membatalkan Peminjaman

### A. Pengajuan Peminjaman Buku
1. Anggota login ke sistem.
2. Membuka **Katalog Buku** (`/member/books`), mencari judul atau memfilter berdasarkan kategori.
3. Membuka **Detail Buku** (`/member/books/{id}`) dan melihat status ketersediaan eksemplar.
4. Klik tombol **"Ajukan Pinjam"**:
   - Sistem memilih 1 eksemplar fisik berstatus `available` untuk judul tersebut.
   - Sistem membuat entri transaksi baru di `loans` dengan status `pending` (`book_copy_id` terisi).
   - Status eksemplar fisik tersebut diubah secara instan dari `available` menjadi `reserved` (mencegah bentrokan pengajuan oleh anggota lain).
5. Anggota menunggu persetujuan Admin yang dapat dipantau di **Riwayat Peminjaman Saya** (`/member/loans`).

### B. Pembatalan Pengajuan Peminjaman oleh Anggota
1. Anggota membuka **Riwayat Peminjaman Saya** (`/member/loans`).
2. Pada tab/daftar peminjaman berstatus `pending`, Anggota mengeklik tombol **"Batalkan Pengajuan"**.
3. Sistem mengubah status transaksi `loans` dari `pending` menjadi `cancelled`.
4. Sistem mengembalikan status eksemplar fisik dari `reserved` kembali menjadi `available`.

---

## 2. Flow Admin — Memproses Persetujuan Peminjaman (Approval)

1. Admin login ke sistem dan membuka menu **Kelola Peminjaman** (`/admin/loans`).
2. Melihat daftar permintaan peminjaman yang berstatus `pending`.
3. Admin meninjau data anggota dan eksemplar yang telah dialokasikan oleh sistem.
4. Admin mengambil tindakan persetujuan:
   - **Approve**:
     - Sistem mengisi `loan_date` (tanggal hari ini) dan `due_date` (hari ini + durasi pinjam di `settings`).
     - Status transaksi `loans` berubah menjadi `borrowed`.
     - Status eksemplar fisik berubah menjadi `borrowed`.
   - **Reject**:
     - Status transaksi `loans` berubah menjadi `rejected`.
     - Status eksemplar fisik kembali menjadi `available`.

---

## 3. Flow Admin — Memproses Pengembalian Buku

1. Admin membuka menu **Kelola Peminjaman** (`/admin/loans`) pada daftar peminjaman berstatus `borrowed`.
2. Saat Anggota mengembalikan buku secara fisik, Admin mengeklik tombol **"Proses Pengembalian"**.
3. Sistem memproses pengembalian:
   - Sistem mengeset `return_date` dengan tanggal hari ini.
   - Jika `return_date > due_date`, sistem menghitung keterlambatan (selisih hari) dikalikan tarif denda per hari (dari `settings`) dan menyimpan nilai nominal pada `fine_amount`.
   - Status transaksi `loans` berubah menjadi `returned`.
   - Status eksemplar fisik kembali menjadi `available`.

---

## 4. Flow Anggota — Penggunaan Kartu Anggota Digital & QR Code ID

1. Anggota login ke sistem.
2. Membuka menu **Profil Saya** (`/member/profile`).
3. Sistem secara real-time membuat dan menampilkan **Kartu Anggota Digital**:
   - Menampilkan identitas resmi anggota (Nama, Email, Tanggal Bergabung, ID Anggota).
   - Menampilkan gambar **QR Code ID** unik berbasis string `PERPUS-ID-{user_id}` (menggunakan pustaka *Endroid QrCode v6*).
4. Anggota dapat menunjukkan Kartu Anggota Digital & QR Code tersebut melalui layar smartphone kepada petugas perpustakaan saat berkunjung di lokasi.

---

## 5. Flow Admin — Pengaturan Sistem, Manajemen Anggota, & Laporan

### A. Pengaturan Parameter Sistem
1. Admin membuka menu **Pengaturan** (`/admin/settings`).
2. Admin memperbarui nilai **Durasi Peminjaman Standar (Hari)** dan **Tarif Denda Keterlambatan per Hari**.
3. Perubahan tersimpan di tabel `settings` dan secara otomatis berlaku untuk seluruh transaksi peminjaman & pengembalian berikutnya.

### B. Manajemen & Suspen Anggota
1. Admin membuka menu **Manajemen Anggota** (`/admin/users`).
2. Admin dapat memfilter/mencari data anggota dan melihat statusnya (`active` / `suspended`).
3. Admin mengeklik **Toggle Status**:
   - Jika diubah menjadi `suspended`, anggota yang bersangkutan tidak dapat melakukan login ke sistem.

### C. Ekspor Laporan Transaksi
1. Admin membuka menu **Laporan** (`/admin/reports`).
2. Admin dapat memfilter transaksi berdasarkan rentang tanggal dan status.
3. Admin mengeklik tombol **"Export CSV"** (`/admin/reports/export`) untuk mengunduh laporan transaksi dalam format CSV.

---

## 6. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal flow pengajuan anggota & approval admin | Penyusunan alur dasar |
| Agustus 2026 | Penambahan mekanisme alokasi eksemplar `reserved` saat pengajuan | Mencegah alokasi ganda eksemplar yang sama |
| September 2026 | Pembaharuan user flow menyeluruh: Flow Pembatalan Pengajuan oleh Anggota, Flow Kartu Anggota Digital QR Code, Flow Settings Admin, Flow Suspen Anggota, & Flow Export CSV | Menyesuaikan dokumen user flow dengan seluruh alur kerja sistem yang telah diimplementasikan |