# Dokumentasi Teknis Sistem

## Arsitektur Sistem

### Technology Stack
- **Backend Framework**: Laravel 11.x
- **Database**: MySQL 8.0
- **Frontend**: Bootstrap 5.3, Vanilla JavaScript
- **Authentication**: Laravel Breeze (Modified)
- **Icons**: Font Awesome 6.4

### Design Pattern
- **MVC (Model-View-Controller)**
- **Repository Pattern** untuk SAW Service
- **Polymorphic Relationships** untuk Attendance
- **Role-Based Access Control (RBAC)**

## Struktur Folder

```
laravel-starter/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Autentikasi
│   │   │   ├── AttendanceController.php    # Presensi
│   │   │   ├── GradeController.php         # Nilai
│   │   │   ├── SAWController.php           # Metode SAW
│   │   │   ├── StudentController.php       # CRUD Siswa
│   │   │   └── TeacherController.php       # CRUD Guru
│   │   └── Middleware/
│   │       └── CheckRole.php               # Role middleware
│   ├── Models/
│   │   ├── Attendance.php                  # Model Presensi
│   │   ├── ClassRoom.php                   # Model Kelas
│   │   ├── Criteria.php                    # Model Kriteria SAW
│   │   ├── Grade.php                       # Model Nilai
│   │   ├── Role.php                        # Model Role
│   │   ├── Student.php                     # Model Siswa
│   │   ├── StudentAssessment.php           # Model Penilaian Siswa
│   │   ├── Subject.php                     # Model Mata Pelajaran
│   │   ├── Teacher.php                     # Model Guru
│   │   ├── TeacherAssessment.php           # Model Penilaian Guru
│   │   ├── TeacherSubject.php              # Model Guru-Mapel
│   │   └── User.php                        # Model User
│   └── Services/
│       └── SAWService.php                  # Service SAW
├── database/
│   ├── migrations/                         # Database migrations
│   └── seeders/                            # Database seeders
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php            # Halaman login
│       ├── dashboard/
│       │   ├── admin.blade.php            # Dashboard admin
│       │   ├── headmaster.blade.php       # Dashboard kepsek
│       │   └── teacher.blade.php          # Dashboard guru
│       └── layouts/
│           └── app.blade.php              # Layout utama
└── routes/
    └── web.php                             # Route definitions
```

## Database Schema

### Entity Relationship Diagram (ERD)

```
users
├── id (PK)
├── role_id (FK -> roles)
├── name
├── email
└── password

roles
├── id (PK)
├── name
└── description

teachers
├── id (PK)
├── user_id (FK -> users)
├── nip
├── name
└── ...

students
├── id (PK)
├── class_id (FK -> classes)
├── nisn
├── nis
└── ...

attendances (Polymorphic)
├── id (PK)
├── attendable_type
├── attendable_id
├── date
├── check_in
├── latitude_in
├── longitude_in
└── status

grades
├── id (PK)
├── student_id (FK -> students)
├── subject_id (FK -> subjects)
├── teacher_id (FK -> teachers)
├── daily_test
├── midterm_exam
├── final_exam
└── final_grade

criteria
├── id (PK)
├── code
├── name
├── type (benefit/cost)
├── weight
└── for (student/teacher)

student_assessments
├── id (PK)
├── student_id (FK -> students)
├── class_id (FK -> classes)
├── academic_score
├── attendance_score
├── behavior_score
├── skill_score
├── saw_score
└── rank

teacher_assessments
├── id (PK)
├── teacher_id (FK -> teachers)
├── attendance_score
├── teaching_quality
├── student_achievement
├── discipline_score
├── saw_score
└── rank
```

## API Endpoints (Internal)

### Authentication
```
GET  /login           - Show login form
POST /login           - Process login
POST /logout          - Logout user
```

### Dashboard
```
GET  /dashboard       - Show role-based dashboard
```

### Teachers (Admin only)
```
GET    /teachers              - List all teachers
GET    /teachers/create       - Show create form
POST   /teachers              - Store new teacher
GET    /teachers/{id}         - Show teacher detail
GET    /teachers/{id}/edit    - Show edit form
PUT    /teachers/{id}         - Update teacher
DELETE /teachers/{id}         - Delete teacher
```

### Students (Admin only)
```
GET    /students              - List all students
GET    /students/create       - Show create form
POST   /students              - Store new student
GET    /students/{id}         - Show student detail
GET    /students/{id}/edit    - Show edit form
PUT    /students/{id}         - Update student
DELETE /students/{id}         - Delete student
```

### Attendance
```
GET  /attendance                    - List attendance
POST /attendance/check-in           - Check-in with geolocation
POST /attendance/check-out          - Check-out with geolocation
GET  /attendance/class/{class}      - Class attendance form
POST /attendance/class/{class}      - Save class attendance
```

### Grades (Admin & Guru)
```
GET  /grades                      - List grades
GET  /grades/create               - Create form
POST /grades/input-by-class       - Input by class
POST /grades/store-multiple       - Store multiple grades
GET  /grades/{id}/edit            - Edit form
PUT  /grades/{id}                 - Update grade
DELETE /grades/{id}               - Delete grade
```

### SAW (Admin & Kepala Sekolah)
```
GET  /saw/students                - Student SAW index
POST /saw/students/calculate      - Calculate student SAW
GET  /saw/teachers                - Teacher SAW index
POST /saw/teachers/calculate      - Calculate teacher SAW
```

## Algoritma SAW

### Pseudocode Perhitungan SAW

```
FUNCTION calculateSAW(data, type):
    // Get criteria based on type (student/teacher)
    criteria = getCriteria(type)
    
    // Step 1: Build decision matrix
    matrix = []
    FOR each item IN data:
        row = []
        FOR each criterion IN criteria:
            row.push(item[criterion.code])
        matrix.push(row)
    
    // Step 2: Normalize matrix
    normalizedMatrix = []
    FOR each criterion IN criteria:
        values = getColumnValues(matrix, criterion)
        
        IF criterion.type == 'benefit':
            maxValue = MAX(values)
            FOR each value IN values:
                normalizedValue = value / maxValue
                normalizedMatrix.push(normalizedValue)
        ELSE: // cost
            minValue = MIN(values)
            FOR each value IN values:
                normalizedValue = minValue / value
                normalizedMatrix.push(normalizedValue)
    
    // Step 3: Calculate preference values
    sawScores = []
    FOR each row IN normalizedMatrix:
        score = 0
        FOR i = 0 TO criteria.length:
            score += row[i] * criteria[i].weight
        sawScores.push(score)
    
    // Step 4: Rank alternatives
    rankedData = sortByScore(sawScores, DESCENDING)
    assignRanks(rankedData)
    
    RETURN rankedData
```

### Contoh Perhitungan Manual

**Data Siswa:**
| Siswa | Akademik (C1) | Kehadiran (C2) | Sikap (C3) | Keterampilan (C4) |
|-------|---------------|----------------|------------|-------------------|
| A1    | 85            | 95             | 80         | 85                |
| A2    | 90            | 90             | 85         | 90                |
| A3    | 80            | 85             | 90         | 80                |

**Bobot Kriteria:**
- C1 (Akademik): 0.35
- C2 (Kehadiran): 0.25
- C3 (Sikap): 0.20
- C4 (Keterampilan): 0.20

**Normalisasi (Benefit):**
```
R11 = 85/90 = 0.944
R12 = 95/95 = 1.000
R13 = 80/90 = 0.889
R14 = 85/90 = 0.944

R21 = 90/90 = 1.000
R22 = 90/95 = 0.947
R23 = 85/90 = 0.944
R24 = 90/90 = 1.000

R31 = 80/90 = 0.889
R32 = 85/95 = 0.895
R33 = 90/90 = 1.000
R34 = 80/90 = 0.889
```

**Perhitungan SAW:**
```
V1 = (0.944×0.35) + (1.000×0.25) + (0.889×0.20) + (0.944×0.20) = 0.948
V2 = (1.000×0.35) + (0.947×0.25) + (0.944×0.20) + (1.000×0.20) = 0.975
V3 = (0.889×0.35) + (0.895×0.25) + (1.000×0.20) + (0.889×0.20) = 0.917
```

**Ranking:**
1. Siswa A2 (0.975)
2. Siswa A1 (0.948)
3. Siswa A3 (0.917)

## Security Features

### 1. Authentication & Authorization
- Password hashing dengan bcrypt
- Session-based authentication
- Role-based access control
- CSRF protection

### 2. Input Validation
```php
$validated = $request->validate([
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6',
    'nip' => 'required|unique:teachers',
]);
```

### 3. SQL Injection Prevention
- Menggunakan Eloquent ORM
- Prepared statements
- Parameter binding

### 4. XSS Prevention
- Blade escaping `{{ $variable }}`
- HTML purification pada input

### 5. CSRF Protection
```php
@csrf
```

## Performance Optimization

### 1. Database Optimization
- Indexing pada foreign keys
- Indexing pada search fields
- Eager loading untuk relasi

```php
$teachers = Teacher::with('user.role')->get();
```

### 2. Caching
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Query Optimization
```php
// Bad
foreach ($students as $student) {
    $student->classRoom; // N+1 query
}

// Good
$students = Student::with('classRoom')->get();
```

## Testing

### Unit Testing
```bash
php artisan test
```

### Feature Testing
```php
public function test_admin_can_create_teacher()
{
    $admin = User::factory()->admin()->create();
    
    $response = $this->actingAs($admin)
        ->post('/teachers', [
            'nip' => '123456',
            'name' => 'Test Teacher',
            'email' => 'test@test.com',
            // ...
        ]);
    
    $response->assertStatus(302);
    $this->assertDatabaseHas('teachers', ['nip' => '123456']);
}
```

## Maintenance

### Backup Database
```bash
# Daily backup
php artisan backup:run

# Manual backup
mysqldump -u root -p smpn4_presensi > backup_$(date +%Y%m%d).sql
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Monitor Logs
```bash
tail -f storage/logs/laravel.log
```

## Future Enhancements

1. **Export laporan ke PDF/Excel**
2. **Notifikasi email/SMS untuk presensi**
3. **Dashboard analytics dengan Chart.js**
4. **Mobile app untuk presensi**
5. **QR Code untuk presensi guru**
6. **Integration dengan SIAKAD nasional**
7. **Multi-language support**
8. **Dark mode**

## References

- Laravel Documentation: https://laravel.com/docs
- Bootstrap Documentation: https://getbootstrap.com
- SAW Method: Fishburn, P.C. (1967)
- Geolocation API: https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API
