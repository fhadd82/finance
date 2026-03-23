<div align="center">
  <a href="#-mykewangan---modern-financial-management-system">🇬🇧 English</a> •
  <a href="#-mykewangan---sistem-pengurusan-kewangan-moden">🇲🇾 Bahasa Melayu</a>
</div>

---

# 🇬🇧 📊 MyKewangan - Modern Financial Management System

![Financial System Banner](/images/screenshot/banner.png)

**MyKewangan** (Expense Tracking System) is a PHP-based web application specially designed to help users track cash flow (income and expenses) easily and securely. 

The system features a modern user interface utilizing **Glassmorphism** and **Mesh Gradient** concepts, making it highly responsive, fast, and visually appealing across all devices (PC, Tablet, and Smartphones).

Demo Account : https://fhadd.com/finance/login.php (Please Register Here)
---

## ✨ Key Features

* **🔐 High Security (Fintech-Grade):**
    * Client-side login encryption using **AES-128** via *CryptoJS*. 
    * **Sign in with Google** (Google OAuth) integration support. (Not Support for Github version)
    * **Auto-Logout** feature after 15 minutes of inactivity to prevent session hijacking.
* **💸 Intuitive Transaction Management:**
    * Easily record income and expenses.
    * Color-coded expense categories (e.g., Commitments, Needs, Investments).
    * Special tagging for **Tax Relief (LHDN)** for future eFiling reference.
* **🧾 Digital Receipt Management:**
    * Upload supporting receipts in Image (JPG, PNG) and PDF formats.
    * Built-in preview modal without the need to download the file first.
* **📱 Premium & Responsive Interface:**
    * Modern design powered by **Tailwind CSS** and fast interactions with **Alpine.js**.
    * Full **Dark Mode** support.

---

## 📸 Screenshots

| Login (Glassmorphism) | New Account Registration | Dashboard / List |
| :---: | :---: | :---: |
| ![Login](/images/screenshot/login.png) | ![Register](/images/screenshot/register.png) | ![Dashboard](/images/screenshot/dashboard1.png) |

---

## 🛠️ Technologies Used

* **Frontend:** HTML5, Tailwind CSS, Alpine.js, FontAwesome 6
* **Backend:** PHP 8.x
* **Database:** MySQL / MariaDB
* **Security:** CryptoJS (AES-128), Google OAuth 2.0 (Not This Version)

---

## 🚀 Installation Guide

Please follow the steps below to run this system on your local machine (*Localhost*):

1. **Clone the Repository:**

   ```bash
   git clone [https://github.com/your-username/mykewangan.git](https://github.com/your-username/mykewangan.git)
   ```

2. **Setup Web Server:**
   Use software like XAMPP, Laragon, or MAMP. Move the cloned folder into your `htdocs` or `www` directory.

3. **Database Configuration:**
   * Open phpMyAdmin.
   * Create a new database (e.g., `db_kewangan`).
   * Import the provided `database.sql` file into the new database.

4. **Connection Configuration:**
   * Open the `include/` folder and find the database connection file (usually `dbcommon.php` or `connection.php`).
   * Update the *hostname*, *username*, *password*, and *database name* according to your localhost settings.

5. **Login to the System:**
   Open your web browser and navigate to `http://localhost/mykewangan`.

<br><br><br>

*This is Malay Version. Contact me admin[@]fhadd.com for English Version.
---
---

# 🇲🇾 📊 MyKewangan - Sistem Pengurusan Kewangan Moden

![Sistem Kewangan Banner](/images/screenshot/banner.png)

**MyKewangan** (Sistem Pemantauan Perbelanjaan) adalah sebuah aplikasi web berasaskan PHP yang direka khas untuk membantu pengguna menjejak aliran tunai (pendapatan dan perbelanjaan) dengan mudah dan selamat. 

Sistem ini menampilkan antaramuka menggunakan konsep **Glassmorphism** dan **Mesh Gradient**, menjadikannya sangat responsif, pantas, dan sedap mata memandang di semua peranti (PC, Tablet, dan Telefon Pintar).

Demo Account : https://fhadd.com/finance/login.php (Sila Daftar Di Sini)
Emel ke admin@fhadd.com untuk info lanjut.
---

## ✨ Ciri-ciri Utama

* **🔐 Keselamatan Tinggi (Fintech-Grade):**
    * Log masuk dengan pengesulitan **AES-128** di bahagian klien (client-side) menggunakan *CryptoJS*.
    * Sokongan integrasi **Log Masuk dengan Google** (Google OAuth). (Bukan Versi ini)
    * Fungsi **Auto-Logout** jika tiada aktiviti selama 15 minit untuk mengelakkan pencerobohan sesi.
* **💸 Pengurusan Transaksi Intuitif:**
    * Rekod pendapatan dan perbelanjaan dengan mudah.
    * Kategori perbelanjaan berkod warna (cth: Komitmen, Keperluan, Pelaburan).
    * Fungsi penandaan khas untuk **Pelepasan Cukai** untuk rujukan akan datang ketika proses pemfailan cukai.
* **🧾 Pengurusan Resit Digital:**
    * Muat naik resit sokongan dalam format Imej (JPG, PNG) dan PDF.
    * Paparan pratonton (preview modal) terbina dalam tanpa perlu memuat turun fail terlebih dahulu.
* **📱 Antaramuka Premium & Responsif:**
    * Reka bentuk moden menggunakan **Tailwind CSS** dan interaksi pantas dengan **Alpine.js**.
    * Sokongan *Dark Mode* (Mod Gelap).

---

## 📸 Tangkapan Skrin (Screenshots)

| Log Masuk (Glassmorphism) | Pendaftaran Akaun Baru | Papan Pemuka / Senarai |
| :---: | :---: | :---: |
| ![Login](/images/screenshot/login.png) | ![Register](/images/screenshot/register.png) | ![Dashboard](/images/screenshot/dashboard1.png) |

---

## 🛠️ Teknologi Yang Digunakan

* **Bahagian Hadapan (Frontend):** HTML5, Tailwind CSS, Alpine.js, FontAwesome 6
* **Bahagian Belakang (Backend):** PHP 8.x
* **Pangkalan Data (Database):** MySQL / MariaDB
* **Keselamatan:** CryptoJS (AES-128), Google OAuth 2.0 (Bukan untuk versi ini)

---

## 🚀 Cara Pemasangan (Installation)

Sila ikuti langkah di bawah untuk menjalankan sistem ini di komputer anda (*Localhost*):

1. **Muat turun / Clone Repositori:**

   ```bash
   git clone [https://github.com/username-anda/mykewangan.git](https://github.com/username-anda/mykewangan.git)
   ```

2. **Sediakan Pelayan Web (Web Server):**
   Gunakan perisian seperti XAMPP, Laragon, atau MAMP. Pindahkan folder yang di-*clone* ke dalam folder `htdocs` atau `www`.

3. **Pangkalan Data (Database):**
   * Buka phpMyAdmin.
   * Cipta pangkalan data baharu (contoh: `db_kewangan`).
   * Import fail `database.sql` (jika disediakan) ke dalam pangkalan data tersebut.

4. **Konfigurasi Sambungan (Connection):**
   * Buka folder `include/` dan cari fail sambungan pangkalan data (biasanya `dbcommon.php` atau `connection.php`).
   * Kemas kini butiran *hostname*, *username*, *password*, and *database name* mengikut tetapan localhost anda.

5. **Log Masuk ke Sistem:**
   Buka pelayar web dan layari `http://localhost/mykewangan`.

---
*Dibuat dengan ❤️ untuk pengurusan kewangan yang lebih baik.*
