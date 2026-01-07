# Sistem Pendaftaran dan Pembayaran Program LMS

## Fitur Baru yang Ditambahkan

### 1. **Pembiayaan Program**
Super Admin dapat mengatur pembiayaan program dengan:
- Jenis Pembiayaan: APBN atau Non-APBN
- Tipe APBN: BOS Reguler, BOS Kinerja, atau DIPA
- Biaya Pendaftaran

### 2. **Pendaftaran Program untuk Peserta**

#### Alur Pendaftaran:
1. **Melihat Program Tersedia**
   - Peserta dapat melihat daftar program aktif di menu "Program Tersedia"
   - Menampilkan detail: nama, deskripsi, tanggal pelaksanaan, biaya, jenis pembiayaan

2. **Mendaftar Program**
   - Klik "Lihat Detail & Daftar" pada program yang diminati
   - Isi form pendaftaran dengan data:
     - Nama Lengkap
     - Nomor Telepon
     - Email
     - Jabatan (Kepala Sekolah / Guru)
     - Nama Sekolah

3. **Upload Bukti Pembayaran**
   - Setelah mendaftar, peserta diarahkan ke halaman pembayaran
   - Isi informasi pembayaran:
     - Nama Bank
     - Jumlah yang Dibayar
     - Tanggal Pembayaran
     - Upload Bukti Pembayaran (JPG/PNG, max 2MB)
   - **Deadline**: Pembayaran harus dilakukan maksimal 1 minggu sebelum program dimulai

4. **Menunggu Validasi Admin**
   - Status: "Menunggu Validasi"
   - Peserta dapat melihat status pendaftaran di halaman "Program Tersedia"

### 3. **Validasi Pembayaran oleh Admin**

Admin dapat:
- Melihat daftar pembayaran yang menunggu validasi
- Melihat detail pembayaran dan bukti transfer
- **Validasi** pembayaran yang sesuai
- **Tolak** pembayaran dengan memberikan alasan
- Melihat riwayat validasi pembayaran

### 4. **Pengelolaan Peserta Tervalidasi**

Super Admin/Admin dapat:
- Melihat daftar peserta yang sudah tervalidasi pembayarannya
- **Assign peserta ke kelas** tertentu
- Setelah di-assign, peserta otomatis menjadi participant mapping di kelas tersebut
- Menghapus peserta dari kelas jika diperlukan

### 5. **Status Pendaftaran**

Status yang digunakan:
- `pending` - Pendaftaran baru dibuat
- `payment_pending` - Menunggu upload pembayaran
- `payment_uploaded` - Bukti pembayaran sudah diupload, menunggu validasi
- `validated` - Pembayaran tervalidasi, siap di-assign ke kelas
- `rejected` - Pembayaran ditolak

### 6. **Status Pembayaran**

- `pending` - Menunggu validasi admin
- `validated` - Divalidasi oleh admin
- `rejected` - Ditolak oleh admin

## Database Tables

### Tabel: `registrations`
Menyimpan data pendaftaran peserta:
- program_id
- user_id
- name, phone, email
- position (Kepala Sekolah/Guru)
- school_name
- status
- class_id (nullable, diisi setelah di-assign)

### Tabel: `payments`
Menyimpan data pembayaran:
- registration_id
- bank_name
- amount
- payment_date
- proof_file (path ke file bukti)
- status
- validated_by (user_id admin)
- validated_at
- rejection_reason (jika ditolak)

## Routes Baru

### Peserta Routes:
- `GET /peserta/programs` - Daftar program tersedia
- `GET /peserta/programs/{program}` - Detail program
- `POST /peserta/programs/{program}/register` - Daftar program
- `GET /peserta/registrations/{registration}/payment` - Form pembayaran
- `POST /peserta/registrations/{registration}/payment` - Upload pembayaran

### Admin Routes:
- `GET /admin/payments` - Daftar pembayaran untuk validasi
- `PATCH /admin/payments/{payment}/validate` - Validasi pembayaran
- `PATCH /admin/payments/{payment}/reject` - Tolak pembayaran
- `GET /admin/registrations` - Daftar peserta tervalidasi
- `PATCH /admin/registrations/{registration}/assign` - Assign ke kelas
- `DELETE /admin/registrations/{registration}/remove` - Hapus dari kelas

## Controllers

1. **ProgramRegistrationController** - Handle pendaftaran dan pembayaran peserta
2. **PaymentValidationController** - Handle validasi pembayaran oleh admin
3. **RegistrationManagementController** - Handle pengelolaan peserta tervalidasi

## Models

1. **Registration** - Model untuk pendaftaran
2. **Payment** - Model untuk pembayaran
3. **Program** - Updated dengan field financing_type, apbn_type, registration_fee

## Views

### Peserta Views:
- `resources/views/peserta/programs/index.blade.php` - List program
- `resources/views/peserta/programs/show.blade.php` - Detail program
- `resources/views/peserta/payment/create.blade.php` - Form pembayaran

### Admin Views:
- `resources/views/admin/payments/index.blade.php` - Validasi pembayaran
- `resources/views/admin/registrations/index.blade.php` - Kelola peserta

### Super Admin Views:
- Updated `resources/views/super-admin/programs/create.blade.php` - Tambah field pembiayaan
- Updated `resources/views/super-admin/programs/edit.blade.php` - Edit field pembiayaan

## Cara Menggunakan

### Sebagai Super Admin:
1. Buat program baru dengan mengisi informasi pembiayaan
2. Setelah ada peserta tervalidasi, assign mereka ke kelas yang sesuai

### Sebagai Admin:
1. Validasi pembayaran peserta yang masuk
2. Lihat daftar peserta tervalidasi
3. Assign peserta ke kelas (jika diberikan akses)

### Sebagai Peserta:
1. Buka menu "Program Tersedia"
2. Pilih program yang diminati
3. Klik "Lihat Detail & Daftar"
4. Isi form pendaftaran
5. Upload bukti pembayaran
6. Tunggu validasi dari admin
7. Setelah divalidasi dan di-assign ke kelas, bisa mulai mengikuti program

## Catatan Penting

1. **Storage**: File bukti pembayaran disimpan di `storage/app/public/payment-proofs`
   - Pastikan symlink storage sudah dibuat: `php artisan storage:link`

2. **Deadline Pembayaran**: Sistem akan memvalidasi bahwa pembayaran harus dilakukan maksimal 1 minggu sebelum program dimulai

3. **Validasi**: Hanya admin yang bisa memvalidasi pembayaran

4. **Assign Kelas**: Peserta baru bisa di-assign ke kelas setelah pembayaran tervalidasi

## Migration

Jalankan migration dengan:
```bash
php artisan migrate
```

Migration files:
- `2024_01_04_000001_add_financing_to_programs_table.php`
- `2024_01_04_000002_create_registrations_table.php`
- `2024_01_04_000003_create_payments_table.php`
