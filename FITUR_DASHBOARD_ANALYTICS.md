# Dashboard Analytics dengan Chart.js

## Deskripsi
Dashboard admin yang telah dilengkapi dengan visualisasi data menggunakan Chart.js untuk memberikan insight real-time tentang kondisi sekolah.

## Fitur Dashboard

### 1. **Statistik Cards Utama** (4 Cards Besar)

#### Card Guru
- **Metric**: Total guru di sistem
- **Sub-info**: Jumlah guru dengan akun aktif
- **Icon**: `fa-chalkboard-teacher`
- **Warna**: Gradient purple (#667eea → #764ba2)

#### Card Siswa
- **Metric**: Total siswa aktif
- **Sub-info**: Persentase pengisian kapasitas kelas
- **Calculation**: `(Total Siswa / Total Kapasitas Kelas) × 100%`
- **Icon**: `fa-user-graduate`
- **Warna**: Green

#### Card Kelas
- **Metric**: Total kelas
- **Sub-info**: Total mata pelajaran
- **Icon**: `fa-door-open`
- **Warna**: Warning (Yellow)

#### Card Presensi Hari Ini
- **Metric**: Total presensi hari ini
- **Sub-info**: Persentase kehadiran
- **Calculation**: `(Presensi Hari Ini / (Total Guru + Total Siswa)) × 100%`
- **Color Indicator**:
  - Green: ≥ 80%
  - Yellow: < 80%
- **Icon**: `fa-clipboard-check`
- **Warna**: Info (Blue)

### 2. **Tahun Ajaran Aktif Badge**
- Tampil di header dashboard
- Menampilkan tahun ajaran yang sedang aktif
- Format: "YYYY/YYYY - Semester Ganjil/Genap"
- Gradient background purple

### 3. **Quick Stats Mini Cards** (4 Cards)

- **User Aktif**: Total user di sistem
- **Mata Pelajaran**: Total mata pelajaran
- **Tahun Ajaran**: Total tahun ajaran terdaftar
- **Total Nilai**: Total nilai yang sudah diinput

Styling: Border kiri berwarna (border-start) dengan shadow

### 4. **Chart Visualizations** (4 Charts)

#### A. Distribusi Siswa per Tingkat (Doughnut Chart)
- **Type**: Doughnut
- **Data**: Jumlah siswa per tingkat (Kelas 7, 8, 9)
- **Query**: 
  ```php
  Student::where('status', 'active')
    ->join('classes', 'students.class_id', '=', 'classes.id')
    ->select('classes.grade', DB::raw('count(*) as total'))
    ->groupBy('classes.grade')
  ```
- **Colors**: Purple gradient palette
- **Tooltip**: Menampilkan jumlah dan persentase
- **Legend**: Bottom position dengan point style

#### B. Trend Presensi 7 Hari Terakhir (Line Chart)
- **Type**: Line (with area fill)
- **Data**: Jumlah presensi per hari (7 hari terakhir)
- **X-Axis**: Tanggal (format: "Day, DD Mon")
- **Y-Axis**: Jumlah presensi
- **Features**:
  - Gradient area fill
  - Smooth tension curve (0.4)
  - Point markers dengan hover effect
  - Grid lines pada Y-axis
- **Query**:
  ```php
  for ($i = 6; $i >= 0; $i--) {
    $date = Carbon::today()->subDays($i);
    Attendance::where('date', $date)->count();
  }
  ```

#### C. Kelas Terbanyak Siswa (Horizontal Bar Chart)
- **Type**: Horizontal Bar
- **Data**: Top 5 kelas dengan siswa terbanyak
- **Query**:
  ```php
  ClassRoom::withCount('students')
    ->orderByDesc('students_count')
    ->take(5)
  ```
- **Colors**: Multi-color (Purple, Violet, Green, Yellow, Red)
- **Features**:
  - Rounded corners (borderRadius: 8)
  - Y-axis indexing
  - No legend needed
- **Tooltip**: "Siswa: X orang"

#### D. Status Presensi Hari Ini (Doughnut Chart)
- **Type**: Doughnut
- **Data**: Breakdown presensi hari ini by status
- **Categories**:
  - Hadir (Green)
  - Terlambat (Yellow)
  - Sakit (Blue)
  - Izin (Gray)
  - Alpha (Red)
- **Query**:
  ```php
  Attendance::where('date', today())
    ->select('status', DB::raw('count(*) as total'))
    ->groupBy('status')
  ```
- **Tooltip**: Menampilkan jumlah dan persentase per status

### 5. **Recent Activity Tables**

#### Recent Attendance Table
- **Location**: Bottom left
- **Data**: 5 presensi terakhir
- **Columns**:
  - Nama (Bold)
  - Jenis (Badge: Guru/Siswa)
  - Waktu (dengan icon clock)
  - Status (Badge dengan icon)
- **Status Icons**:
  - Hadir: `fa-check` (Green)
  - Terlambat: `fa-exclamation` (Yellow)
  - Sakit: `fa-heartbeat` (Blue)
  - Izin: `fa-envelope` (Gray)
  - Alpha: `fa-times` (Red)
- **Empty State**: Icon inbox dengan text "Belum ada data presensi"

#### Quick Actions Panel
- **Location**: Bottom right
- **Actions**:
  1. Tambah Guru Baru → `teachers.create`
  2. Tambah Siswa Baru → `students.create`
  3. Lihat Daftar Presensi → `attendances.index`
  4. Hitung SAW Siswa → `saw.students.index`
  5. Hitung SAW Guru → `saw.teachers.index`
- **Styling**: Outline buttons dengan icons

## Technical Implementation

### Chart.js Configuration

#### Version
```html
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
```

#### Global Configuration
```javascript
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#6c757d';
```

#### Common Options
- **Responsive**: true
- **MaintainAspectRatio**: false (fixed height 250px)
- **Tooltips**: Custom dark background with padding
- **Grid**: Light gray with transparency
- **Border Radius**: 8px for bars
- **Border Width**: 2-3px with white borders

### Color Palette

#### Primary Gradient
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%)
```

#### Chart Colors
- **Purple**: `rgba(102, 126, 234, 0.8)`
- **Violet**: `rgba(118, 75, 162, 0.8)`
- **Green**: `rgba(52, 211, 153, 0.8)` / `rgba(34, 197, 94, 0.8)`
- **Yellow**: `rgba(251, 191, 36, 0.8)`
- **Red**: `rgba(239, 68, 68, 0.8)`
- **Blue**: `rgba(59, 130, 246, 0.8)`
- **Gray**: `rgba(156, 163, 175, 0.8)`

### Responsive Design

#### Breakpoints
- **col-md-3**: 4 columns on desktop
- **col-sm-6**: 2 columns on tablet
- **col-md-6**: 2 columns for charts
- Full width on mobile (automatic Bootstrap behavior)

#### Card Heights
- Stat cards: Auto height with `h-100`
- Chart cards: Fixed 250px canvas height
- Mini stat cards: `py-3` compact padding

### Data Sources

All data queries use Eloquent ORM with:
- **Eager Loading**: `with()` for relationships
- **Counts**: `withCount()` for related counts
- **Grouping**: `groupBy()` for aggregations
- **Ordering**: `orderBy()` / `orderByDesc()`
- **Limits**: `take()` for top N items
- **Date Filtering**: `where('date', ...)` for daily data

### Performance Optimizations

1. **Minimal Queries**: All stats calculated in-blade (no N+1)
2. **Caching Opportunities**: Data can be cached for X minutes
3. **Lazy Loading Charts**: Charts init on `DOMContentLoaded`
4. **Indexed Dates**: Date columns indexed for fast filtering

## UI/UX Features

### Visual Hierarchy
1. **Level 1**: Big stat cards with gradient backgrounds
2. **Level 2**: Tahun ajaran badge (top-right indicator)
3. **Level 3**: Mini stat cards with border accents
4. **Level 4**: Charts for deep insights
5. **Level 5**: Activity tables for recent data

### Micro-interactions
- **Card Shadows**: `shadow-sm` for depth
- **Border Accents**: Colored left borders (`border-start`)
- **Gradient Backgrounds**: Purple gradient for primary elements
- **Icon Opacity**: 50% opacity for background icons
- **Hover Effects**: Table rows with hover state
- **Chart Animations**: Default Chart.js animations

### Accessibility
- **Icons**: Always paired with text labels
- **Colors**: Sufficient contrast ratios
- **Tooltips**: Descriptive labels with units
- **Empty States**: Clear messaging when no data

## Future Enhancements

### Potential Additions
1. **Date Range Picker**: Filter charts by custom date range
2. **Export to PDF**: Download dashboard as PDF report
3. **Real-time Updates**: Auto-refresh dengan WebSockets
4. **Comparison Mode**: Compare with previous period
5. **Drill-down**: Click charts to see detailed data
6. **More Charts**:
   - Grade distribution histogram
   - Teacher workload distribution
   - Monthly attendance heatmap
   - Subject popularity ranking
7. **Widgets**: Draggable/customizable dashboard widgets
8. **Notifications**: Alert badges for low attendance, etc.

### Performance Improvements
1. Cache dashboard data (5-10 minutes)
2. Lazy load charts on scroll (Intersection Observer)
3. Server-side chart rendering for complex data
4. Database view for aggregated stats

## Integration Points

### Connected Modules
- **Teacher Management**: Teacher count, user mapping
- **Student Management**: Student count by grade/class
- **Class Management**: Capacity calculations
- **Subject Management**: Total subjects
- **Attendance System**: Daily/weekly trends
- **Grade System**: Total grades, distributions
- **Academic Year**: Active year display
- **User Management**: Total users

### Database Tables Used
- `teachers` - Count total teachers
- `students` - Count by status, join with classes
- `classes` - Count, capacity sum, student relationships
- `subjects` - Count total subjects
- `attendances` - Daily/weekly counts, status breakdown
- `grades` - Count total grades
- `academic_years` - Active year, count total
- `users` - Count total users

## Maintenance Notes

### Regular Checks
- Ensure Chart.js CDN is accessible
- Monitor query performance on large datasets
- Update color palette if branding changes
- Test responsive behavior on all devices

### Known Limitations
- Charts may load slowly if dataset > 10,000 records
- Date filtering limited to pre-defined ranges
- No real-time updates (requires page refresh)

---

**Created**: November 2025  
**Version**: 2.0  
**Library**: Chart.js 4.4.0  
**Framework**: Bootstrap 5.3.0
