# Sistem Informasi Penjaminan Mutu

Platform terpadu untuk mengelola program dan kegiatan penjaminan mutu pendidikan dengan 4 role berbeda: Super Admin, Admin, Fasilitator, dan Peserta.

## 🌟 Fitur Utama

### 🔐 Multi-Role Authentication
- **Super Admin**: Mengelola seluruh sistem, membuat akun, program, dan kegiatan
- **Admin**: Mengelola peserta, kegiatan, dan kelas
- **Fasilitator**: Mendampingi kegiatan dan menilai peserta
- **Peserta**: Mengikuti kegiatan dan mengunggah dokumen

### 📚 Manajemen Program & Kegiatan
- Kelola program penjaminan mutu
- Buat dan kelola kegiatan dengan batch, tanggal, dan sumber pembiayaan
- Buat kelas untuk setiap kegiatan

### 👥 Manajemen Pengguna
- CRUD untuk semua role pengguna
- Import pengguna massal dari CSV
- Suspend/Activate akun
- Pemetaan admin, fasilitator, dan peserta (In, Move, Out)

### 📊 Penilaian
- Input nilai peserta oleh fasilitator
- Multiple assessment types
- View nilai untuk peserta

### 📄 Manajemen Dokumen
- Upload surat tugas (fasilitator & peserta)
- Upload tugas kegiatan (peserta)
- Download dan delete dokumen

## ⚙️ Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5 + Vite
- **Authentication**: Laravel UI

## 📦 Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

1. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Setup database**
   - Database sudah dibuat: `lms_penjaminan_mutu`

3. **Run migrations & seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Build assets**
   ```bash
   npm run build
   ```

5. **Create storage link**
   ```bash
   php artisan storage:link
   ```

6. **Start server**
   ```bash
   php artisan serve
   ```

## 🔑 Default Login

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@example.com | password |
| Admin | admin@example.com | password |
| Fasilitator | fasilitator@example.com | password |
| Peserta | peserta@example.com | password |

## 📱 Alur Sistem

1. Pengguna akses halaman awal untuk melihat beranda dan berita
2. Login dengan memilih role
3. **Super Admin**: Buat akun, program, kegiatan, pemetaan admin
4. **Admin**: Buat kelas, atur batch/waktu/peserta, pemetaan peserta
5. **Fasilitator**: Lengkapi biodata, input nilai, upload dokumen
6. **Peserta**: Lengkapi biodata, upload dokumen/tugas, lihat nilai

## 📚 Database Structure

- **users** - Multi-role users (super_admin, admin, fasilitator, peserta)
- **programs** - Program penjaminan mutu
- **activities** - Kegiatan dalam program
- **classes** - Kelas untuk kegiatan
- **admin_mappings** - Pemetaan admin ke program/kegiatan
- **fasilitator_mappings** - Pemetaan fasilitator ke kelas
- **participant_mappings** - Pemetaan peserta ke kelas (In/Move/Out)
- **grades** - Nilai peserta
- **documents** - Upload dokumen
- **news** - Berita untuk halaman publik

## 🛣️ Routes

### Public
- `/` - Beranda
- `/news` - Berita

### Super Admin
- `/super-admin/users` - Manajemen pengguna
- `/super-admin/programs` - Program
- `/super-admin/activities` - Kegiatan
- `/super-admin/admin-mappings` - Pemetaan admin

### Admin
- `/admin/participants` - Manajemen peserta
- `/admin/classes` - Manajemen kelas
- `/admin/classes/{id}/participants` - Pemetaan peserta

### Fasilitator
- `/fasilitator/classes` - Kelas yang diampu
- `/fasilitator/classes/{id}/grades` - Input nilai
- `/fasilitator/documents` - Dokumen

### Peserta
- `/peserta/classes` - Kelas yang diikuti
- `/peserta/grades` - Nilai
- `/peserta/documents` - Dokumen

## 📝 License

Proprietary - Sistem Informasi Penjaminan Mutu
