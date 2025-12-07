# Laporan & Export

## Deskripsi
Fitur untuk mengexport data ke format Excel (.xlsx) dan PDF untuk keperluan pelaporan dan arsip. Mendukung filter dan customisasi data yang akan diexport.

## Package yang Digunakan

### 1. Maatwebsite/Laravel-Excel v3.1
- **Purpose**: Export data ke Excel (.xlsx)
- **Documentation**: https://laravel-excel.com
- **Features**:
  - Export collections ke Excel
  - Custom headings dan styling
  - Support multiple sheets
  - Formula dan formatting

### 2. Barryvdh/Laravel-DomPDF v3.1
- **Purpose**: Generate PDF dari HTML views
- **Documentation**: https://github.com/barryvdh/laravel-dompdf
- **Features**:
  - HTML to PDF conversion
  - Custom CSS styling
  - Headers dan footers
  - Page orientation

## Jenis Laporan

### 1. Laporan Presensi (Attendance Report)

#### Export Classes
**File**: `app/Exports/AttendanceExport.php`

**Filters**:
- `start_date`: Tanggal mulai (required)
- `end_date`: Tanggal selesai (required)
- `type`: Jenis presensi (optional)
  - `null`: Semua (Guru & Siswa)
  - `teacher`: Guru saja
  - `student`: Siswa saja

**Columns**:
1. No
2. Tanggal
3. Nama
4. Jenis (Guru/Siswa)
5. Check In
6. Check Out
7. Status (Hadir/Terlambat/Sakit/Izin/Alpha)
8. Keterangan

**Styling**:
- Header: Purple background (#667eea) dengan white text
- Auto-number per row
- Status dengan color coding

#### PDF Template
**File**: `resources/views/reports/pdf/attendance.blade.php`

**Features**:
- Header dengan logo sekolah
- Periode tanggal
- Filter type display
- Striped table rows
- Footer dengan timestamp dan total data
- Badge colors untuk status

---

### 2. Laporan Nilai (Grades Report)

#### Export Classes
**File**: `app/Exports/GradesExport.php`

**Filters**:
- `class_id`: ID Kelas (optional)
- `semester`: Semester 1/2 (optional)
- `academic_year`: Tahun ajaran (optional)

**Columns**:
1. No
2. NIS
3. Nama Siswa
4. Mata Pelajaran
5. Tahun Ajaran
6. Semester
7. Tugas (Assignment Grade)
8. UTS (Midterm Grade)
9. UAS (Final Exam Grade)
10. Nilai Akhir (Final Grade)
11. Predikat (A/B/C/D/E)

**Predikat Calculation**:
- A: ≥ 90
- B: 80-89
- C: 70-79
- D: 60-69
- E: < 60

#### PDF Template
**File**: `resources/views/reports/pdf/grades.blade.php`

**Features**:
- Header dengan filter info (kelas, TA, semester)
- Compact table design (11px font)
- Center-aligned numeric columns
- Grade letter calculation
- Footer dengan statistics

---

### 3. Laporan Data Siswa (Students Report)

#### Export Classes
**File**: `app/Exports/StudentsExport.php`

**Filters**:
- `class_id`: ID Kelas (optional)
- `grade`: Tingkat kelas 7/8/9 (optional)
- `status`: Status siswa (default: 'active')
  - `active`: Siswa aktif
  - `inactive`: Siswa tidak aktif
  - `null`: Semua status

**Columns**:
1. No
2. NIS
3. Nama
4. Jenis Kelamin (L/P)
5. Tempat Lahir
6. Tanggal Lahir (dd/mm/yyyy)
7. Kelas
8. Tingkat (Kelas 7/8/9)
9. Alamat
10. No. HP
11. Email
12. Status

**Features**:
- Auto gender label (Laki-laki/Perempuan)
- Date formatting Indonesian style
- Nullable field handling

#### PDF Template
**File**: `resources/views/reports/pdf/students.blade.php`

**Features**:
- Compact 10px font untuk banyak columns
- Address truncation (max 30 chars)
- Status filter display
- Alternating row colors

---

### 4. Laporan Data Guru (Teachers Report)

#### Export Classes
**File**: `app/Exports/TeachersExport.php`

**Filters**: No filters (export all teachers)

**Columns**:
1. No
2. NIP
3. Nama
4. Jenis Kelamin (L/P)
5. Tempat Lahir
6. Tanggal Lahir (dd/mm/yyyy)
7. Alamat
8. No. HP
9. Email
10. Pendidikan (Education level)
11. Jumlah Mata Pelajaran (Subject count)
12. Status Akun (Aktif/Tidak Aktif)

**Features**:
- Eager loading teacher subjects
- Subject count calculation
- User account status check

#### PDF Template
**File**: `resources/views/reports/pdf/teachers.blade.php`

**Features**:
- No filter info (all data)
- Address truncation (max 25 chars)
- User account status
- Clean table design

---

## Controller Actions

### ReportController

**File**: `app/Http/Controllers/ReportController.php`

#### Methods

##### 1. `index()`
- Display halaman laporan
- Pass data: classes, academicYears, activeYear
- Return: `reports.index` view

##### 2. `exportAttendance(Request $request)`
**Validation**:
```php
start_date: required|date
end_date: required|date|after_or_equal:start_date
type: nullable|in:teacher,student
format: required|in:excel,pdf
```

**Logic**:
- Parse dates dengan Carbon
- Build filename dengan date range
- If Excel: Use AttendanceExport class
- If PDF: Query data → load view → generate PDF
- Return download response

##### 3. `exportGrades(Request $request)`
**Validation**:
```php
class_id: nullable|exists:classes,id
semester: nullable|in:1,2
academic_year: nullable|string
format: required|in:excel,pdf
```

**Logic**:
- Build dynamic filename (include class name, year)
- Apply filters to query
- If Excel: Use GradesExport class
- If PDF: Query with filters → load view → generate PDF

##### 4. `exportStudents(Request $request)`
**Validation**:
```php
class_id: nullable|exists:classes,id
grade: nullable|in:7,8,9
status: nullable|in:active,inactive
format: required|in:excel,pdf
```

**Logic**:
- Default status: 'active'
- Build filename dengan grade info
- Apply multiple filters
- Export dengan class yang sesuai

##### 5. `exportTeachers(Request $request)`
**Validation**:
```php
format: required|in:excel,pdf
```

**Logic**:
- No filters (all teachers)
- Filename dengan date
- Eager load relationships (user, teacherSubjects)

---

## Routes

**File**: `routes/web.php`

```php
Route::middleware(\App\Http\Middleware\CheckRole::class . ':Admin')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/attendance/export', [ReportController::class, 'exportAttendance'])->name('reports.attendance.export');
    Route::post('/reports/grades/export', [ReportController::class, 'exportGrades'])->name('reports.grades.export');
    Route::post('/reports/students/export', [ReportController::class, 'exportStudents'])->name('reports.students.export');
    Route::post('/reports/teachers/export', [ReportController::class, 'exportTeachers'])->name('reports.teachers.export');
});
```

**Middleware**: Admin only (`CheckRole:Admin`)

---

## Views

### Main Report Page
**File**: `resources/views/reports/index.blade.php`

**Layout**: 4 cards dengan form untuk masing-masing jenis laporan

#### Card 1: Laporan Presensi (Purple header)
- Date range picker (start_date, end_date)
- Type selector (All/Teacher/Student)
- Excel & PDF buttons

#### Card 2: Laporan Nilai (Green header)
- Class dropdown
- Semester dropdown (1/2)
- Academic Year dropdown
- Excel & PDF buttons

#### Card 3: Laporan Data Siswa (Yellow header)
- Class dropdown
- Grade dropdown (7/8/9)
- Status dropdown (Active/Inactive/All)
- Excel & PDF buttons

#### Card 4: Laporan Data Guru (Blue header)
- Info alert (all data will be exported)
- Excel & PDF buttons
- Data info card (what columns exported)

#### Bottom Card: Informasi Penggunaan
- Excel format info (editable, smaller size)
- PDF format info (read-only, print-ready)

---

## PDF Styling

### Common Styles
```css
body { font-family: Arial, sans-serif; font-size: 10-12px; }
.header {
    text-align: center;
    border-bottom: 3px solid #667eea;
    padding-bottom: 10px;
}
table thead th {
    background-color: #667eea;
    color: white;
    padding: 6-10px;
}
table tbody tr:nth-child(even) { 
    background-color: #f9f9f9; 
}
```

### Badge Styling
```css
.badge-success { background: #22c55e; color: white; }
.badge-warning { background: #fbbf24; color: #000; }
.badge-danger { background: #ef4444; color: white; }
.badge-info { background: #3b82f6; color: white; }
.badge-secondary { background: #9ca3af; color: white; }
```

### Responsive Font Sizes
- Attendance: 12px body, 10px badges
- Grades: 11px body (banyak columns)
- Students: 10px body (10 columns)
- Teachers: 10px body (10 columns)

---

## Excel Styling

### Common Features (All Exports)
```php
implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
```

**Traits**:
1. `FromCollection`: Data source dari Eloquent collection
2. `WithHeadings`: Custom header row
3. `WithMapping`: Transform data per row
4. `WithStyles`: Cell styling (colors, fonts, etc)
5. `WithTitle`: Sheet name

**Header Style**:
```php
[
    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '667eea']
    ]
]
```

**Static Counter**: Auto-numbering menggunakan `static $no`

---

## Filename Conventions

### Attendance
```
laporan_presensi_{start_date}_to_{end_date}.{xlsx|pdf}
Example: laporan_presensi_2024-11-01_to_2024-11-30.xlsx
```

### Grades
```
laporan_nilai[_class_name][_academic_year].{xlsx|pdf}
Example: laporan_nilai_VII-A_2024-2025.pdf
```

### Students
```
laporan_siswa[_kelas_{grade}].{xlsx|pdf}
Example: laporan_siswa_kelas_7.xlsx
```

### Teachers
```
laporan_guru_{date}.{xlsx|pdf}
Example: laporan_guru_2024-11-07.pdf
```

---

## Usage Examples

### Export Attendance (Excel)
```php
POST /reports/attendance/export
{
    "start_date": "2024-11-01",
    "end_date": "2024-11-30",
    "type": "teacher",
    "format": "excel"
}
```

### Export Grades (PDF)
```php
POST /reports/grades/export
{
    "class_id": 1,
    "semester": 1,
    "academic_year": "2024/2025",
    "format": "pdf"
}
```

### Export Students (Excel)
```php
POST /reports/students/export
{
    "grade": "7",
    "status": "active",
    "format": "excel"
}
```

### Export Teachers (PDF)
```php
POST /reports/teachers/export
{
    "format": "pdf"
}
```

---

## Error Handling

### Validation Errors
- Return back with errors
- Show validation messages
- Preserve input values

### Empty Data
- Display "Tidak ada data" message
- Still generate file with headers
- Show 0 in footer statistics

### Date Range Validation
- `end_date` must be after or equal to `start_date`
- Required fields must not be empty

---

## Performance Considerations

### Large Datasets
- No pagination in exports (all data)
- Memory usage may increase with large datasets
- Consider chunking for 10,000+ records

### Query Optimization
- Use eager loading: `with()`, `withCount()`
- Apply filters before query execution
- Index date columns for faster filtering

### File Size
- Excel: Smaller, compressed
- PDF: Larger, especially with many pages
- Consider max row limits for PDF readability

---

## Future Enhancements

### Potential Features
1. **Scheduled Reports**: Auto-generate monthly reports
2. **Email Reports**: Send PDF via email
3. **Custom Columns**: Let users choose which columns to export
4. **Multi-Sheet Excel**: Separate sheets per class/subject
5. **Charts in PDF**: Include visual graphs
6. **Batch Export**: Export multiple reports at once
7. **Report Templates**: Save filter preferences
8. **Watermarks**: Add school logo to PDFs

### Advanced Features
- **Real-time Progress**: Show download progress
- **Background Jobs**: Queue large exports
- **Cloud Storage**: Save to Google Drive/OneDrive
- **Encryption**: Password-protect sensitive PDFs
- **Digital Signatures**: Sign official reports

---

**Created**: November 2025  
**Version**: 1.0  
**Module**: Reports & Export
