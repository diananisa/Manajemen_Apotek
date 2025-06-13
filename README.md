<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<h2 align="center">📘 Tutorial Laravel untuk Pemula</h2>

Laravel adalah framework PHP yang populer untuk membangun aplikasi web modern dengan sintaks elegan dan efisien. Berikut panduan awal untuk menginstal dan menjalankan Laravel secara lokal.

---

## 🔧 Kebutuhan Awal (Download & Install)

Sebelum membuat project Laravel, siapkan tools berikut:

### ✅ Wajib Diunduh:
- **PHP** versi 8.1 atau lebih tinggi  
  → [https://windows.php.net/download/](https://windows.php.net/download/)

- **Composer** (PHP dependency manager)  
  → [https://getcomposer.org](https://getcomposer.org)

- **MySQL Server**  
  → [https://dev.mysql.com/downloads/mysql/](https://dev.mysql.com/downloads/mysql/)

- **MySQL Workbench** (untuk kelola database secara visual)  
  → [https://dev.mysql.com/downloads/workbench/](https://dev.mysql.com/downloads/workbench/)

- **Code Editor (rekomendasi: VS Code)**  
  → [https://code.visualstudio.com/](https://code.visualstudio.com/)

---

## 🚀 Cara Membuat Project Laravel

### 🟢 Dengan Laravel Installer:
```bash
composer global require laravel/installer
laravel new nama-proyek
cd nama-proyek
php artisan serve
