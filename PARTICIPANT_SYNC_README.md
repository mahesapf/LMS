# Dokumentasi Sinkronisasi Peserta

## Masalah yang Dipecahkan

Sebelumnya, sistem memiliki masalah di mana:
- Peserta yang sudah terdaftar dalam kelas tidak muncul saat mereka login
- Data `teacher_participants` dan kepala sekolah dalam `registrations` tidak terhubung dengan tabel `users`
- `ParticipantMapping` hanya dibuat untuk `registration.user_id`, tidak untuk guru dan kepala sekolah individual

## Solusi yang Diimplementasikan

### 1. **Struktur Database Baru**

Ditambahkan kolom baru:
- `teacher_participants.user_id` - Link ke tabel users
- `registrations.kepala_sekolah_user_id` - Link ke user kepala sekolah

### 2. **Sinkronisasi Otomatis Saat Login**

Setiap kali user login, sistem akan:
1. Mencari data `teacher_participants` yang cocok dengan email atau NIK user
2. Mencari data `registrations` (kepala sekolah) yang cocok dengan email atau NIK user
3. Update `user_id` pada data yang ditemukan
4. Membuat `ParticipantMapping` jika data tersebut sudah ditugaskan ke kelas

**File:** `app/Http/Controllers/Auth/LoginController.php`

### 3. **Sinkronisasi Manual via Command**

Admin dapat menjalankan command untuk sinkronisasi semua data sekaligus:

```bash
php artisan participants:sync-users
```

Command ini akan:
1. Sync semua `teacher_participants` dengan users berdasarkan email/NIK
2. Sync semua kepala sekolah dengan users berdasarkan email/NIK
3. Membuat `ParticipantMapping` untuk semua yang sudah ditugaskan ke kelas

**File:** `app/Console/Commands/SyncParticipantUsers.php`

### 4. **Otomatis Saat Assign ke Kelas**

Saat admin menugaskan peserta ke kelas (baik individual atau per kecamatan), sistem akan otomatis:
1. Membuat `ParticipantMapping` untuk `registration.user_id` (jika ada)
2. Membuat `ParticipantMapping` untuk `registration.kepala_sekolah_user_id` (jika ada)
3. Membuat `ParticipantMapping` untuk setiap `teacher_participants.user_id` (jika ada)

**File:** `app/Http/Controllers/SuperAdminController.php`
- Method: `showClass()` - lines 644-688
- Method: `assignParticipantsByKecamatan()` - lines 779-827

## Cara Menggunakan

### Untuk Data yang Sudah Ada

Jalankan command sinkronisasi sekali:
```bash
php artisan participants:sync-users
```

### Untuk Data Baru

Sistem akan otomatis bekerja saat:
1. **User login pertama kali** - Sistem akan mencocokkan dan membuat mapping
2. **Admin assign ke kelas** - Sistem akan membuat mapping untuk semua peserta yang punya user_id

## Pengecekan

### Cek apakah peserta sudah tersinkronisasi:

```sql
-- Cek teacher_participants yang sudah punya user_id
SELECT tp.*, u.email, u.name 
FROM teacher_participants tp
LEFT JOIN users u ON tp.user_id = u.id
WHERE tp.user_id IS NOT NULL;

-- Cek registrations (kepala sekolah) yang sudah punya user_id
SELECT r.*, u.email, u.name 
FROM registrations r
LEFT JOIN users u ON r.kepala_sekolah_user_id = u.id
WHERE r.kepala_sekolah_user_id IS NOT NULL;

-- Cek participant_mappings yang sudah dibuat
SELECT pm.*, u.name, c.name as class_name
FROM participant_mappings pm
JOIN users u ON pm.participant_id = u.id
JOIN classes c ON pm.class_id = c.id
WHERE pm.status = 'in'
ORDER BY pm.created_at DESC;
```

## Alur Kerja Complete

1. **Pendaftaran** → Registrasi dibuat dengan data guru dan kepala sekolah
2. **User Registrasi** → User membuat akun (email/NIK cocok dengan data pendaftaran)
3. **Login Pertama** → Sistem otomatis link user ke teacher_participants/registration
4. **Pembayaran** → Pembayaran divalidasi
5. **Assign ke Kelas** → Admin assign registrasi ke kelas
6. **Participant Mapping** → Sistem otomatis buat mapping untuk semua peserta yang punya user_id
7. **Login Peserta** → Peserta bisa melihat kelas mereka di dashboard

## Troubleshooting

### Peserta tidak muncul di kelas setelah login?

1. Cek apakah user memiliki email/NIK yang sama dengan data pendaftaran:
```sql
SELECT * FROM users WHERE email = 'email@contoh.com' OR nik = '1234567890';
```

2. Cek apakah teacher_participant sudah ter-link:
```sql
SELECT * FROM teacher_participants WHERE email = 'email@contoh.com' OR nik = '1234567890';
```

3. Cek apakah registration sudah punya class_id:
```sql
SELECT r.* FROM registrations r
JOIN teacher_participants tp ON tp.registration_id = r.id
WHERE tp.email = 'email@contoh.com';
```

4. Jalankan sync manual:
```bash
php artisan participants:sync-users
```

5. Minta peserta logout dan login lagi

### Data masih tidak sync?

Pastikan:
- Email atau NIK user sama persis dengan data di teacher_participants/registrations
- Registration sudah di-assign ke kelas (class_id tidak null)
- Tidak ada typo di email/NIK

## Migration yang Ditambahkan

1. `2026_01_12_011154_add_user_id_to_teacher_participants_table.php`
2. `2026_01_12_011208_add_kepala_sekolah_user_id_to_registrations_table.php`

## Model yang Diupdate

1. `app/Models/TeacherParticipant.php` - Added user relationship
2. `app/Models/Registration.php` - Added kepalaSekolahUser relationship
