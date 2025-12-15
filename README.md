# Sistem Informasi Buku Tamu & Manajemen Event (Laravel)

Aplikasi berbasis web yang dirancang untuk modernisasi proses administrasi acara. Aplikasi ini memungkinkan pengelolaan acara, pencatatan tamu, dan pemantauan kehadiran secara **real-time** menggunakan teknologi AJAX, menggantikan metode buku tamu manual.

---

## Tim Pengembang

Proyek ini disusun oleh mahasiswa **Pendidikan Teknik Informatika dan Komputer (PTIK)** Universitas Sebelas Maret (UNS) Angkatan 2023:

| Nama | NIM |
| :--- | :--- |
| **Fakhru Rifqi Ma’arif** | **K3523028** |
| **Hifzhedine Zahares S.** | **K3523036** |
| **M. Fatihul Ihsan** | **K3523048** |

---

## Fitur Utama

Aplikasi ini dilengkapi dengan fitur-fitur modern untuk efisiensi pengelolaan acara:

### 1. Manajemen Event (Acara)
* **CRUD Event:** Membuat, mengedit, dan menghapus acara dengan mudah.
* **Status Otomatis:** Status acara (*Belum Mulai, Berlangsung, Selesai*) berubah otomatis mengikuti tanggal hari ini.
* **Tipe Acara:** Dukungan untuk acara Resmi dan Non-Resmi.

### 2. Manajemen Tamu & Presensi Real-time
* **Input Data Tamu:** Pencatatan nama, email, telepon, dan alamat tamu.
* **Checkbox Presensi (AJAX):** Menandai kehadiran tamu hanya dengan satu klik tanpa reload halaman.
* **Waktu Kedatangan Real-time:** Sistem otomatis mencatat dan menampilkan jam/menit presisi saat tamu hadir (dicentang).

### 3. Antarmuka Modern
* **Dark Mode & Light Mode:** Tampilan fleksibel yang nyaman di mata, tersimpan otomatis sesuai preferensi pengguna.
* **Responsive Design:** Tampilan optimal di desktop maupun perangkat mobile.
* **Glassmorphism UI:** Desain visual yang estetik dan modern.

### 4. Pelaporan
* **Rekapitulasi Kehadiran:** Halaman khusus untuk melihat ringkasan siapa yang hadir dan tidak hadir.
* **Export Data:** (Opsional/Jika ada) Fitur unduh data tamu.

---

## Teknologi yang Digunakan

* **Backend:** Laravel 10/11 (PHP Framework)
* **Frontend:** Blade Templating, Bootstrap 5
* **Database:** SQLite
* **Scripting:** jQuery, AJAX (untuk presensi real-time)
* **Icons:** Bootstrap Icons

---

## Lisensi

Proyek ini dibuat untuk memenuhi tugas mata kuliah di Universitas Sebelas Maret. Bebas digunakan untuk tujuan pembelajaran.

---
**Copyright © 2025 - Mahasiswa PTIK 2023**
