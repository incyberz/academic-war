# Academic War

**Academic War** adalah Sistem Akademik Kampus berbasis Laravel dengan teknik **gamifikasi** untuk meningkatkan motivasi belajar mahasiswa dan memudahkan dosen serta pengelola akademik dalam mengelola data perkuliahan.

Dibuat oleh **Kang Solihin** pada **14 November 2025 - 15:56 WIB**.  
Hak cipta sepenuhnya milik Allah ﷻ.  
Silakan gunakan dan sebarkan untuk kebaikan.

Website: https://kangsolihin.web.id

---

## ✨ Fitur Utama

- 🎮 **Gamifikasi Akademik**
  - XP, level, badge
  - Leaderboard akademik
  - Reward dan progress mahasiswa

- 🧑‍🏫 **Manajemen Dosen**
  - Profil dosen, NIDN, gelar, jabatan fungsional
  - Integrasi akun users

- 🏫 **Manajemen Fakultas & Prodi**
  - Fakultas, kode fakultas
  - Prodi, jenjang (D3/S1/S2/S3), jumlah semester

- 🧑‍🎓 **Manajemen Mahasiswa** *(opsional, dapat ditambahkan)*

- 📚 **Data Akademik**
  - Mata kuliah
  - Jadwal kuliah
  - Kelas / Ruang kuliah
  - Kehadiran
  - Nilai

- ⚙️ **Dashboard Filament 3**
  - Tampilan admin modern
  - Form Builder & Table Builder otomatis

---

## 🛠️ Tech Stack

- **Laravel 11**
- **PHP 8.2+**
- **MySQL / MariaDB**
- **Filament 3.3**
- **TailwindCSS**
- Bahasa sistem **Indonesia**

---

## 📦 Instalasi

```bash
git clone https://github.com/your-repo/academic-war.git

cd academic-war

composer install
cp .env.example .env

php artisan key:generate
php artisan migrate --seed

php artisan serve
