# Cara Membuat Google OAuth Client ID Baru

## Langkah-langkah:

### 1. Buka Google Cloud Console
https://console.cloud.google.com/

### 2. Buat Project Baru (atau pilih project yang ada)
- Klik dropdown project di atas
- Klik "New Project"
- Nama project: "LMS Penjaminan Mutu" (atau nama lain)
- Klik "Create"

### 3. Aktifkan Google+ API atau People API
- Menu: APIs & Services > Library
- Cari "Google+ API" atau "Google People API"
- Klik "Enable"

### 4. Configure OAuth Consent Screen
- Menu: APIs & Services > OAuth consent screen
- Pilih "External" (untuk testing dengan akun pribadi)
- Klik "Create"
- Isi form:
  - App name: "LMS Penjaminan Mutu"
  - User support email: email Anda
  - Developer contact: email Anda
- Klik "Save and Continue"
- Skip "Scopes" (klik "Save and Continue")
- Add test users: tambahkan email Anda
- Klik "Save and Continue"

### 5. Create OAuth 2.0 Client ID
- Menu: APIs & Services > Credentials
- Klik "+ CREATE CREDENTIALS"
- Pilih "OAuth client ID"
- Application type: "Web application"
- Name: "LMS Web Client"
- Authorized JavaScript origins:
  ```
  http://localhost:8000
  http://127.0.0.1:8000
  ```
- Authorized redirect URIs:
  ```
  http://localhost:8000/auth/google/callback
  http://127.0.0.1:8000/auth/google/callback
  ```
- Klik "Create"

### 6. Copy Credentials
- Copy **Client ID** (format: xxx-xxx.apps.googleusercontent.com)
- Copy **Client Secret**

### 7. Update .env
```env
GOOGLE_CLIENT_ID=client-id-yang-baru
GOOGLE_CLIENT_SECRET=client-secret-yang-baru
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 8. Clear Config dan Test
```bash
php artisan config:clear
```

Akses: http://localhost:8000/login
