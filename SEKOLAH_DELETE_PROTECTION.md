# Proteksi Penghapusan Sekolah

## Masalah
Ketika akun sekolah dihapus, ada kekhawatiran data peserta yang terkait dengan sekolah tersebut (berdasarkan NPSN yang sama) juga akan ikut terhapus.

## Solusi yang Diterapkan

### 1. Soft Delete Protection (User Model)
File: `app/Models/User.php`

**Event Deleting (Soft Delete):**
- Mencatat log setiap soft delete user
- Memberikan warning jika sekolah yang dihapus memiliki peserta aktif dengan NPSN sama
- **TIDAK mencegah soft delete** - hanya logging untuk audit trail

**Event ForceDeleting (Permanent Delete):**
- Mencegah permanent delete jika sekolah masih memiliki peserta aktif
- Melempar exception dengan pesan error yang jelas
- Log error untuk investigasi

```php
// Contoh error jika force delete sekolah dengan peserta aktif:
"Tidak dapat menghapus permanen akun sekolah yang memiliki 5 peserta aktif. 
Hapus atau pindahkan peserta terlebih dahulu."
```

### 2. Controller Warning (SekolahManagementController)
File: `app/Http/Controllers/SekolahManagementController.php`

Method `destroy()` sekarang:
- Menghitung jumlah peserta dengan NPSN sama sebelum soft delete
- Memberikan feedback ke admin tentang peserta terkait
- Hanya melakukan soft delete (data tetap ada di database)

```php
// Pesan sukses dengan info:
"Akun sekolah berhasil dihapus. Terdapat 3 akun peserta dengan NPSN yang sama yang TIDAK ikut terhapus."
```

### 3. Database Foreign Key Behavior
File: `database/migrations/2026_01_15_103920_update_foreign_keys_for_safe_delete.php`

**Dokumentasi CASCADE DELETE:**
- `participant_mappings.participant_id` → `onDelete('cascade')`
- `documents.user_id` → `onDelete('cascade')`

**PENTING:** 
- CASCADE hanya trigger pada **HARD DELETE** (forceDelete())
- **SOFT DELETE** (delete()) TIDAK trigger cascade karena record tidak benar-benar dihapus
- Migration berisi kode (commented) untuk mengubah behavior jika diperlukan di masa depan

## Relasi Sekolah - Peserta

**Tidak ada foreign key langsung** antara sekolah dan peserta.

Relasi terjadi melalui **NPSN yang sama:**
```php
// Di SekolahController.php - accountInfo()
$activePesertaAccounts = User::where('role', 'peserta')
    ->where('status', 'active')
    ->where('npsn', $user->npsn) // ← Relasi melalui NPSN
    ->whereNotNull('npsn')
    ->get();
```

## Scenario Testing

### Test 1: Soft Delete Sekolah
✅ **AMAN** - Data peserta TIDAK terhapus
```
1. Admin hapus sekolah NPSN 20211510
2. Sekolah soft deleted (deleted_at set)
3. Peserta dengan NPSN 20211510 tetap aktif
4. Admin dapat restore sekolah jika perlu
```

### Test 2: Force Delete Sekolah dengan Peserta Aktif
❌ **DICEGAH** - Exception dilempar
```
1. Admin coba permanent delete sekolah
2. System cek ada 5 peserta aktif
3. Exception: "Tidak dapat menghapus permanen..."
4. Force delete dibatalkan
```

### Test 3: Force Delete Sekolah tanpa Peserta
✅ **DIIZINKAN** - Permanent delete berhasil
```
1. Semua peserta sudah dihapus/dipindahkan
2. Admin force delete sekolah
3. Record benar-benar dihapus dari database
4. Log warning disimpan
```

## Logging & Audit Trail

Semua aktivitas delete dicatat di `storage/logs/laravel.log`:

```
[info] User soft delete initiated
- user_id: 123
- user_role: sekolah
- npsn: 20211510

[warning] Deleting sekolah with related active peserta
- sekolah_name: SMKN 1 Ciamis
- related_peserta_count: 5

[error] PREVENTED: Attempted force delete of sekolah with active peserta
```

## Cara Menghapus Sekolah dengan Aman

### Metode 1: Soft Delete (Recommended)
```
1. Admin masuk ke Manajemen Sekolah
2. Klik "Hapus" pada sekolah yang ingin dihapus
3. Sekolah di-soft delete (masih bisa direstore)
4. Peserta tetap aktif dan tidak terpengaruh
```

### Metode 2: Permanent Delete (Hati-hati!)
```
1. Pastikan TIDAK ada peserta aktif dengan NPSN sama
2. Soft delete dulu sekolah
3. Jalankan force delete via console/script
4. Sekolah dihapus permanent dari database
```

## Data yang TIDAK Terhapus saat Soft Delete Sekolah

✅ **AMAN - Tidak Terhapus:**
- Akun peserta dengan NPSN sama
- participant_mappings (mapping peserta ke kelas)
- documents peserta
- grades peserta
- registrations peserta
- teacher_participants

## Kesimpulan

✅ **Soft delete sekolah AMAN** - tidak akan menghapus data peserta
✅ **Force delete dilindungi** - dicegah jika masih ada peserta aktif
✅ **Logging lengkap** - audit trail untuk investigasi
✅ **Relasi terpisah** - sekolah dan peserta tidak memiliki foreign key langsung

**Rekomendasi:** Gunakan soft delete untuk semua operasi penghapusan sekolah. Jangan force delete kecuali benar-benar diperlukan dan sudah memastikan tidak ada data terkait.
