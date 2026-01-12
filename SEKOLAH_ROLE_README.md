# Fitur Role Sekolah - Dokumentasi

## Ringkasan
Fitur ini menambahkan role baru "sekolah" yang memungkinkan sekolah untuk:
1. Mendaftar akun sendiri melalui form registrasi khusus
2. Menunggu approval dari super admin
3. Login menggunakan NPSN sebagai username dan password
4. Mendaftar kegiatan setelah akun disetujui

## Perubahan yang Dilakukan

### 1. Database Migration
**File**: `database/migrations/2026_01_12_152543_add_sekolah_role_and_fields_to_users.php`
- Menambahkan role 'sekolah' ke enum role
- Menambahkan kolom baru:
  - `provinsi` - Provinsi sekolah
  - `kabupaten` - Kabupaten/kota sekolah
  - `pendaftar` - Nama pendaftar
  - `sk_pendaftar` - Path file SK pendaftar
  - `approval_status` - Status approval (pending/approved/rejected)

### 2. Model User
**File**: `app/Models/User.php`
- Update `$fillable` array dengan field baru
- Menambahkan helper methods:
  - `isSekolah()` - Check apakah user role sekolah
  - `isApproved()` - Check apakah akun sudah disetujui
  - `isPending()` - Check apakah akun masih pending

### 3. Controllers Baru

#### SekolahRegisterController
**File**: `app/Http/Controllers/Auth/SekolahRegisterController.php`
- `showRegistrationForm()` - Menampilkan form registrasi sekolah
- `register()` - Handle registrasi sekolah dengan validasi dan upload SK

#### SekolahManagementController
**File**: `app/Http/Controllers/SekolahManagementController.php`
- `index()` - List semua sekolah dengan filter status
- `show()` - Detail sekolah
- `approve()` - Approve akun sekolah dan kirim email
- `reject()` - Tolak pendaftaran sekolah
- `downloadSK()` - Download file SK pendaftar
- `destroy()` - Hapus akun sekolah

#### SekolahController
**File**: `app/Http/Controllers/SekolahController.php`
- `dashboard()` - Dashboard sekolah dengan statistik
- `profile()` - Profil sekolah
- `updateProfile()` - Update profil sekolah
- `registrations()` - Daftar pendaftaran kegiatan

### 4. Middleware
**File**: `app/Http/Middleware/CheckSekolahApproved.php`
- Memastikan akun sekolah sudah approved sebelum akses dashboard
- Auto-logout jika akun pending atau rejected

### 5. Authentication Updates
**File**: `app/Http/Controllers/Auth/LoginController.php`
- Support login dengan NPSN (selain email)
- Check approval status saat login
- Redirect ke dashboard sekolah setelah login

### 6. Views

#### Form Registrasi Sekolah
**File**: `resources/views/auth/register-sekolah.blade.php`
- Form lengkap dengan semua field yang dibutuhkan
- Dropdown provinsi (38 provinsi)
- Dropdown jabatan pendaftar
- Upload SK pendaftar

#### Management Sekolah (Super Admin)
**File**: `resources/views/super-admin/sekolah/index.blade.php`
- List semua sekolah dengan filter status
- Tombol approve/reject/delete
- Badge status approval

**File**: `resources/views/super-admin/sekolah/show.blade.php`
- Detail lengkap sekolah
- Download SK pendaftar
- Tombol approve/reject

#### Dashboard Sekolah
**File**: `resources/views/sekolah/dashboard.blade.php`
- Statistik pendaftaran
- List pendaftaran terakhir
- Quick action buttons

**File**: `resources/views/layouts/sekolah.blade.php`
- Layout khusus untuk sekolah dengan sidebar menu

### 7. Email Notification
**File**: `app/Mail/SekolahApproved.php`
**File**: `resources/views/emails/sekolah-approved.blade.php`
- Email otomatis setelah approval
- Berisi kredensial login (NPSN sebagai username dan password)
- Instruksi untuk ganti password

### 8. Routes
**File**: `routes/web.php`
- Route registrasi sekolah (public)
- Route manajemen sekolah (super admin only)
- Route dashboard sekolah (auth + role sekolah)

### 9. Activity Registration Protection
**File**: `app/Http/Controllers/ActivityRegistrationController.php`
- Menambahkan auth check pada registration
- User harus login untuk daftar kegiatan
- Update ownership check pada payment

## Alur Penggunaan

### 1. Registrasi Sekolah
1. Sekolah mengakses halaman `/register/sekolah`
2. Mengisi form dengan data:
   - Nama sekolah
   - NPSN
   - Provinsi & Kabupaten
   - Nama kepala sekolah
   - Email belajar.id
   - No WhatsApp
   - Nama pendaftar & jabatan
   - Upload SK pendaftar
3. Submit form
4. Akun dibuat dengan status `pending` dan `inactive`

### 2. Approval oleh Super Admin
1. Super admin mengakses `/super-admin/sekolah`
2. Melihat list sekolah dengan status pending
3. Klik detail untuk melihat informasi lengkap
4. Klik tombol "Approve"
5. Sistem:
   - Update status menjadi `approved` dan `active`
   - Kirim email otomatis ke sekolah

### 3. Login Sekolah
1. Sekolah menerima email approval
2. Login menggunakan:
   - Username: NPSN
   - Password: NPSN (harus diganti setelah login pertama)
3. Redirect ke dashboard sekolah

### 4. Pendaftaran Kegiatan
1. Sekolah yang sudah login bisa akses `/activities`
2. Klik "Daftar" pada kegiatan yang diinginkan
3. Isi form pendaftaran
4. Submit dan lakukan pembayaran jika ada biaya

## Konfigurasi Email
Pastikan konfigurasi email di `.env` sudah benar:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Field Validation
- `npsn`: Required, unique, string max 20 karakter
- `email_belajar_id`: Required, unique, must end with @belajar.id
- `sk_pendaftar`: Required, file (pdf/jpg/jpeg/png), max 2MB
- `provinsi`: Required, dari dropdown
- `jabatan_pendaftar`: Required, Wakasek Kurikulum atau Wakasek Hubin/Humas

## Security
- Password default adalah NPSN (harus diganti setelah login pertama)
- Middleware `CheckSekolahApproved` memastikan hanya sekolah yang approved bisa akses dashboard
- File SK disimpan di `storage/app/public/sk_pendaftar/`
- Auth check pada semua endpoint pendaftaran kegiatan

## Testing
1. Registrasi sekolah: Akses `/register/sekolah`
2. Cek email setelah approval
3. Login dengan NPSN
4. Coba daftar kegiatan
5. Cek apakah non-login user tidak bisa daftar kegiatan

## File yang Ditambahkan
- app/Http/Controllers/Auth/SekolahRegisterController.php
- app/Http/Controllers/SekolahManagementController.php
- app/Http/Controllers/SekolahController.php
- app/Http/Middleware/CheckSekolahApproved.php
- app/Mail/SekolahApproved.php
- resources/views/auth/register-sekolah.blade.php
- resources/views/super-admin/sekolah/index.blade.php
- resources/views/super-admin/sekolah/show.blade.php
- resources/views/sekolah/dashboard.blade.php
- resources/views/layouts/sekolah.blade.php
- resources/views/emails/sekolah-approved.blade.php
- database/migrations/2026_01_12_152543_add_sekolah_role_and_fields_to_users.php

## File yang Dimodifikasi
- app/Models/User.php
- app/Http/Controllers/Auth/LoginController.php
- app/Http/Controllers/ActivityRegistrationController.php
- resources/views/auth/login.blade.php
- routes/web.php
- bootstrap/app.php
