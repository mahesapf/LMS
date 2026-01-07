# UPDATE: Sistem Pendaftaran dan Pembayaran

## Perubahan Utama

### 1. **Pembiayaan Dipindahkan ke Kegiatan (Activity)**
❌ **Sebelumnya**: Field pembiayaan ada di tabel `programs`  
✅ **Sekarang**: Field pembiayaan ada di tabel `activities`

**Alasan**: Setiap kegiatan dalam program bisa memiliki jenis pembiayaan yang berbeda.

**Field di Activities:**
- `financing_type` (APBN/Non-APBN)
- `apbn_type` (BOS Reguler/BOS Kinerja/DIPA)
- `registration_fee` (biaya pendaftaran)

### 2. **Pendaftaran Berdasarkan Kegiatan**
❌ **Sebelumnya**: Pendaftaran ke `program`  
✅ **Sekarang**: Pendaftaran ke `activity`

**Tabel Registrations:**
- Menggunakan `activity_id` (bukan `program_id`)
- Relasi: `registration -> activity -> program`

### 3. **Role Peserta Diberikan Setelah Validasi**
❌ **Sebelumnya**: User langsung dapat role "peserta" saat registrasi  
✅ **Sekarang**: User mendapat role "peserta" setelah super admin validasi pembayaran

**Workflow Role:**
1. User register → role default (misalnya "user" atau "guest")
2. User login → bisa lihat dan daftar kegiatan
3. User daftar kegiatan → isi data & upload bukti bayar
4. **Super Admin** validasi pembayaran → role user berubah jadi "peserta"
5. Super Admin assign peserta ke kelas

### 4. **Hanya Super Admin yang Validasi Pembayaran**
❌ **Sebelumnya**: Admin bisa validasi pembayaran  
✅ **Sekarang**: **Hanya Super Admin** yang bisa validasi

**Routes Dipindahkan:**
- `/super-admin/payments` - List pembayaran pending
- `/super-admin/payments/{id}/validate` - Validasi pembayaran
- `/super-admin/payments/{id}/reject` - Tolak pembayaran
- `/super-admin/registrations` - Kelola peserta tervalidasi
- `/super-admin/registrations/{id}/assign` - Assign ke kelas

### 5. **Kegiatan Tampil di Homepage Publik**
✅ **Baru**: Kegiatan yang aktif dan belum dimulai ditampilkan di homepage (http://127.0.0.1:8000/)

**Fitur Homepage:**
- Menampilkan 6 kegiatan terbaru
- Info: nama, program, tanggal, biaya, jenis pembiayaan
- Tombol "Login untuk Mendaftar" (jika belum login)
- Tombol "Lihat Detail & Daftar" (jika sudah login)

### 6. **Routes Registrasi Accessible untuk Semua User Login**
✅ **Baru**: Routes pendaftaran tidak lagi terbatas hanya untuk role "peserta"

**Public Routes (Login Required):**
```php
/activities - Lihat daftar kegiatan
/activities/{id} - Detail kegiatan
/activities/{id}/register - Daftar kegiatan
/registrations/{id}/payment - Upload bukti bayar
```

**Middleware**: `auth` (bukan `auth, role:peserta`)

## Database Migrations

### Migration 1: Move Financing to Activities
File: `2024_01_05_000001_move_financing_to_activities.php`

**Action:**
- Hapus `financing_type`, `apbn_type`, `registration_fee` dari `programs`
- Tambah ke `activities`

### Migration 2: Change Registrations to Activity
File: `2024_01_05_000002_change_registrations_to_activity.php`

**Action:**
- Hapus foreign key `program_id` dari `registrations`
- Tambah foreign key `activity_id`

## Updated Models

### Activity Model
```php
protected $fillable = [
    'program_id',
    'name',
    'description',
    'financing_type',      // NEW
    'apbn_type',           // NEW
    'registration_fee',    // NEW
    'batch',
    'start_date',
    'end_date',
    'funding_source',
    'funding_source_other',
    'status',
    'created_by',
];

public function registrations() {
    return $this->hasMany(Registration::class);
}
```

### Registration Model
```php
protected $fillable = [
    'activity_id',   // CHANGED from program_id
    'user_id',
    'name',
    'phone',
    'email',
    'position',
    'school_name',
    'status',
    'class_id',
];

public function activity() {
    return $this->belongsTo(Activity::class);
}
```

## Updated Controllers

### 1. ActivityRegistrationController (renamed from ProgramRegistrationController)
- `index()` - Tampilkan daftar activities
- `show($activity)` - Detail activity
- `register($activity)` - Daftar activity
- `createPayment($registration)` - Form upload bukti
- `storePayment($registration)` - Simpan bukti bayar

### 2. PaymentValidationController
**Updated:**
```php
public function validate($payment) {
    // Validasi payment
    // Update registration status
    // BARU: Ubah role user jadi 'peserta'
    $user = $payment->registration->user;
    if ($user->role !== 'peserta') {
        $user->update(['role' => 'peserta']);
    }
}
```

### 3. HomeController
**Updated:**
```php
public function index() {
    $news = ...;
    
    // BARU: Get active activities
    $activities = Activity::where('status', 'active')
        ->whereDate('start_date', '>', now())
        ->with('program')
        ->orderBy('start_date')
        ->take(6)
        ->get();
    
    return view('home', compact('news', 'activities'));
}
```

## Updated Views

### 1. Homepage (home.blade.php)
**Ditambahkan:**
- Section "Kegiatan Tersedia"
- Menampilkan cards kegiatan dengan info lengkap
- Conditional button (login/daftar)

### 2. Super Admin - Create Activity
**Ditambahkan Field:**
- Jenis Pembiayaan (APBN/Non-APBN)
- Tipe APBN (BOS Reguler/BOS Kinerja/DIPA)
- Biaya Pendaftaran

**JavaScript:**
- Auto disable "Tipe APBN" jika "Jenis Pembiayaan" bukan APBN

### 3. Super Admin - Payments & Registrations
**Route berubah:**
- Dari `/admin/payments` → `/super-admin/payments`
- Dari `/admin/registrations` → `/super-admin/registrations`

## Cara Menggunakan

### Workflow Lengkap:

#### 1. Setup Kegiatan (Super Admin)
```
1. Login sebagai super admin
2. Buat Program
3. Buat Kegiatan di dalam program
   ✓ Isi jenis pembiayaan (APBN/Non-APBN)
   ✓ Pilih tipe APBN jika applicable
   ✓ Isi biaya pendaftaran
```

#### 2. User Mendaftar
```
1. Buka homepage http://127.0.0.1:8000/
2. Lihat kegiatan yang tersedia
3. Login (dengan role apapun, belum harus peserta)
4. Klik "Lihat Detail & Daftar"
5. Isi form pendaftaran
6. Upload bukti pembayaran
```

#### 3. Super Admin Validasi (Super Admin Only)
```
1. Login sebagai super admin
2. Buka menu "Validasi Pembayaran"
3. Lihat bukti transfer
4. Klik "Validasi" atau "Tolak"
5. Jika divalidasi:
   - Status payment = validated
   - Status registration = validated
   - User role berubah jadi "peserta"
```

#### 4. Assign ke Kelas (Super Admin)
```
1. Buka menu "Kelola Pendaftaran"
2. Lihat list peserta yang sudah tervalidasi
3. Assign peserta ke kelas tertentu
4. Peserta otomatis masuk sebagai participant mapping
```

## Important Notes

1. **Migration Order**: Jalankan migration secara berurutan
   ```bash
   php artisan migrate
   ```

2. **Storage Link**: Pastikan storage link sudah dibuat
   ```bash
   php artisan storage:link
   ```

3. **Role Default**: Update registration agar user baru tidak langsung dapat role "peserta"

4. **Testing**: Test complete workflow:
   - User daftar → upload bayar → super admin validasi → role berubah → assign ke kelas

## Breaking Changes

⚠️ **Warning**: Perubahan ini akan mempengaruhi:
- Existing registrations (jika ada)
- Views yang menggunakan `registration->program` harus diganti `registration->activity->program`
- Routes berubah dari `/programs` ke `/activities`
- Admin tidak bisa lagi validasi pembayaran (hanya super admin)

## Rollback

Jika perlu rollback:
```bash
php artisan migrate:rollback --step=2
```

Akan rollback:
1. `2024_01_05_000002_change_registrations_to_activity.php`
2. `2024_01_05_000001_move_financing_to_activities.php`
