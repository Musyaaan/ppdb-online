<div align="center">

<br>

# 🏫 PPDB Online SDN Legok 3

**Sistem Penerimaan Peserta Didik Baru Berbasis Web**

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/Lisensi-Akademik-green?style=for-the-badge)](./LICENSE)

<br>

> Aplikasi digitalisasi proses PPDB untuk SDN Legok 3 — mempermudah pendaftaran siswa baru secara online, efisien, dan terarsip dengan baik.

<br>

</div>

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Profil Sekolah](#-profil-sekolah)
- [Latar Belakang](#-latar-belakang)
- [Fitur Utama](#-fitur-utama)
- [Persyaratan Pendaftaran](#-persyaratan-pendaftaran)
- [Kriteria & Ketentuan Seleksi](#-kriteria--ketentuan-seleksi)
- [Teknologi](#-teknologi)
- [Instalasi & Menjalankan](#-instalasi--menjalankan)
- [Akun Admin Default](#-akun-admin-default)
- [Narasumber & Pengembang](#-narasumber--pengembang)

---

## 📖 Tentang Proyek

Sistem PPDB Online SDN Legok 3 adalah aplikasi web yang dikembangkan menggunakan framework **Laravel** untuk mendigitalisasi proses penerimaan peserta didik baru. Sistem ini menggantikan proses manual yang sebelumnya menimbulkan berbagai kendala administratif, menjadi sistem yang terintegrasi, efisien, dan mudah dikelola.

---

## 🏫 Profil Sekolah

| Keterangan | Detail |
|---|---|
| **Nama Sekolah** | SDN Legok 3 |
| **Alamat** | Jalan Manungtung, Desa Legok |
| **Tahun Berdiri** | 1983 |
| **Kepala Sekolah** | 1 Orang |
| **Jumlah Guru** | 19 Orang |
| **Penjaga Sekolah** | 1 Orang |
| **Total Siswa** | 542 Siswa |

---

## 🧩 Latar Belakang

Berdasarkan hasil wawancara dengan pihak sekolah pada **30 Maret 2026**, proses PPDB yang berjalan saat ini masih dilakukan secara manual, sehingga menimbulkan sejumlah kendala:

- 📁 Pengarsipan data masih dilakukan secara manual
- ⚠️ Ketidaksinkronan data Kartu Keluarga dengan Dukcapil
- 🚶 Orang tua/wali harus datang langsung untuk menyerahkan berkas
- 📊 Kesulitan dalam pengelolaan dan rekap data pendaftar

Sistem ini hadir sebagai solusi digital untuk mengatasi seluruh permasalahan tersebut.

---

## ✨ Fitur Utama

### 👤 Untuk Pendaftar (Orang Tua / Wali)
- **Landing Page** — Informasi lengkap profil dan pengumuman sekolah
- **Formulir Pendaftaran Online** — Isi data calon siswa secara digital
- **Upload Dokumen** — Unggah berkas persyaratan langsung dari rumah
- **Notifikasi Konfirmasi** — Pemberitahuan status pendaftaran secara otomatis
- **Cetak Bukti Pendaftaran** — Unduh dan cetak tanda bukti pendaftaran

### 🛠️ Untuk Admin / Operator Sekolah
- **Verifikasi Berkas** — Periksa dan validasi dokumen pendaftar
- **Manajemen Data Siswa** — Kelola seluruh data peserta didik baru
- **Rekap Laporan** — Ekspor laporan dalam format **PDF** dan **Excel**
- **Sistem Arsip Digital** — Penyimpanan dokumen terstruktur dan aman

---

## 📄 Persyaratan Pendaftaran

Dokumen yang **wajib diunggah** oleh pendaftar:

| No | Dokumen | Keterangan |
|:---:|---|---|
| 1 | 📋 Kartu Keluarga (KK) | Wajib |
| 2 | 📜 Akta Kelahiran | Wajib |
| 3 | 🪪 KTP Orang Tua | Wajib |
| 4 | 🎓 Ijazah TK | Jika ada |

---

## 📏 Kriteria & Ketentuan Seleksi

### Kriteria Usia
| Kondisi | Keterangan |
|---|---|
| Usia **≥ 7 tahun** | **Wajib diterima** |
| Usia **≥ 6,8 tahun** | Dapat diterima jika memiliki ijazah TK |

### Mekanisme Seleksi
- ✅ Menggunakan **sistem zonasi**
- ✅ Berdasarkan **urutan waktu pendaftaran** apabila kuota penuh

### Ketentuan Kuota
- 📌 Maksimal **28 siswa per kelas**
- ❌ Tidak terdapat jalur afirmasi atau perpindahan tugas

---

## 🛠️ Teknologi

| Teknologi | Kegunaan |
|---|---|
| **PHP** | Bahasa pemrograman server-side |
| **Laravel** | Framework utama aplikasi web |
| **MySQL** | Sistem manajemen basis data |
| **Bootstrap** | Framework CSS untuk antarmuka |
| **JavaScript** | Interaktivitas sisi klien |

---

## 🚀 Instalasi & Menjalankan

Pastikan kamu sudah menginstal **PHP**, **Composer**, dan **MySQL** di sistem kamu.

### 1. Clone Repository

```bash
git clone https://github.com/username/ppdb-sdn-legok3.git
cd ppdb-sdn-legok3
```

### 2. Instal Dependensi

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Lalu edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ppdb_sdn_legok3
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi Database

```bash
php artisan migrate
```

> Opsional: jalankan seeder jika tersedia
> ```bash
> php artisan db:seed
> ```

### 5. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di browser: **[http://localhost:8000](http://localhost:8000)**

---

## 🔑 Akun Admin Default

> ⚠️ **Penting:** Segera ubah password setelah login pertama kali di lingkungan produksi!

```
Email    : admin@gmail.com
Password : admin123
```

---

## 👥 Narasumber & Pengembang

### Narasumber
| Jabatan | Nama |
|---|---|
| Kepala Sekolah | **Deni Wiratna, S.Pd., M.MPd.** |

> Wawancara dilakukan pada **30 Maret 2026** sebagai dasar analisis kebutuhan sistem PPDB Online SDN Legok 3.

### Pengembang
| Peran | Nama | NIM |
|---|---|---|
| Ketua Pelaksana | **Ryan Hidayat** | 231011400395 |

---

## 📝 Lisensi

Proyek ini dibuat untuk keperluan **akademik** dan pengembangan sistem informasi sekolah.  
Seluruh hak cipta dilindungi oleh pengembang.

---

<div align="center">

Dibuat dengan ❤️ untuk **SDN Legok 3**

</div>
