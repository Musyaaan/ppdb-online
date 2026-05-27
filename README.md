# PPDB Online - SDN Legok 3

Sistem Penerimaan Peserta Didik Baru (PPDB) berbasis Laravel 12 yang terintegrasi dengan sistem absensi sekolah berbasis PHP native.

## Overview

Project ini dibuat untuk mempermudah proses pendaftaran siswa baru secara online, mulai dari pengisian data siswa, upload dokumen, verifikasi admin, hingga integrasi otomatis ke sistem absensi sekolah.

Sistem terdiri dari:

* PPDB Online (Laravel 12)
* Sistem Absensi Sekolah (Plain PHP)
* Integrasi database antar sistem

---

# Features

## PPDB System

* Registrasi akun orang tua
* Login dan autentikasi
* Formulir pendaftaran siswa
* Upload dokumen persyaratan
* Validasi data pendaftaran
* Status pendaftaran realtime
* Cetak bukti pendaftaran
* ZIP otomatis dokumen siswa
* Dashboard orang tua

## Admin Features

* Verifikasi pendaftaran siswa
* Approve / reject pendaftaran
* Catatan revisi admin
* Preview dokumen siswa
* Download dokumen ZIP
* Monitoring status pendaftaran
* Integrasi ke sistem absensi

## Attendance Integration

* Sinkronisasi data siswa diterima
* Insert otomatis ke database absensi
* Multi database connection
* Integrasi Laravel ↔ PHP Native

---

# Tech Stack

## Backend

* Laravel 12
* PHP 8+
* MySQL / MariaDB

## Frontend

* Blade Template
* HTML5
* CSS3
* JavaScript

## Additional

* Laravel Storage
* ZIP Archive
* Session Authentication
* mysqli procedural integration

---

# Project Structure

```text
htdocs/
├── PPDB/
│   ├── app/
│   ├── public/
│   ├── resources/
│   ├── routes/
│   └── storage/
│
└── absensi/
    ├── dashboard_admin.php
    ├── koneksi.php
    ├── koneksi_ppdb.php
    ├── ppdb_list.php
    ├── ppdb_detail.php
    ├── ppdb_aksi.php
    └── email_helper.php
```

---

# Database Structure

## PPDB Database

Database:

```text
ppdb
```

Main tables:

* users
* pendaftaran
* siswa
* data_orangtua
* dokumen
* verifikasi
* bukti_pendaftaran

---

## Attendance Database

Database:

```text
sekolah
```

Main tables:

* siswa
* absensi
* kelas
* user

---

# Installation

## Clone Repository

```bash
git clone https://github.com/Musyaaan/ppdb-online.git
```

---

## Move Project

Pindahkan project ke folder:

```text
xampp/htdocs/
```

---

## Install Dependency

```bash
composer install
```

---

## Copy Environment File

```bash
cp .env.example .env
```

---

## Generate App Key

```bash
php artisan key:generate
```

---

## Configure Database

Edit file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ppdb
DB_USERNAME=root
DB_PASSWORD=
```

---

## Run Migration

```bash
php artisan migrate
```

---

## Create Storage Link

```bash
php artisan storage:link
```

---

## Run Server

```bash
php artisan serve
```

---

# Attendance Integration Setup

Buat file:

```text
absensi/koneksi_ppdb.php
```

Isi:

```php
<?php

date_default_timezone_set('Asia/Jakarta');

$ppdb_host = "localhost";
$ppdb_user = "root";
$ppdb_pass = "";
$ppdb_db   = "ppdb";

$conn_ppdb = new mysqli(
    $ppdb_host,
    $ppdb_user,
    $ppdb_pass,
    $ppdb_db
);

if ($conn_ppdb->connect_error) {
    die("Koneksi PPDB gagal");
}

$conn_ppdb->set_charset("utf8mb4");
$conn_ppdb->query("SET time_zone = '+07:00'");
```

---

# Upload System

Dokumen siswa disimpan di:

```text
storage/app/public/dokumen/{id_pendaftaran}/
```

Dokumen wajib:

* Kartu Keluarga
* Akta Kelahiran
* KTP Orang Tua

Setelah dokumen lengkap:

* ZIP otomatis dibuat
* Admin dapat download seluruh dokumen sekaligus

---

# Verification Flow

```text
Orang Tua Daftar
        ↓
Upload Dokumen
        ↓
Status Pending
        ↓
Admin Verifikasi
        ↓
Diterima / Ditolak / Diperbaiki
        ↓
Jika diterima:
Data masuk ke sistem absensi
```

---

# Security

* Session-based authentication
* Password hashing
* File validation
* Role validation
* Upload restriction
* Multi database isolation
* Admin-only verification access

---

# Future Improvements

* REST API
* WhatsApp notification
* Email notification
* Export PDF/Excel
* Dashboard analytics
* Multi school support
* Mobile app integration

---

# Screenshots

Tambahkan screenshot project di sini.

Contoh:

```text
public/image/screenshot-dashboard.png
public/image/screenshot-ppdb.png
```

---

# Author

Developed for SDN Legok 3 Administration System.

GitHub:

```text
https://github.com/Musyaaan
```

---

# License

This project is developed for educational and internal school administration purposes.
