# Konfigurasi Login dengan Google

Aplikasi LMS sekarang mendukung login menggunakan akun Google melalui OAuth 2.0.

## Setup Google OAuth

### 1. Buat Project di Google Cloud Console

1. Kunjungi [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang sudah ada
3. Aktifkan Google+ API atau Google People API

### 2. Buat OAuth 2.0 Credentials

1. Di Google Cloud Console, buka **APIs & Services** > **Credentials**
2. Klik **Create Credentials** > **OAuth client ID**
3. Pilih **Application type**: Web application
4. Isi konfigurasi:
   - **Name**: LMS Application
   - **Authorized JavaScript origins**: 
     - `http://localhost` (untuk development)
     - `http://localhost:8000` (untuk Laravel artisan serve)
     - `http://your-production-domain.com` (untuk production)
   - **Authorized redirect URIs**:
     - `http://localhost/auth/google/callback`
     - `http://localhost:8000/auth/google/callback`
     - `http://your-production-domain.com/auth/google/callback`
5. Klik **Create**
6. Salin **Client ID** dan **Client Secret**

### 3. Konfigurasi Environment Variables

Tambahkan konfigurasi berikut ke file `.env` Anda:

```env
GOOGLE_CLIENT_ID=your-google-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

Ganti `your-google-client-id` dan `your-google-client-secret` dengan credentials yang Anda dapatkan dari Google Cloud Console.

### 4. Jalankan Migration

Jika belum menjalankan migration, jalankan perintah berikut:

```bash
php artisan migrate
```

Migration akan menambahkan kolom `google_id` dan `avatar` ke tabel `users`.

## Cara Menggunakan

1. Buka halaman login: `/login`
2. Klik tombol **"Login dengan Google"**
3. Pilih akun Google yang ingin digunakan
4. Berikan izin akses yang diminta
5. Anda akan otomatis login ke sistem

## Catatan Penting

### Role Default
- User baru yang login pertama kali dengan Google akan otomatis mendapat role **"peserta"**
- Untuk mengubah role, admin harus mengubahnya melalui panel Super Admin

### Email yang Sudah Terdaftar
- Jika email Google sudah terdaftar di sistem, akun akan otomatis di-link dengan Google ID
- User bisa login menggunakan email/password atau Google

### Data User
- Nama user diambil dari akun Google
- Email diambil dari akun Google (harus verified)
- Avatar/foto profil diambil dari Google (disimpan di kolom `avatar`)

## Keamanan

- Password user yang mendaftar via Google akan di-generate secara random
- Google ID disimpan secara aman di database dengan unique constraint
- Redirect URI harus sesuai dengan yang didaftarkan di Google Cloud Console

## Troubleshooting

### Error: "redirect_uri_mismatch"
- Pastikan redirect URI di `.env` sesuai dengan yang didaftarkan di Google Cloud Console
- Periksa `APP_URL` di file `.env`

### Error: "Access blocked: This app's request is invalid"
- Pastikan Google+ API atau Google People API sudah diaktifkan
- Periksa kembali OAuth consent screen

### User tidak bisa login
- Pastikan migration sudah dijalankan
- Periksa apakah kolom `google_id` dan `avatar` sudah ada di tabel `users`
- Cek log Laravel: `storage/logs/laravel.log`

## File yang Dimodifikasi

1. `app/Models/User.php` - Menambahkan `google_id` dan `avatar` ke fillable
2. `app/Http/Controllers/Auth/GoogleAuthController.php` - Controller untuk OAuth
3. `config/services.php` - Konfigurasi Google OAuth
4. `routes/web.php` - Routes untuk Google authentication
5. `resources/views/auth/login.blade.php` - Tombol login Google
6. `database/migrations/2026_01_07_074316_add_google_fields_to_users_table.php` - Migration

## Testing

Untuk testing di local:
1. Pastikan APP_URL di .env sesuai (misalnya: `http://localhost:8000`)
2. Jalankan `php artisan serve`
3. Akses `http://localhost:8000/login`
4. Test login dengan Google

## Production Deployment

Sebelum deploy ke production:
1. Update authorized redirect URIs di Google Cloud Console dengan domain production
2. Update `APP_URL` dan `GOOGLE_REDIRECT_URI` di `.env` production
3. Clear cache: `php artisan config:clear`
4. Restart server/queue
