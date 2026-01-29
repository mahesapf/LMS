#  Sistem Informasi Penjaminan Mutu (SIPM)

Platform terpadu untuk mengelola program dan kegiatan penjaminan mutu pendidikan dengan sistem multi-role yang komprehensif.

[![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.0-7952B3?style=flat&logo=bootstrap)](https://getbootstrap.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql)](https://mysql.com)

> **Status**: Production Ready | **Version**: 1.0.0 | **Last Updated**: 29 Januari 2026

##  Fitur Utama

###  Multi-Role Authentication System
- **Super Admin**: Mengelola seluruh sistem, membuat akun, program, dan kegiatan
- **Admin**: Mengelola peserta, kegiatan, dan kelas
- **Fasilitator**: Mendampingi kegiatan dan menilai peserta
- **Peserta**: Mengikuti kegiatan dan mengunggah dokumen
- **Sekolah**: Mendaftar program dan mengelola guru binaan

###  Manajemen Program & Kegiatan
- Kelola program penjaminan mutu pendidikan
- Buat dan kelola kegiatan dengan batch, tanggal, dan sumber pembiayaan
- Sistem kelas dengan kapasitas dan jadwal yang fleksibel
- Pemetaan admin, fasilitator, dan peserta (In/Move/Out)

###  Manajemen Pengguna
- CRUD lengkap untuk semua role pengguna
- Import pengguna massal dari CSV/Excel
- Suspend/Activate akun dengan tracking status
- Manajemen biodata dan profil pengguna
- Validasi dan approval akun sekolah

###  Sistem Penilaian
- Input nilai peserta oleh fasilitator
- Multiple assessment types dan komponen nilai
- View nilai real-time untuk peserta
- Laporan dan export nilai

###  Manajemen Dokumen
- Upload surat tugas untuk fasilitator & peserta
- Upload tugas kegiatan dan dokumen pendukung
- Download, view, dan delete dokumen
- Validasi file (size, format, security)
- Kategorisasi dokumen berdasarkan tipe

###  Validasi Pembayaran
- Upload bukti pembayaran peserta
- Validasi pembayaran oleh admin
- Export data pembayaran
- Tracking status pembayaran

###  Modul Sekolah
- Registrasi sekolah secara mandiri
- Input data sekolah lengkap (NPSN, alamat, kontak)
- Daftar peserta untuk program/kegiatan
- Tracking status approval pendaftaran

##  Teknologi Stack

| Component | Technology | Version |
|-----------|-----------|---------|
| Framework | Laravel | 12.0 |
| Language | PHP | 8.2+ |
| Database | MySQL | 8.0+ |
| Frontend | Bootstrap | 5.0 |
| Build Tool | Vite | Latest |
| Template | Blade | 12.0 |
| Auth | Laravel UI | 4.6 |
| Cache (Optional) | Redis | 7.0 |

### Key Features
- ✅ Responsive design dengan Bootstrap 5
- ✅ Modern build system dengan Vite
- ✅ Component-based architecture
- ✅ Role-based access control (RBAC)
- ✅ File upload & management system
- ✅ Export data (CSV/Excel)
- ✅ Email notifications
- ✅ Security best practices

##  Instalasi

### Prerequisites
```
✓ PHP >= 8.2
✓ Composer 2.0+
✓ MySQL 8.0+
✓ Node.js 18+ & NPM
✓ Git
```

### Quick Start

1. **Clone Repository**
   ```bash
   git clone https://github.com/mahesapf/LMS.git
   cd LMS
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Edit `.env` file:
   ```env
   DB_DATABASE=lms_penjaminan_mutu
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Database Setup**
   ```bash
   # Create database terlebih dahulu
   php artisan migrate:fresh --seed
   ```

5. **Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Build Assets**
   ```bash
   # Development
   npm run dev
   
   # Production
   npm run build
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```
   
   Access: `http://127.0.0.1:8000`

##  Default Login Credentials

Setelah menjalankan seeder, gunakan kredensial berikut untuk login:

| Role | Email | Password | Dashboard |
|------|-------|----------|-----------|
| Super Admin | superadmin@example.com | password | `/super-admin/dashboard` |
| Admin | admin@example.com | password | `/admin/dashboard` |
| Fasilitator | fasilitator@example.com | password | `/fasilitator/dashboard` |
| Peserta | peserta@example.com | password | `/peserta/dashboard` |
| Sekolah | - | - | Register via `/sekolah/register` |

>  **Security Note**: Segera ubah password default setelah login pertama kali di production!

##  Alur Sistem

### Flow Diagram
```
┌─────────────┐
│   Landing   │──► Login
│    Page     │
└─────────────┘
       │
       ├──► Super Admin ──► Manage Users/Programs/Activities
       │                  └──► Admin Mapping
       │
       ├──► Admin ──────────► Manage Classes/Participants
       │                    └──► Participant Mapping (In/Move/Out)
       │
       ├──► Fasilitator ───► View Classes
       │                   ├──► Input Grades
       │                   └──► Upload Documents
       │
       ├──► Peserta ───────► View Classes
       │                   ├──► View Grades
       │                   └──► Upload Documents/Tasks
       │
       └──► Sekolah ───────► Register Account
                           └──► Register for Programs
```

### Step-by-Step Process

1. **Public Access**
   - Akses homepage untuk melihat informasi umum dan berita
   - Registrasi sekolah melalui form pendaftaran publik

2. **Super Admin Workflow**
   - Login dan akses dashboard Super Admin
   - Buat dan kelola users untuk semua role
   - Buat program penjaminan mutu
   - Buat kegiatan dalam program
   - Pemetaan admin ke program/kegiatan

3. **Admin Workflow**
   - Login dan akses dashboard Admin
   - Buat kelas untuk kegiatan yang ditugaskan
   - Atur batch, jadwal, dan kapasitas kelas
   - Pemetaan peserta ke kelas (In/Move/Out)
   - Validasi pembayaran peserta

4. **Fasilitator Workflow**
   - Login dan akses dashboard Fasilitator
   - View kelas yang diampu
   - Input nilai untuk peserta di kelas
   - Upload dokumen surat tugas
   - Monitor progress peserta

5. **Peserta Workflow**
   - Login dan akses dashboard Peserta
   - Lengkapi biodata dan profil
   - View kelas yang diikuti
   - Upload dokumen dan tugas kegiatan
   - View nilai dan feedback
   - Upload bukti pembayaran

6. **Sekolah Workflow**
   - Registrasi akun sekolah
   - Input data sekolah (NPSN, alamat, dll)
   - Menunggu approval dari admin
   - Setelah approved: daftar peserta untuk program
   - Upload dokumen persyaratan

##  Database Structure

### Core Tables

| Tabel | Deskripsi | Key Columns |
|-------|-----------|-------------|
| **users** | Data pengguna multi-role | `id`, `name`, `email`, `role`, `password` |
| **programs** | Program penjaminan mutu | `id`, `name`, `description`, `created_by` |
| **activities** | Kegiatan dalam program | `id`, `program_id`, `name`, `description` |
| **classes** | Kelas untuk kegiatan | `id`, `activity_id`, `name`, `batch`, `schedule` |
| **participants** | Data peserta | `id`, `user_id`, `sekolah_id`, `npsn` |
| **class_participant** | Mapping peserta ke kelas | `class_id`, `participant_id`, `status` |
| **admin_program** | Mapping admin ke program | `user_id`, `program_id` |
| **admin_activity** | Mapping admin ke kegiatan | `user_id`, `activity_id` |
| **grades** | Nilai peserta | `id`, `participant_id`, `class_id`, `score` |
| **news** | Berita dan artikel | `id`, `title`, `content`, `created_by` |
| **documents** | Upload dokumen | `id`, `user_id`, `class_id`, `type`, `path` |
| **sekolah** | Data sekolah | `id`, `user_id`, `npsn`, `name`, `address` |
| **pendaftaran_program_sekolah** | Pendaftaran sekolah ke program | `id`, `sekolah_id`, `program_id`, `status` |

### Key Relationships

```
users (1) ───< (n) participants
programs (1) ───< (n) activities  
activities (1) ───< (n) classes
classes (n) ───< (n) participants (via class_participant)
participants (1) ───< (n) grades
users (n) ───< (n) programs (via admin_program)
users (n) ───< (n) activities (via admin_activity)
sekolah (1) ───< (n) participants
sekolah (n) ───< (n) programs (via pendaftaran_program_sekolah)
```

### Important Enums

- **users.role**: `super_admin`, `admin`, `fasilitator`, `peserta`, `sekolah`
- **classes.batch**: `1`, `2`, `3`, dst
- **grades.status**: `lulus`, `tidak_lulus`, `pending`
- **pendaftaran_program_sekolah.status**: `pending`, `approved`, `rejected`
- **documents.type**: `surat_tugas`, `tugas_peserta`, `bukti_pembayaran`, `persyaratan_sekolah`

>  **Tip**: Gunakan `php artisan migrate:status` untuk melihat status migrasi

##  Routes Structure

###  Public Routes
```
GET  /                    - Homepage dengan berita terbaru
GET  /news                - Halaman berita lengkap
GET  /news/{id}           - Detail berita
GET  /sekolah/register    - Form registrasi sekolah
POST /sekolah/register    - Submit registrasi sekolah
```

###  Authentication Routes
```
GET  /login               - Halaman login
POST /login               - Submit login
POST /logout              - Logout user
GET  /register            - Form register
POST /register            - Submit register
GET  /password/request    - Halaman kontak CS (lupa password)
```

###  Super Admin Routes (`/super-admin`)
```
# User Management
GET    /super-admin/users              - List semua users
GET    /super-admin/users/create       - Form buat user
POST   /super-admin/users              - Store user baru
GET    /super-admin/users/{id}/edit    - Form edit user
PUT    /super-admin/users/{id}         - Update user
DELETE /super-admin/users/{id}         - Hapus user

# Program Management
GET    /super-admin/programs           - List programs
GET    /super-admin/programs/create    - Form buat program
POST   /super-admin/programs           - Store program
GET    /super-admin/programs/{id}/edit - Form edit program
PUT    /super-admin/programs/{id}      - Update program
DELETE /super-admin/programs/{id}      - Hapus program

# Activity Management
GET    /super-admin/activities         - List activities
GET    /super-admin/activities/create  - Form buat activity
POST   /super-admin/activities         - Store activity
GET    /super-admin/activities/{id}/edit - Form edit activity
PUT    /super-admin/activities/{id}    - Update activity
DELETE /super-admin/activities/{id}    - Hapus activity

# Admin Mapping
GET    /super-admin/admin-mappings     - Pemetaan admin ke program/kegiatan
POST   /super-admin/admin-mappings     - Store mapping
DELETE /super-admin/admin-mappings/{id} - Hapus mapping

# News Management
GET    /super-admin/news               - List berita
GET    /super-admin/news/create        - Form buat berita
POST   /super-admin/news               - Store berita
GET    /super-admin/news/{id}/edit     - Form edit berita
PUT    /super-admin/news/{id}          - Update berita
DELETE /super-admin/news/{id}          - Hapus berita
```

###  Admin Routes (`/admin`)
```
# Participant Management
GET    /admin/participants             - List peserta
GET    /admin/participants/create      - Form buat peserta
POST   /admin/participants             - Store peserta
GET    /admin/participants/{id}/edit   - Form edit peserta
PUT    /admin/participants/{id}        - Update peserta
DELETE /admin/participants/{id}        - Hapus peserta

# Class Management
GET    /admin/classes                  - List kelas
GET    /admin/classes/create           - Form buat kelas
POST   /admin/classes                  - Store kelas
GET    /admin/classes/{id}/edit        - Form edit kelas
PUT    /admin/classes/{id}             - Update kelas
DELETE /admin/classes/{id}             - Hapus kelas

# Class Participant Mapping (In/Move/Out)
GET    /admin/classes/{id}/participants - Pemetaan peserta ke kelas
POST   /admin/classes/{id}/participants/map - Map peserta (In)
POST   /admin/classes/{id}/participants/move - Move peserta antar kelas
DELETE /admin/classes/{id}/participants/{participant_id} - Remove peserta (Out)

# Payment Validation
GET    /admin/payments                 - List pembayaran pending
POST   /admin/payments/{id}/validate   - Validasi pembayaran

# Sekolah Management
GET    /admin/sekolah                  - List sekolah
GET    /admin/sekolah/{id}             - Detail sekolah
POST   /admin/sekolah/{id}/approve     - Approve sekolah
POST   /admin/sekolah/{id}/reject      - Reject sekolah
```

###  Fasilitator Routes (`/fasilitator`)
```
# Classes
GET  /fasilitator/classes              - Kelas yang diampu
GET  /fasilitator/classes/{id}         - Detail kelas

# Grades
GET  /fasilitator/classes/{id}/grades  - Input nilai untuk kelas
POST /fasilitator/grades                - Store nilai
PUT  /fasilitator/grades/{id}          - Update nilai

# Documents
GET  /fasilitator/documents            - Upload surat tugas
POST /fasilitator/documents            - Store dokumen
GET  /fasilitator/documents/{id}       - Download dokumen
DELETE /fasilitator/documents/{id}     - Hapus dokumen
```

###  Peserta Routes (`/peserta`)
```
# Profile
GET  /peserta/profile                  - Biodata peserta
PUT  /peserta/profile                  - Update biodata

# Classes
GET  /peserta/classes                  - Kelas yang diikuti
GET  /peserta/classes/{id}             - Detail kelas

# Grades
GET  /peserta/grades                   - Lihat nilai
GET  /peserta/classes/{id}/grades      - Nilai per kelas

# Documents
GET  /peserta/documents                - Upload tugas
POST /peserta/documents                - Store dokumen
GET  /peserta/documents/{id}           - Download dokumen

# Payment
POST /peserta/payment                  - Upload bukti pembayaran
```

###  Sekolah Routes (`/sekolah`)
```
# Dashboard
GET  /sekolah/dashboard                - Dashboard sekolah

# Profile
GET  /sekolah/profile                  - Data sekolah
PUT  /sekolah/profile                  - Update data sekolah

# Program Registration
GET  /sekolah/programs                 - List program tersedia
POST /sekolah/programs/{id}/register   - Daftar ke program
GET  /sekolah/registrations            - List pendaftaran

# Participant Registration
GET  /sekolah/participants             - List peserta sekolah
GET  /sekolah/participants/create      - Form daftar peserta
POST /sekolah/participants             - Submit peserta
```

###  Middleware Protection

| Route Group | Middleware | Accessible By |
|-------------|-----------|---------------|
| `/super-admin/*` | `auth`, `role:super_admin` | Super Admin only |
| `/admin/*` | `auth`, `role:admin` | Admin only |
| `/fasilitator/*` | `auth`, `role:fasilitator` | Fasilitator only |
| `/peserta/*` | `auth`, `role:peserta` | Peserta only |
| `/sekolah/*` | `auth`, `role:sekolah` | Sekolah only |
| `/login`, `/register` | `guest` | Unauthenticated users |

>  **Full route list**: Jalankan `php artisan route:list` untuk melihat semua routes

---

##  Documentation

Untuk informasi lebih lengkap, lihat dokumentasi tambahan:

- **[DOCUMENTATION.md](DOCUMENTATION.md)** - Dokumentasi teknis lengkap sistem
- **[API_REFERENCE.md](API_REFERENCE.md)** - Developer guide dan API patterns
- **[DEPLOYMENT.md](DEPLOYMENT.md)** - Panduan deployment dan DevOps
- **[DOCS_SUMMARY.md](DOCS_SUMMARY.md)** - Ringkasan dan navigasi dokumentasi
- **[CHECKLIST.md](CHECKLIST.md)** - Development workflow checklist

##  Contributing

Sistem ini dikembangkan untuk internal **Penjaminan Mutu Pendidikan**. Untuk kontribusi:

1. Fork repository
2. Buat branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

##  Support & Contact

Jika lupa password atau mengalami masalah login:

- ** Customer Service**: 0812-3456-7890
- ** Email**: support@penjaminanmutu.id
- ** Jam Operasional**: Senin - Jumat, 08:00 - 16:00 WIB

##  License

Proprietary - **Sistem Informasi Penjaminan Mutu Pendidikan**

© 2025 All Rights Reserved

---

**Built with  using Laravel 12 & Bootstrap 5**
