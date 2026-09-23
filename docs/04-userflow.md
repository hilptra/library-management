# User Flow — Sistem Manajemen Perpustakaan

**Versi:** 1.2  
**Status:** Terimplementasi  
**Terakhir diperbarui:** September 2026  

---

## 1. Flow Anggota — Mengajukan & Membatalkan Peminjaman

### A. Pengajuan Peminjaman Buku
1. Anggota login ke sistem dan tiba di **Beranda Member** (`/member/dashboard`).
2. Membuka **Katalog Buku** (`/member/books`), mencari judul atau memfilter berdasarkan kategori pada tampilan *Card Grid*.
3. Membuka **Detail Buku** (`/member/books/{id}`) dan melihat status ketersediaan eksemplar.
4. Klik tombol **"Pinjam Buku"**:
   - Sistem memilih 1 eksemplar fisik berstatus `available` untuk judul tersebut.
   - Sistem membuat entri transaksi baru di `loans` dengan status `pending` (`book_copy_id` terisi).
   - Status eksemplar fisik tersebut diubah secara instan dari `available` menjadi `reserved` (mencegah bentrokan pengajuan oleh anggota lain).
5. Anggota menunggu persetujuan Admin yang dapat dipantau di **Peminjaman Saya** (`/member/loans`).

### B. Pembatalan Pengajuan Peminjaman oleh Anggota
1. Anggota membuka **Peminjaman Saya** (`/member/loans`).
2. Pada tab/daftar peminjaman berstatus `pending`, Anggota mengeklik tombol **"Batalkan Pengajuan"**.
3. Sistem mengubah status transaksi `loans` dari `pending` menjadi `cancelled`.
4. Sistem mengembalikan status eksemplar fisik dari `reserved` kembali menjadi `available`.

---

## 2. Flow Admin — Memproses Approval & Pengembalian Buku

### A. Approval Peminjaman (Approve / Reject)
1. Admin login ke sistem dan membuka menu **Kelola Peminjaman** (`/admin/loans`).
2. Melihat daftar permintaan peminjaman berstatus `pending`.
3. Admin mengambil tindakan:
   - **Approve**:
     - Sistem mengisi `loan_date` (tanggal hari ini) dan `due_date` (hari ini + durasi pinjam di `settings`).
     - Status transaksi `loans` berubah menjadi `borrowed`, status eksemplar fisik menjadi `borrowed`.
     - Member menerima notifikasi *"Peminjaman Disetujui"*.
   - **Reject**:
     - Status transaksi `loans` berubah menjadi `rejected`, status eksemplar fisik kembali menjadi `available`.
     - Member menerima notifikasi *"Peminjaman Ditolak"*.

### B. Pengembalian Buku & Notifikasi Ulasan
1. Admin membuka menu **Kelola Peminjaman** (`/admin/loans`) pada daftar peminjaman berstatus `borrowed`.
2. Saat Anggota mengembalikan buku secara fisik, Admin mengeklik tombol **"Proses Pengembalian"**.
3. Sistem memproses pengembalian:
   - Sistem mengeset `return_date` (tanggal hari ini).
   - Jika `return_date > due_date`, sistem menghitung denda otomatis (selisih hari × tarif denda dari `settings`) dan menyimpannya pada `fine_amount`.
   - Status transaksi `loans` berubah menjadi `returned`, status eksemplar fisik kembali menjadi `available`.
   - Sistem mengirim **Notifikasi Pengembalian** ke Anggota berisi ajakan untuk memberikan rating & ulasan buku.

---

## 3. Flow Anggota — Memberi Rating & Ulasan Buku

1. Anggota menerima notifikasi pengembalian buku di lonceng navbar atau di **Pusat Notifikasi** (`/member/notifications`).
2. Anggota mengeklik notifikasi tersebut.
3. Sistem secara otomatis menandai notifikasi sebagai "sudah dibaca" dan mengarahkan pengguna langsung ke **Detail Buku** (`/member/books/{id}#ulasan`).
4. Pada blok **Ulasan & Rating Pembaca**:
   - Anggota memilih rating bintang (1-5 bintang) dengan interaksi efek hover.
   - Anggota menulis ulasan/komentar (opsional).
   - Klik **"Kirim Ulasan"** (atau *"Simpan Perubahan Ulasan"* jika sudah pernah mengulas).
5. Ulasan tersimpan dan nilai rata-rata rating buku dihitung secara otomatis untuk ditampilkan di katalog.

---

## 4. Flow Anggota — Pengelolaan Wishlist (Daftar Keinginan)

1. Anggota menjelajahi **Katalog Buku** (`/member/books`).
2. Klik tombol **Wishlist** (ikon hati) di pojok atas kartu buku atau halaman detail buku.
3. Sistem menyimpan/menghapus buku ke daftar wishlist anggota.
4. Anggota dapat membuka menu **Daftar Keinginan** (`/member/wishlist`) atau melihat pratinjau wishlist di **Beranda Member** untuk mengajukan peminjaman cepat saat stok tersedia.

---

## 5. Flow Admin — Meninjau Ulasan Pembaca & Settings

### A. Meninjau Ulasan Pembaca pada Detail Buku
1. Admin membuka menu **Manajemen Buku** (`/admin/books`).
2. Admin mengeklik tombol **Detail** pada salah satu buku (`/admin/books/{id}`).
3. Pada seksi **Ulasan & Rating Pembaca**, Admin dapat meninjau statistik rata-rata rating, jumlah ulasan, nama member pemberi ulasan, skor bintang, serta isi komentar ulasan.

### B. Pengaturan Parameter Sistem
1. Admin membuka menu **Pengaturan** (`/admin/settings`).
2. Admin memperbarui nilai **Durasi Peminjaman (Hari)**, **Tarif Denda per Hari**, dan **Batas Maksimal Pinjam**.
3. Perubahan tersimpan di tabel `settings` dan secara otomatis berlaku untuk seluruh transaksi berikutnya serta langsung diperbarui pada kartu aturan di Beranda Member.

---

## 6. Flow Anggota — Kartu Anggota Digital & QR Code ID

1. Anggota login dan membuka menu **Profil Saya** (`/member/profile`).
2. Sistem secara real-time membuat dan menampilkan **Kartu Anggota Digital**:
   - Identitas anggota (Nama, Email, Tanggal Bergabung, Status).
   - Gambar **QR Code ID** unik berbasis string `PERPUS-ID-{user_id}` (pustaka *Endroid QrCode v6*).
3. Anggota menunjukkan Kartu Anggota Digital & QR Code melalui layar smartphone saat kunjungan ke lokasi perpustakaan.

---

## 7. Riwayat Perubahan

| Tanggal | Perubahan | Alasan |
|---|---|---|
| Agustus 2026 | Draft awal flow pengajuan anggota & approval admin | Penyusunan alur dasar |
| September 2026 | Pembaharuan user flow: Pembatalan Pengajuan, Kartu Anggota QR Code, Settings Admin, Suspen Anggota, & Export CSV | Penyesuaian dokumen alur sistem |
| September 2026 | Pembaharuan user flow lanjutan: Flow Rating & Ulasan Buku setelah Pengembalian, Flow Direct Notification Open, Flow Wishlist, & Flow Peninjau Ulasan Admin | Penyesuaian dengan fitur-fitur baru yang selesai dikembangkan |