# Sistem Manajemen Laundry 

Project ini adalah Sistem Laundry berbasis **REST API** yang dibangun menggunakan **Laravel 13** dan **Laravel Sanctum**. Project ini ditujukan untuk memenuhi tugas Ujian Akhir Semester (UAS).

Aplikasi ini menerapkan sistem **Authentication**, **Role-Based Access Control (RBAC)** dengan tingkatan hak akses untuk **Admin** dan **Kasir**, manajemen relasi database, kalkulasi kembalian otomatis, perubahan status pesanan otomatis, hingga pencetakan struk pembayaran dalam format PDF.

---

## Bahasa Pemrograman yang Digunakan
- **PHP** (Backend)
- **JavaScript** (Interaktivitas Frontend)
- **HTML5 & CSS3** (Struktur dan Desain Antarmuka)
- **SQL** (Pengelolaan Database)

## 🛠️ Framework, Library, API, dkk yang Digunakan
*(Catatan: Sesuaikan dengan tumpukan teknologi/tech stack proyekmu)*
- **Framework Web:** Laravel / CodeIgniter / Express.js
- **Styling/UI:** Bootstrap 5 / Tailwind CSS
- **Database:** MySQL / MariaDB
- **Library Tambahan:** 
  - DataTables (Untuk fitur *search* dan *pagination* pada tabel)
  - Chart.js (Untuk visualisasi grafik laporan)
  - SweetAlert2 (Untuk pop-up notifikasi yang menarik)
- **API (Opsional):** WhatsApp API Gateway (Untuk mengirim pesan otomatis saat cucian selesai)

## Fungsi dan Fitur Proyek yang Dibangun
Sistem ini dilengkapi dengan berbagai fitur esensial, antara lain:
1. **Manajemen Transaksi:** Pencatatan cucian masuk, input berat/jumlah satuan, pemilihan paket layanan, dan kalkulasi harga secara otomatis.
2. **Dashboard Interaktif:** Menampilkan ringkasan pendapatan, jumlah pesanan aktif, dan metrik bisnis lainnya.
3. **Tracking Status Cucian:** Memantau dan mengubah status pesanan (*Antre -> Diproses -> Selesai -> Diambil*).
4. **Manajemen Pelanggan:** Menyimpan data pelanggan (nama, no. HP, alamat) untuk mempermudah transaksi berikutnya.
5. **Manajemen Layanan:** Admin dapat menambah, mengubah, atau menghapus jenis paket laundry beserta harganya.
6. **Laporan & Struk:** Fitur cetak struk pembayaran untuk pelanggan dan cetak laporan pendapatan harian/bulanan untuk pemilik.

## Kelebihan Proyek yang Dibangun
- **User Friendly:** Desain antarmuka dibuat sederhana dan intuitif sehingga sangat mudah dioperasikan oleh kasir.
- **Otomatisasi Hitungan:** Meminimalisir kesalahan (*human error*) dalam menghitung total tagihan atau kembalian.
- **Responsif:** Dapat diakses dengan tampilan yang proporsional baik melalui PC, laptop, maupun *smartphone* atau tablet.

