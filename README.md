# Sistem Aset Kampus ULBI

Prototipe dari proyek **Sistem Alokasi dan Peminjaman Aset Kampus Berbasis Web Menggunakan Best-Fit dan Interval Conflict Detection (Studi Kasus: ULBI)**. Aplikasi ini dirancang untuk membantu pemohon memilih ruangan dan sarana tambahan, serta membantu admin meninjau pengajuan dan mencatat kondisi aset saat dikembalikan.

## Jalankan di laptop

Siapkan Git, Composer, dan PHP 8.4 (minimal 8.4.1) atau 8.5 dengan ekstensi PDO SQLite. Bootstrap 5 sudah disertakan di repositori, sehingga halaman demo bisa dijalankan tanpa npm.

Untuk pengaturan pertama di laptop baru, jalankan perintah berikut dari folder tempat kamu menyimpan proyek.

```sh
git clone --branch fitur/beranda-aset https://github.com/kireinahasya/sistem-aset-ulbi.git
cd sistem-aset-ulbi
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
```

Jika proyek sudah tersiapkan, jalankan `php artisan serve` dari folder proyek. Buka [http://127.0.0.1:8000](http://127.0.0.1:8000) di browser.

## Halaman yang bisa dicoba

| Halaman | Yang bisa dicoba |
| --- | --- |
| Beranda (`/`) | Pilih tanggal di kalender untuk melihat slot ruang. Isi jam, jumlah peserta, dan kebutuhan fasilitas untuk mendapat rekomendasi ruang. |
| Jadwal dan stok (`/jadwal-stok`) | Lihat contoh jadwal bentrok dan jumlah sarana yang melebihi stok tersedia. |

Coba cari ruang pada **17 November 2026**, pukul **11.00–12.00 WIB**, untuk **35 orang** dengan AC dan proyektor. Ruang A muncul di urutan pertama karena tersedia dan menyisakan 5 kursi. Jadwal, ruangan, dan stok dalam prototipe ini menggunakan data contoh. Konfigurasi lokal menggunakan SQLite untuk menjalankan Laravel. MySQL direncanakan untuk tahap penyimpanan transaksi.

[User flow dan Use Case Diagram](docs/alur-prototipe.md) memuat rancangan alur pemohon dan admin untuk layar berikutnya.
