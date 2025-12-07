# Manajemen Tahun Ajaran

## Deskripsi
Modul untuk mengelola tahun ajaran dan semester di sistem SMPN 4 Purwakarta.

## Fitur

### 1. **Daftar Tahun Ajaran** (`/academic-years`)
- Tabel daftar semua tahun ajaran
- Informasi: Tahun, Semester, Periode, Status (Aktif/Non-Aktif)
- Toggle status aktif/non-aktif dengan switch
- Pagination untuk data banyak
- SweetAlert2 untuk konfirmasi aksi

### 2. **Tambah Tahun Ajaran** (`/academic-years/create`)
- Form input:
  - Tahun Ajaran (format: YYYY/YYYY, contoh: 2024/2025)
  - Semester (Ganjil/Genap)
  - Tanggal Mulai
  - Tanggal Selesai
  - Keterangan (opsional)
  - Checkbox "Set sebagai Aktif"
- Auto-detect semester berdasarkan tanggal mulai
- Validasi:
  - Kombinasi tahun + semester harus unik
  - Tanggal selesai harus setelah tanggal mulai
  - Hanya 1 tahun ajaran yang boleh aktif

### 3. **Detail Tahun Ajaran** (`/academic-years/{id}`)
- Informasi lengkap tahun ajaran
- Timeline progress (upcoming/ongoing/finished)
- Progress bar untuk tahun ajaran yang sedang berjalan
- Statistik data terkait:
  - Jumlah kelas yang menggunakan tahun ajaran ini
  - Jumlah nilai yang terdaftar
- Daftar kelas yang terkait

### 4. **Edit Tahun Ajaran** (`/academic-years/{id}/edit`)
- Form edit dengan data yang sudah ada
- Sidebar menampilkan:
  - Status aktif saat ini
  - Jumlah data terkait (kelas, nilai)
  - Warning jika ada data terkait

### 5. **Toggle Status Aktif**
- Switch di halaman index untuk aktifkan/nonaktifkan
- Konfirmasi SweetAlert2 sebelum toggle
- Auto-deaktivasi tahun ajaran lain jika ada yang diaktifkan
- Proteksi: minimal harus ada 1 tahun ajaran aktif

### 6. **Hapus Tahun Ajaran**
- Button hapus dengan konfirmasi SweetAlert2
- Proteksi hapus:
  - Tidak bisa hapus tahun ajaran yang sedang aktif
  - Tidak bisa hapus jika masih digunakan di kelas
  - Tidak bisa hapus jika masih ada nilai terdaftar
- Error message jelas jika ada proteksi

## Database Schema

### Tabel: `academic_years`
```sql
- id: bigint (PK)
- year: string(20) - Format: 2024/2025
- semester: string(10) - Ganjil/Genap
- start_date: date
- end_date: date
- is_active: boolean (default: false)
- description: text (nullable)
- created_at: timestamp
- updated_at: timestamp

UNIQUE KEY: (year, semester)
```

## Model Features

### AcademicYear Model
- **Fillable:** year, semester, start_date, end_date, is_active, description
- **Casts:** start_date (date), end_date (date), is_active (boolean)
- **Methods:**
  - `getActive()`: Get tahun ajaran yang aktif
  - `setAsActive()`: Set sebagai aktif dan deaktivasi yang lain
  - `getFullNameAttribute()`: Get "Tahun - Semester" (accessor)
  - `canBeDeleted()`: Check apakah bisa dihapus
  - `getRelatedDataInfo()`: Get info data terkait (kelas, nilai)

## Routes
```php
// Resource routes
Route::resource('academic-years', AcademicYearController::class);

// Custom route
Route::post('academic-years/{academicYear}/toggle-active', [AcademicYearController::class, 'toggleActive'])
    ->name('academic-years.toggle-active');
```

## Controller Actions

### AcademicYearController
1. **index()** - List semua tahun ajaran dengan pagination
2. **create()** - Tampilkan form tambah
3. **store()** - Simpan tahun ajaran baru
4. **show()** - Detail tahun ajaran
5. **edit()** - Form edit
6. **update()** - Update data
7. **destroy()** - Hapus tahun ajaran (dengan proteksi)
8. **toggleActive()** - Toggle status aktif/non-aktif

## Validasi

### Store & Update
- `year`: required, string, max 20 karakter
- `semester`: required, in:Ganjil,Genap
- `start_date`: required, date
- `end_date`: required, date, after:start_date
- `is_active`: boolean
- `description`: nullable, string, max 500 karakter
- Custom: Kombinasi year + semester harus unik

## Business Logic

### Auto-Deactivation
Ketika tahun ajaran di-set aktif (via checkbox atau toggle):
1. Semua tahun ajaran lain otomatis di-set `is_active = false`
2. Tahun ajaran yang dipilih di-set `is_active = true`

### Delete Protection
Tahun ajaran **tidak bisa dihapus** jika:
1. Sedang dalam status aktif (`is_active = true`)
2. Digunakan di tabel `classes` (foreign key: academic_year)
3. Digunakan di tabel `grades` (foreign key: academic_year)

Error message akan menampilkan detail data yang menghalangi penghapusan.

### Minimal Active Requirement
Minimal harus ada 1 tahun ajaran yang aktif di sistem.
Jika mencoba menonaktifkan tahun ajaran terakhir yang aktif, akan ditolak.

## UI Features

### SweetAlert2 Integration
- **Toggle Confirmation**: Dialog konfirmasi sebelum aktifkan/nonaktifkan
- **Delete Confirmation**: Dialog warning dengan detail tahun ajaran
- **Delete Protection Alert**: Alert error jika tidak bisa dihapus (sedang aktif)
- **Loading State**: Loading indicator saat proses delete

### Bootstrap Components
- **Card Layout**: Card dengan gradient header
- **Form Switch**: Toggle switch untuk status aktif
- **Badges**: Color-coded badges untuk semester dan status
- **Progress Bar**: Visual progress tahun ajaran yang sedang berjalan
- **Alert Boxes**: Info/warning/success alerts
- **Responsive Tables**: Table responsive dengan hover effect

### Timeline Indicator (Detail Page)
- **Upcoming**: Belum dimulai - tampilkan "Dimulai dalam X hari"
- **Ongoing**: Sedang berjalan - progress bar + "Berakhir dalam X hari"
- **Finished**: Sudah selesai - tampilkan "Berakhir X hari yang lalu"

## Data Seeder

### AcademicYearSeeder
Seed 5 tahun ajaran:
1. 2023/2024 - Ganjil (non-aktif)
2. 2023/2024 - Genap (non-aktif)
3. 2024/2025 - Ganjil (aktif) ✓
4. 2024/2025 - Genap (non-aktif)
5. 2025/2026 - Ganjil (non-aktif)

## Integrasi dengan Modul Lain

### ClassRoom Model
- Field `academic_year` menyimpan tahun ajaran (string format: 2024/2025)
- Digunakan untuk filter kelas per tahun ajaran

### Grade Model
- Field `academic_year` menyimpan tahun ajaran
- Digunakan untuk filter nilai per tahun ajaran

## Permissions
- **Role Required**: Admin only
- **Middleware**: `CheckRole:Admin`

## Menu Navigation
- **Location**: Sidebar > Data Master
- **Icon**: `fas fa-calendar-alt`
- **Label**: "Tahun Ajaran"
- **Active Indicator**: Highlight saat di route `academic-years.*`

## Future Enhancements (Optional)
- Export data tahun ajaran (Excel/PDF)
- Import tahun ajaran dari file
- Kalender akademik terintegrasi
- Reminder otomatis menjelang akhir semester
- Dashboard widget untuk tahun ajaran aktif
- History log perubahan status aktif

---

**Created**: November 2025  
**Version**: 1.0  
**Module**: Academic Year Management
