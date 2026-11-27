# Sistem Aset Kampus ULBI

**Sistem Alokasi dan Peminjaman Aset Kampus Berbasis Web Menggunakan Best-Fit dan Interval Conflict Detection (Studi Kasus: ULBI)**

Proyek TI II ini mengembangkan aplikasi untuk membantu peminjam mencari ruangan dan sarana kampus sesuai kebutuhan, mengajukan peminjaman, dan memantau statusnya. Admin Logistik mengelola aset, meninjau pengajuan, serta mencatat pengembalian dan kondisi aset.

## Status pengembangan

Tahap saat ini adalah prototipe antarmuka menggunakan Blade, Bootstrap 5, layout bersama, dan data contoh. Data ruangan, fasilitas, jadwal, dan stok digunakan untuk mendemonstrasikan alur aplikasi.

| Cabang | Isi |
| --- | --- |
| `main` | Proyek awal Laravel dan README proyek. |
| `fitur/beranda-aset` | Prototipe beranda, kalender, pencarian rekomendasi, katalog dan detail ruangan, serta dokumentasi alur dan use case. |

Gunakan cabang `fitur/beranda-aset` untuk mencoba prototipe. Perkembangan antarmuka tersedia pada draft pull request berikut.

[Prototipe dan perubahan pengembangan](https://github.com/kireinahasya/sistem-aset-ulbi/pull/1)

## Peran pengguna

| Peran | Tanggung jawab yang direncanakan |
| --- | --- |
| Peminjam | Mahasiswa, dosen, atau staf yang melihat ketersediaan aset, mengajukan peminjaman, dan memantau status serta riwayat sendiri. |
| Admin Logistik | Petugas yang mengelola data aset, memberikan keputusan pengajuan, mencatat penyerahan dan pengembalian, serta melihat laporan. |

Mahasiswa, dosen, dan staf menggunakan fitur peminjaman yang sama dalam rancangan awal. Pembagian tugas petugas dan aturan persetujuan akan disesuaikan dengan prosedur Logistik ULBI.

## Aset yang dikelola

- **Ruangan** dengan data kapasitas, fasilitas bawaan, kondisi, dan status.
- **Fasilitas bawaan ruangan**, misalnya AC dan proyektor terpasang.
- **Sarana tambahan** dengan stok dan kondisi, misalnya mikrofon, set tiang dan tatakan bendera, sofa dosen, dan meja tamu.

Peminjam dapat mengajukan ruangan dan/atau sarana tambahan sesuai waktu serta jumlah unit yang diperlukan.

## Fitur dan kemajuan

| Bagian | Fitur | Status |
| --- | --- | --- |
| Beranda | Informasi aplikasi dan akses pencarian ruang | Tersedia dengan data contoh |
| Kalender | Pilih tanggal dan lihat slot kosong ruangan | Tersedia dengan data contoh |
| Rekomendasi | Cari berdasarkan waktu, kapasitas, dan fasilitas, lalu urutkan dengan Best-Fit | Tersedia dengan data contoh |
| Katalog ruangan | Lihat kapasitas dan buka detail fasilitas bawaan | Tersedia dengan data contoh |
| Contoh keadaan khusus | Jadwal bentrok, stok kurang, validasi pencarian, dan hasil pencarian kosong | Tersedia dengan data contoh |
| Akun | Registrasi Peminjam, login Peminjam/Admin, dan pemulihan kata sandi | Tampilan dan validasi browser tersedia. Formulir menampilkan status layanan belum tersedia setelah isian valid. Autentikasi, penyimpanan akun, dan pengiriman email direncanakan. |
| Katalog sarana | Lihat jenis sarana, stok, kondisi, dan pilih sarana untuk formulir peminjaman | Tersedia dengan data contoh |
| Pengajuan | Formulir penanggung jawab, kegiatan, waktu, ruangan, sarana, dan lampiran PDF opsional | Formulir, validasi di browser, dan ringkasan tersedia. Pengiriman serta penyimpanan pengajuan direncanakan. |
| Status dan riwayat | Pantau keputusan dan peminjaman sendiri, baca alasan penolakan, serta ajukan kembali | Direncanakan |
| Notifikasi website | Pemberitahuan keputusan pengajuan dan tautan ke detailnya | Direncanakan |
| Admin | Dasbor, kelola aset, persetujuan, penyerahan, dan pengembalian beserta kondisi | Direncanakan |
| Laporan | Lihat dan ekspor laporan PDF/Excel | Direncanakan |

Pengiriman pemberitahuan melalui email dapat dikembangkan setelah alur notifikasi website selesai. Ketentuan wajib lampiran surat permohonan atau izin kegiatan perlu dikonfirmasi kepada Logistik ULBI.

## Alur peminjaman yang dituju

1. Peminjam membuka katalog atau kalender dan mencari aset sesuai kebutuhan.
2. Peminjam masuk ke akun, lalu melengkapi kegiatan, waktu penggunaan, pilihan aset, jumlah sarana, dan lampiran sesuai ketentuan.
3. Sistem memeriksa isian, kapasitas, konflik waktu, dan stok sarana selama rentang peminjaman.
4. Pengajuan valid berstatus **Menunggu persetujuan**.
5. Admin meninjau pengajuan dan memeriksa kembali ketersediaan sebelum memberikan keputusan.
6. Pengajuan yang **Disetujui** memperoleh alokasi aset. Pengajuan yang **Ditolak** menampilkan alasan dan dapat diajukan kembali melalui formulir baru.
7. Admin mencatat penyerahan aset sehingga peminjaman berstatus **Sedang dipinjam**.
8. Setelah penggunaan, admin memeriksa jumlah dan kondisi pengembalian. Peminjaman yang telah diselesaikan berstatus **Selesai** dan tersimpan di riwayat.

Alur ini merupakan rancangan untuk tahap implementasi transaksi berikutnya.

## Metode

**Best-Fit** mengurutkan ruangan yang tersedia dan memenuhi kebutuhan berdasarkan sisa kapasitas paling sedikit. Contohnya, untuk 35 peserta, ruang berkapasitas 40 orang lebih dahulu direkomendasikan daripada ruang berkapasitas 80 orang jika keduanya memenuhi fasilitas dan waktu yang diminta.

**Interval Conflict Detection** memeriksa tumpang tindih waktu. Dua jadwal bertabrakan jika waktu mulai pengajuan lebih awal daripada waktu selesai peminjaman lain, dan waktu selesai pengajuan melewati waktu mulai peminjaman tersebut. Jadwal berurutan yang berakhir dan dimulai pada jam yang sama dapat digunakan bergantian.

Untuk sarana, pemeriksaan juga memperhitungkan jumlah unit yang sedang dialokasikan pada rentang waktu penggunaan dan kondisi aset yang layak dipinjam.

## Teknologi

| Komponen | Penggunaan |
| --- | --- |
| Laravel 13 dan PHP | Kerangka aplikasi |
| Blade dan Bootstrap 5 | Antarmuka dan layout bersama |
| SQLite | Konfigurasi lokal prototipe saat ini |
| MySQL | Basis data yang dituju untuk implementasi transaksi |
| Git dan GitHub | Pengelolaan versi kode dan dokumentasi |

Bootstrap, font, logo, dan foto kampus sudah disertakan di cabang prototipe. Halaman demo dapat dijalankan tanpa npm.

## Menjalankan prototipe

Siapkan Git, Composer, serta PHP 8.4 (minimal 8.4.1) atau 8.5 dengan ekstensi yang memenuhi `composer.lock`, termasuk PDO SQLite.

Untuk pemasangan pertama pada folder baru, jalankan perintah berikut.

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

Jika proyek sudah tersiapkan, jalankan `php artisan serve` dari folder proyek, lalu buka alamat berikut.

| Halaman | Alamat lokal |
| --- | --- |
| Beranda, kalender, dan pencarian | http://127.0.0.1:8000 |
| Login Peminjam atau Admin | http://127.0.0.1:8000/masuk |
| Registrasi Peminjam | http://127.0.0.1:8000/daftar |
| Pemulihan kata sandi | http://127.0.0.1:8000/lupa-kata-sandi |
| Katalog ruangan | http://127.0.0.1:8000/ruangan |
| Katalog sarana | http://127.0.0.1:8000/sarana |
| Formulir peminjaman | http://127.0.0.1:8000/peminjaman/baru |
| Contoh detail Ruang D | http://127.0.0.1:8000/ruangan/ruang-d |
| Contoh bentrok jadwal dan stok kurang | http://127.0.0.1:8000/jadwal-stok |

Untuk mencoba rekomendasi, pilih **17 November 2026**, pukul **11.00–12.00 WIB**, untuk **35 peserta**, dengan fasilitas **AC dan proyektor**. Ruang A muncul pertama dengan sisa kapasitas 5 kursi.

Pada halaman masuk, pilih peran dan isi email serta kata sandi. Pada registrasi, lengkapi identitas dan konfirmasi kata sandi. Formulir memvalidasi isian di browser. Setelah isian valid, pesan status menjelaskan bahwa layanan akun belum tersedia. Formulir memproses data di halaman tersebut. Autentikasi dan pembuatan akun menjadi tahap implementasi berikutnya.

Dari detail ruangan, klik **Pilih ruangan**. Dari katalog sarana, klik **Pilih sarana**. Isian ruangan atau sarana langsung terbawa ke formulir. Pilihan dari hasil rekomendasi juga membawa tanggal, jam, dan jumlah peserta.

Klik **Periksa pengajuan** untuk memeriksa kelengkapan isian, kapasitas, bentrok jadwal ruang, stok sarana, serta format dan ukuran PDF. Dokumen bersifat opsional dan dibatasi 5 MB pada antarmuka. Ketentuan ini masih dapat disesuaikan dengan prosedur Logistik ULBI.

Ringkasan dapat dibuka dan diperbaiki melalui **Ubah isian**. Tautan **Masuk untuk mengirim** membuka halaman login. Formulir saat ini memproses isian serta metadata lampiran di browser. Penyimpanan dan pengiriman pengajuan, pengunggahan lampiran ke server, serta pemeriksaan stok sarana berdasarkan transaksi per waktu akan diterapkan pada tahap backend. Stok sarana memakai jumlah tersedia contoh yang tetap.

## Dokumentasi rancangan

Dokumen berikut tersedia di cabang pengembangan.

- [User flow dan alur halaman](https://github.com/kireinahasya/sistem-aset-ulbi/blob/fitur/beranda-aset/docs/alur-prototipe.md)
- [Peran, daftar use case, dan skenario peminjaman](https://github.com/kireinahasya/sistem-aset-ulbi/blob/fitur/beranda-aset/docs/use-case.md)
- [Use Case Diagram](https://github.com/kireinahasya/sistem-aset-ulbi/blob/fitur/beranda-aset/docs/use-case.svg)

## Tahap pengembangan berikutnya

1. Membuat status, riwayat, alasan penolakan, dan notifikasi website.
2. Melengkapi halaman Admin Logistik dan laporan.
3. Memeriksa alur prototipe di laptop dan ponsel sebelum melanjutkan implementasi transaksi menggunakan MySQL.
