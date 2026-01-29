# Dokumentasi Lengkap - Sistem Informasi Penjaminan Mutu (SIPM)

## Daftar Isi
1. [Ringkasan Project](#ringkasan-project)
2. [Teknologi Stack](#teknologi-stack)
3. [Struktur Folder](#struktur-folder)
4. [Setup & Instalasi](#setup--instalasi)
5. [Database Schema](#database-schema)
6. [Role & Permission](#role--permission)
7. [API Routes](#api-routes)
8. [File Upload & Storage](#file-upload--storage)
9. [Development Guide](#development-guide)
10. [Troubleshooting](#troubleshooting)

---

## Ringkasan Project

**SIPM** (Sistem Informasi Penjaminan Mutu) adalah platform manajemen penjaminan mutu pendidikan yang dirancang untuk:

- Mengelola program dan kegiatan penjaminan mutu pendidikan
- Memetakan admin, fasilitator, dan peserta pada kegiatan
- Mengelola kelas dan batch/angkatan peserta
- Input nilai dan penilaian peserta
- Upload dan manajemen dokumen
- Laporan pembayaran dan validasi

**Last Updated**: 29 Januari 2026

---

## Teknologi Stack

### Backend
| Technology | Version | Purpose |
|------------|---------|---------|
| Laravel | 12.0 | Framework utama |
| PHP | 8.2+ | Server-side language |
| MySQL | 8.0+ | Database |
| Composer | Latest | Package manager PHP |

### Frontend
| Technology | Version | Purpose |
|------------|---------|---------|
| Bootstrap | 5 | CSS Framework |
| Vite | Latest | Build tool |
| Blade | 12.0 | Template engine |
| Alpine.js | - | JavaScript interactivity |

### DevOps & Tools
| Tool | Purpose |
|------|---------|
| Docker (Optional) | Containerization |
| Git | Version control |
| PHPUnit | Testing |
| Pint | Code style |

---

## Struktur Folder

```
LMS/
├── app/
│   ├── Console/
│   │   └── Commands/              # Custom artisan commands
│   ├── Http/
│   │   ├── Controllers/           # Business logic controllers
│   │   │   ├── Auth/
│   │   │   ├── SuperAdminController.php
│   │   │   ├── AdminController.php
│   │   │   ├── FasilitatorController.php
│   │   │   └── PesertaController.php
│   │   └── Middleware/            # Route & request middleware
│   ├── Mail/                      # Email notifications
│   ├── Models/                    # Eloquent models
│   └── Providers/                 # Service providers
├── bootstrap/
│   └── app.php                    # Application bootstrapping
├── config/                        # Configuration files
│   ├── app.php
│   ├── database.php
│   ├── mail.php
│   └── ...
├── database/
│   ├── migrations/                # Database migrations
│   ├── seeders/                   # Database seeders
│   └── factories/                 # Model factories
├── public/
│   ├── css/                       # Compiled CSS
│   ├── js/                        # Compiled JavaScript
│   ├── images/                    # Static images
│   └── index.php                  # Entry point
├── resources/
│   ├── css/                       # Source SCSS/CSS
│   │   ├── app.css
│   │   └── auth.css
│   ├── js/                        # Source JavaScript
│   ├── views/                     # Blade templates
│   │   ├── layouts/               # Layout templates
│   │   ├── auth/                  # Authentication views
│   │   ├── super-admin/           # Super admin dashboard
│   │   ├── admin/                 # Admin dashboard
│   │   ├── fasilitator/           # Fasilitator dashboard
│   │   └── peserta/               # Peserta dashboard
│   └── sass/                      # SCSS files
├── routes/
│   ├── web.php                    # Web routes
│   └── console.php                # Console routes
├── storage/
│   ├── app/
│   │   ├── public/                # Public file storage
│   │   │   ├── documents/
│   │   │   ├── payment-proofs/
│   │   │   └── surat-tugas/
│   │   └── private/               # Private file storage
│   ├── framework/                 # Framework cache
│   └── logs/                      # Application logs
├── tests/                         # Test files
│   ├── Unit/
│   ├── Feature/
│   └── TestCase.php
├── .env.example                   # Environment template
├── composer.json                  # PHP dependencies
├── package.json                   # Node dependencies
├── vite.config.js                 # Vite configuration
└── tailwind.config.js             # Tailwind configuration
```

---

## Setup & Instalasi

### Prerequisites
```bash
✓ PHP >= 8.2
✓ Composer 2.0+
✓ MySQL 8.0+
✓ Node.js 18+
✓ Git
```

### Instalasi Step-by-Step

#### 1. Clone Repository
```bash
git clone https://github.com/mahesapf/LMS.git
cd LMS
```

#### 2. Copy Environment File
```bash
cp .env.example .env
```

#### 3. Edit .env Configuration
```bash
APP_NAME="SIPM"
APP_DEBUG=false
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_penjaminan_mutu
DB_USERNAME=root
DB_PASSWORD=

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
```


## Database Schema

### Core Models & Tables

#### Users Table
```sql
id (PK)
name
email
password
npsn (nullable) -- untuk sekolah
role (super_admin, admin, fasilitator, peserta, sekolah)
phone
province
city
district
sub_district
address
status (active, suspended, pending_approval)
created_at
updated_at
```

#### Programs Table
```sql
id (PK)
name
description
start_date
end_date
created_by (FK -> users)
status (active, completed, archived)
created_at
updated_at
```

#### Activities Table
```sql
id (PK)
program_id (FK -> programs)
name
description
start_date
end_date
location
capacity
source_of_funds
status
created_at
updated_at
```

#### Classes Table
```sql
id (PK)
activity_id (FK -> activities)
batch_number
start_date
end_date
capacity
created_at
updated_at
```

#### Grades Table
```sql
id (PK)
class_id (FK -> classes)
peserta_id (FK -> users)
fasilitator_id (FK -> users)
score
notes
created_at
updated_at
```

#### Documents Table
```sql
id (PK)
class_id (FK -> classes)
user_id (FK -> users)
document_type (pdf, doc, image, video)
file_path
original_filename
file_size
status (pending, approved, rejected)
created_at
updated_at
```

#### Admin Mappings
```sql
id (PK)
user_id (FK -> users) -- admin
program_id (FK -> programs)
activity_id (FK -> activities)
role (in, move, out)
created_at
updated_at
```

#### Fasilitator Mappings
```sql
id (PK)
user_id (FK -> users) -- fasilitator
class_id (FK -> classes)
created_at
updated_at
```

#### Participant Mappings
```sql
id (PK)
user_id (FK -> users) -- peserta
class_id (FK -> classes)
status (in, move, out)
created_at
updated_at
```

---

## Role & Permission

### Super Admin
**Akses**: Dashboard dan menu penuh sistem

**Permissions**:
- CRUD Users (semua role)
- CRUD Programs
- CRUD Activities
- CRUD Classes
- Pemetaan Admin
- Validasi Pembayaran
- View Laporan

**Routes**: `/super-admin/*`

### Admin
**Akses**: Manajemen peserta dan kegiatan yang dipetakan

**Permissions**:
- View Classes
- Manajemen Peserta (In/Move/Out)
- View Grades
- View Documents

**Routes**: `/admin/*`

### Fasilitator
**Akses**: Input nilai dan manage dokumen

**Permissions**:
- View Kelas yang Diampu
- Input Nilai Peserta
- Upload Dokumen
- View Peserta di Kelas

**Routes**: `/fasilitator/*`

### Peserta
**Akses**: View Nilai dan Upload Dokumen

**Permissions**:
- View Kelas yang Diikuti
- View Nilai
- Upload Dokumen/Tugas
- Download Dokumen

**Routes**: `/peserta/*`

### Sekolah
**Akses**: Daftar peserta dan program

**Permissions**:
- Register untuk program
- View status pendaftaran
- Input data sekolah

**Routes**: `/sekolah/*`

---

## API Routes

### Authentication Routes
```
GET    /login                      Login form
POST   /login                      Process login
POST   /logout                     Logout
GET    /password/reset             Password reset form
```

### Public Routes
```
GET    /                           Homepage
GET    /news                       News list
GET    /news/{id}                  News detail
GET    /sekolah/register           School registration form
POST   /sekolah/register           Process registration
```

### Super Admin Routes (`/super-admin`)
```
GET    /dashboard                  Dashboard
GET    /users                      User list
POST   /users                      Create user
GET    /users/{user}/edit          Edit user
PUT    /users/{user}               Update user
DELETE /users/{user}               Delete user
POST   /users/import               Bulk import

GET    /programs                   Programs list
POST   /programs                   Create program
PUT    /programs/{program}         Update program

GET    /activities                 Activities list
POST   /activities                 Create activity
PUT    /activities/{activity}      Update activity

GET    /classes                    Classes list
GET    /admin-mappings             Admin mappings
POST   /admin-mappings             Create mapping
DELETE /admin-mappings/{mapping}   Delete mapping

GET    /payments                   Payment validation
POST   /payments/export            Export payments
```

### Admin Routes (`/admin`)
```
GET    /dashboard                  Admin dashboard
GET    /participants               Participants list
GET    /classes                    Classes list
GET    /classes/{class}/show       Class detail
```

### Fasilitator Routes (`/fasilitator`)
```
GET    /dashboard                  Dashboard
GET    /classes                    Kelas yang diampu
GET    /classes/{class}/detail     Class detail
GET    /classes/{class}/grades     Input nilai
POST   /classes/{class}/grades     Store grades
GET    /documents                  Documents list
```

### Peserta Routes (`/peserta`)
```
GET    /dashboard                  Dashboard
GET    /classes                    Kelas peserta
GET    /grades                     Nilai peserta
GET    /documents                  Dokumen peserta
POST   /documents                  Upload dokumen
DELETE /documents/{doc}            Delete dokumen
```

---

## File Upload & Storage

### Upload Locations

```
storage/app/public/
├── documents/              # Dokumen umum
├── payment-proofs/         # Bukti pembayaran
├── surat-tugas/            # Surat tugas peserta & fasilitator
├── sk_pendaftar/           # SK pendaftar sekolah
├── surat-tugas-kepala-sekolah/  # Surat tugas kepala sekolah
└── slider/                 # Slider images
```

### File Upload Validation

| Type | Max Size | Format |
|------|----------|--------|
| Document | 5 MB | pdf, doc, docx, jpg, jpeg, png |
| Payment Proof | 2 MB | jpg, jpeg, png, pdf |
| Surat Tugas | 2 MB | pdf, jpg, jpeg, png |
| SK | 2 MB | pdf, jpg, jpeg, png |

### Accessing Uploaded Files

```php
// Get file path
$path = $document->file_path;

// Download file
return Storage::download("public/{$path}");

// View file
$url = Storage::url("public/{$path}");
```

---

## Development Guide

### Creating New Controller

```bash
php artisan make:controller YourController --model=YourModel
```

### Creating New Model

```bash
php artisan make:model YourModel -m  # dengan migration
```

### Creating New Migration

```bash
php artisan make:migration create_table_name
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/YourTest.php

# With coverage
php artisan test --coverage
```

### Code Style

```bash
# Check code style
vendor/bin/pint --test

# Fix code style
vendor/bin/pint
```

### Database Commands

```bash
# Fresh migration (destructive)
php artisan migrate:fresh

# Rollback migration
php artisan migrate:rollback

# Seed database
php artisan db:seed

# Specific seeder
php artisan db:seed --class=UserSeeder
```

### Debugging

```php
// DD - Dump and Die
dd($variable);

// Dump - Just print
dump($variable);

// Log
Log::info('Message', ['key' => 'value']);
Log::error('Error occurred', $exception);
```

---

## Troubleshooting

### Issues Umum

#### 1. "SQLSTATE[HY000]: General error: 1030 Got error"
**Solusi:**
```bash
php artisan migrate:refresh
php artisan cache:clear
php artisan config:clear
```

#### 2. "Class not found"
**Solusi:**
```bash
composer dump-autoload
```

#### 3. Storage link tidak berfungsi
**Solusi:**
```bash
php artisan storage:link
# Verify: public/storage -> storage/app/public
```

#### 4. File tidak bisa di-upload
**Solusi:**
- Check storage folder permissions: `chmod -R 755 storage/`
- Verify upload_max_filesize di php.ini

#### 5. Session issue / Login loop
**Solusi:**
```bash
php artisan cache:clear
php artisan session:table
php artisan migrate
```

#### 6. Asset tidak ter-load
**Solusi:**
```bash
npm run build
# atau untuk dev
npm run dev
```

#### 7. Database connection error
**Solusi:**
- Verify credentials di .env
- Check MySQL service running
- Test connection: `php artisan migrate --pretend`

### Performance Tips

1. **Enable Query Caching**
   ```php
   // config/cache.php
   'default' => 'redis'
   ```

2. **Use Database Indexing**
   ```php
   // In migration
   $table->index('column_name');
   ```

3. **Optimize Images**
   ```bash
   npm install --save laravel-image-optimizer
   ```

4. **Enable Gzip Compression**
   ```
   # .htaccess atau nginx config
   ```

### Git Workflow

```bash
# Create branch
git checkout -b feature/your-feature

# Make changes
git add .
git commit -m "feat: your feature description"

# Push to remote
git push origin feature/your-feature

# Create Pull Request

# After approval, merge & delete branch
git checkout main
git pull origin main
git branch -d feature/your-feature
```

---

## Contact & Support

**Email**: cs@example.com
**Phone**: +62 (belum tersedia)
**Operating Hours**: Senin - Jumat, 08:00 - 17:00

**GitHub**: https://github.com/mahesapf/LMS

---

## License

Proprietary Software - Sistem Informasi Penjaminan Mutu

---

**Last Updated**: 29 Januari 2026
**Version**: 1.0.0
