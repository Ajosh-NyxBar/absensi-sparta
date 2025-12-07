# Manajemen Kriteria SAW

## Deskripsi
Fitur untuk mengelola kriteria penilaian Simple Additive Weighting (SAW) untuk siswa dan guru. Admin dapat membuat, mengedit, menghapus, dan menormalisasi bobot kriteria melalui antarmuka web.

## Metode SAW (Simple Additive Weighting)

### Pengertian
SAW adalah metode penjumlahan terbobot dari rating kinerja pada setiap alternatif pada semua kriteria. Metode ini membutuhkan normalisasi matriks keputusan ke skala yang dapat diperbandingkan dengan semua rating alternatif yang ada.

### Rumus SAW
```
Vi = Σ (wj × rij)
```

Dimana:
- **Vi**: Nilai preferensi alternatif ke-i
- **wj**: Bobot kriteria ke-j
- **rij**: Rating kinerja ternormalisasi alternatif i pada kriteria j
- **Σwj = 1.0**: Total bobot harus sama dengan 1

### Normalisasi
**Untuk kriteria Benefit** (semakin besar semakin baik):
```
rij = Xij / max(Xij)
```

**Untuk kriteria Cost** (semakin kecil semakin baik):
```
rij = min(Xij) / Xij
```

---

## Database Schema

### Table: `criteria`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO_INCREMENT | ID unik kriteria |
| code | VARCHAR(255) | UNIQUE, NOT NULL | Kode kriteria (C1, C2, G1, G2) |
| name | VARCHAR(255) | NOT NULL | Nama kriteria |
| type | ENUM('benefit','cost') | NOT NULL | Tipe kriteria |
| weight | DECIMAL(5,2) | NOT NULL | Bobot (0.00 - 1.00) |
| for | ENUM('student','teacher') | NOT NULL | Kategori (siswa/guru) |
| description | TEXT | NULLABLE | Deskripsi kriteria |
| created_at | TIMESTAMP | | Waktu dibuat |
| updated_at | TIMESTAMP | | Waktu diupdate |

**Indexes**:
- PRIMARY: `id`
- UNIQUE: `code`
- INDEX: `for` (untuk filtering student/teacher)

---

## Model Methods

### Criteria::forStudent()
**Purpose**: Get semua kriteria untuk siswa

**Return**: Collection

**Example**:
```php
$studentCriteria = Criteria::forStudent();
```

---

### Criteria::forTeacher()
**Purpose**: Get semua kriteria untuk guru

**Return**: Collection

**Example**:
```php
$teacherCriteria = Criteria::forTeacher();
```

---

### $criteria->isBenefit()
**Purpose**: Check apakah kriteria tipe benefit

**Return**: Boolean

**Example**:
```php
if ($criteria->isBenefit()) {
    // Normalisasi benefit: rij = Xij / max(Xij)
}
```

---

### $criteria->isCost()
**Purpose**: Check apakah kriteria tipe cost

**Return**: Boolean

**Example**:
```php
if ($criteria->isCost()) {
    // Normalisasi cost: rij = min(Xij) / Xij
}
```

---

## Controller Actions

### 1. index()
**Purpose**: Display halaman manajemen kriteria

**Route**: `GET /criteria`

**Data Passed**:
- `$studentCriteria`: Collection of student criteria
- `$teacherCriteria`: Collection of teacher criteria
- `$studentTotalWeight`: Sum of student criteria weights
- `$teacherTotalWeight`: Sum of teacher criteria weights

**View**: `resources/views/criteria/index.blade.php`

**Features**:
- Split view: Student criteria (left) vs Teacher criteria (right)
- Total weight indicator (green if 1.0, red otherwise)
- Normalize button (auto-balance weights)
- Empty state with CTA button

---

### 2. create()
**Purpose**: Show form untuk tambah kriteria

**Route**: `GET /criteria/create`

**View**: `resources/views/criteria/create.blade.php`

**Features**:
- Form dengan 6 fields (code, for, name, type, weight, description)
- Validation hints
- Example criteria table
- Help sidebar

---

### 3. store(Request $request)
**Purpose**: Simpan kriteria baru

**Route**: `POST /criteria`

**Validation**:
```php
'code' => 'required|string|max:10|unique:criteria,code'
'name' => 'required|string|max:255'
'type' => 'required|in:benefit,cost'
'weight' => 'required|numeric|min:0|max:1'
'for' => 'required|in:student,teacher'
'description' => 'nullable|string'
```

**Custom Validation**:
- Check total weight doesn't exceed 1.0
- Calculate remaining weight for category

**Success Message**: "Kriteria berhasil ditambahkan"

**Redirect**: `criteria.index`

---

### 4. show(Criteria $criteria)
**Purpose**: Display detail kriteria (optional, not implemented in UI)

**Route**: `GET /criteria/{criteria}`

---

### 5. edit(Criteria $criteria)
**Purpose**: Show form untuk edit kriteria

**Route**: `GET /criteria/{criteria}/edit`

**View**: `resources/views/criteria/edit.blade.php`

**Features**:
- Pre-filled form with current values
- Criteria info sidebar (code, category, type, current weight, timestamps)
- Warning alerts
- Tips card

---

### 6. update(Request $request, Criteria $criteria)
**Purpose**: Update kriteria yang ada

**Route**: `PUT /criteria/{criteria}`

**Validation**: Same as store() + unique code exception for current ID

**Custom Validation**:
- Check total weight excluding current criteria
- Calculate remaining weight

**Success Message**: "Kriteria berhasil diperbarui"

**Redirect**: `criteria.index`

---

### 7. destroy(Criteria $criteria)
**Purpose**: Hapus kriteria

**Route**: `DELETE /criteria/{criteria}`

**Safety Check**:
- Count usage in `student_assessments` table
- Count usage in `teacher_assessments` table
- Prevent deletion if criteria is used

**Error Message**: "Kriteria tidak dapat dihapus karena sudah digunakan dalam penilaian"

**Success Message**: "Kriteria berhasil dihapus"

**Redirect**: `criteria.index`

---

### 8. normalizeWeights(Request $request)
**Purpose**: Auto-normalize weights to sum up to 1.0

**Route**: `POST /criteria/normalize`

**Parameters**:
- `type`: student | teacher

**Process**:
1. Get all criteria for selected type
2. Calculate current total weight
3. For each criteria: `normalizedWeight = weight / totalWeight`
4. Round to 2 decimals
5. Update database

**Example**:
```
Before:
C1: 0.30
C2: 0.40
C3: 0.20
Total: 0.90

After Normalize:
C1: 0.33 (0.30 / 0.90)
C2: 0.44 (0.40 / 0.90)
C3: 0.22 (0.20 / 0.90)
Total: 1.00 (rounded)
```

**Success Message**: "Bobot kriteria berhasil dinormalisasi menjadi 1.0"

**Redirect**: `criteria.index`

---

## View Components

### Index Page (criteria/index.blade.php)

**Layout**: 2 columns (Student | Teacher)

**Each Column**:
- Header with total weight badge
- Normalize button (visible if total ≠ 1.0)
- Table with columns: Code, Name, Type, Weight, Actions
- Footer row showing total weight
- Empty state with CTA

**Info Section**:
- SAW Method explanation
- Type explanation (Benefit vs Cost)
- Weight guidelines
- Example criteria tables

**Color Coding**:
- Student header: Blue (`bg-primary`)
- Teacher header: Green (`bg-success`)
- Benefit badge: Green (`bg-success`)
- Cost badge: Red (`bg-danger`)
- Total weight: Green if 1.0, Red otherwise

---

### Create Page (criteria/create.blade.php)

**Main Form**:
- Code input (text, unique)
- Category select (student/teacher)
- Name input (text)
- Type select (benefit/cost) with explanation
- Weight input (number, 0-1, step 0.01)
- Description textarea (optional)

**Help Sidebar**:
- Tips for adding criteria
- Example student criteria table (4 criteria)
- Example teacher criteria table (4 criteria)

**Validation**:
- Required fields marked with red asterisk
- Inline validation error messages
- Bootstrap is-invalid class

---

### Edit Page (criteria/edit.blade.php)

**Main Form**: Same as create page, pre-filled

**Info Sidebar**:
- Current criteria information
  - Code
  - Category badge
  - Type badge
  - Current weight
  - Created at
  - Updated at
- Warning alerts
  - Total weight must = 1.0
  - Changes affect SAW calculation
  - Change type carefully
- Tips card
  - Benefit vs Cost explanation
  - Normalize button hint

---

## Routes

### Resource Routes (7 routes)
```php
Route::resource('criteria', CriteriaController::class);
```

1. `GET /criteria` → index (List all)
2. `GET /criteria/create` → create (Show form)
3. `POST /criteria` → store (Save new)
4. `GET /criteria/{criteria}` → show (Show one)
5. `GET /criteria/{criteria}/edit` → edit (Edit form)
6. `PUT /criteria/{criteria}` → update (Update existing)
7. `DELETE /criteria/{criteria}` → destroy (Delete)

### Custom Route (1 route)
```php
Route::post('/criteria/normalize', [CriteriaController::class, 'normalizeWeights'])
    ->name('criteria.normalize');
```

**Total**: 8 routes

**Middleware**: `CheckRole:Admin` (Admin only)

---

## Usage in SAW Calculation

### Student Ranking
```php
// Get criteria
$criteria = Criteria::forStudent();

// Get student assessments
$students = Student::with('studentAssessments')->get();

// Calculate normalized ratings
foreach ($students as $student) {
    $scores = [];
    
    foreach ($criteria as $criterion) {
        $assessment = $student->studentAssessments
            ->where('criteria_id', $criterion->id)
            ->first();
        
        $value = $assessment ? $assessment->value : 0;
        
        // Normalize based on type
        if ($criterion->isBenefit()) {
            $normalized = $value / $maxValues[$criterion->id];
        } else {
            $normalized = $minValues[$criterion->id] / $value;
        }
        
        // Multiply by weight
        $scores[] = $normalized * $criterion->weight;
    }
    
    // Sum weighted scores
    $student->saw_score = array_sum($scores);
}

// Sort by SAW score descending
$rankedStudents = $students->sortByDesc('saw_score');
```

---

## Example Criteria

### Student Criteria (Siswa)

| Code | Name | Type | Weight | Description |
|------|------|------|--------|-------------|
| C1 | Nilai Akademik | Benefit | 0.40 | Rata-rata nilai ujian semester |
| C2 | Kehadiran | Benefit | 0.30 | Persentase kehadiran (%) |
| C3 | Sikap | Benefit | 0.20 | Penilaian sikap dan perilaku |
| C4 | Pelanggaran | Cost | 0.10 | Jumlah pelanggaran tata tertib |

**Total Weight**: 1.00 (100%)

**Interpretation**:
- Nilai akademik paling penting (40%)
- Kehadiran cukup penting (30%)
- Sikap agak penting (20%)
- Pelanggaran kurang penting tapi tetap dihitung (10%)

---

### Teacher Criteria (Guru)

| Code | Name | Type | Weight | Description |
|------|------|------|--------|-------------|
| G1 | Kinerja Mengajar | Benefit | 0.35 | Penilaian kualitas mengajar |
| G2 | Kehadiran | Benefit | 0.25 | Persentase kehadiran mengajar |
| G3 | Pengabdian | Benefit | 0.25 | Kontribusi dan pengabdian |
| G4 | Keterlambatan | Cost | 0.15 | Jumlah keterlambatan |

**Total Weight**: 1.00 (100%)

**Interpretation**:
- Kinerja mengajar paling penting (35%)
- Kehadiran dan pengabdian sama penting (25% each)
- Keterlambatan cukup signifikan (15%)

---

## Validation Rules

### Code Validation
- Required
- String, max 10 characters
- Must be unique
- Recommended format: C1, C2, C3 (student) or G1, G2, G3 (teacher)

### Name Validation
- Required
- String, max 255 characters
- Should be descriptive

### Type Validation
- Required
- Must be: `benefit` or `cost`
- **Benefit**: Higher is better (nilai, kehadiran, kinerja)
- **Cost**: Lower is better (pelanggaran, keterlambatan, absensi)

### Weight Validation
- Required
- Numeric
- Min: 0.00
- Max: 1.00
- Total weight per category must = 1.00

### For (Category) Validation
- Required
- Must be: `student` or `teacher`
- Cannot be changed after criteria is used in assessments

### Description Validation
- Optional
- Text (no max length)
- Should explain how criterion is measured

---

## Weight Normalization Algorithm

### Automatic Normalization
```php
// Input: Criteria with arbitrary weights
C1: weight = 0.30
C2: weight = 0.40
C3: weight = 0.20
Total = 0.90

// Step 1: Calculate total
$totalWeight = 0.90

// Step 2: Normalize each
C1: 0.30 / 0.90 = 0.333... → 0.33
C2: 0.40 / 0.90 = 0.444... → 0.44
C3: 0.20 / 0.90 = 0.222... → 0.22

// Step 3: Update database
Total = 0.33 + 0.44 + 0.22 = 0.99 (due to rounding)

// Note: Small rounding errors acceptable
```

### Manual Adjustment
Admin can manually adjust weights after normalization if needed.

---

## Error Handling

### Duplicate Code
**Error**: "Kode kriteria sudah digunakan"

**Solution**: Use different code (C5, G5, etc.)

---

### Weight Exceeds 1.0
**Error**: "Total bobot untuk siswa akan melebihi 1.0. Sisa bobot: 0.25"

**Solution**:
1. Reduce the weight being added
2. Edit existing criteria to reduce their weights
3. Use normalize button to auto-balance

---

### Criteria In Use
**Error**: "Kriteria tidak dapat dihapus karena sudah digunakan dalam penilaian"

**Solution**:
1. Delete all assessments using this criteria first (risky)
2. Keep the criteria but set weight to 0 (not recommended)
3. Don't delete, just edit if needed

---

### Total Weight ≠ 1.0
**Warning**: Total weight badge shows red

**Solution**:
1. Click **Normalisasi** button (automatic)
2. Manually adjust weights (tedious)
3. Add/remove criteria to balance

---

## Security

### Authorization
**Middleware**: `CheckRole:Admin`

Only Admin role can:
- View criteria list
- Create new criteria
- Edit criteria
- Delete criteria
- Normalize weights

### Input Sanitization
- Laravel validation prevents SQL injection
- XSS protection via Blade escaping
- CSRF tokens on all forms

### Deletion Safety
- Check usage before delete
- Prevent orphaned assessments
- Soft delete option (future)

---

## Performance Considerations

### Query Optimization
```php
// ✅ Good: Eager load if needed
$criteria = Criteria::with('studentAssessments')->forStudent();

// ✅ Good: Separate queries for student and teacher
$studentCriteria = Criteria::where('for', 'student')->get();
$teacherCriteria = Criteria::where('for', 'teacher')->get();

// ❌ Avoid: N+1 query problem
foreach ($students as $student) {
    $assessment = StudentAssessment::where('student_id', $student->id)
        ->where('criteria_id', $criteria->id)->first();
}
```

### Caching
Currently no caching. Future enhancement:
```php
$studentCriteria = Cache::remember('criteria.student', 3600, function() {
    return Criteria::forStudent();
});
```

---

## Testing

### Manual Testing Checklist
- [ ] Create criteria dengan bobot valid
- [ ] Create criteria dengan bobot > 1.0 (should fail)
- [ ] Create duplicate code (should fail)
- [ ] Edit criteria weight
- [ ] Delete unused criteria
- [ ] Try delete criteria yang sudah dipakai (should fail)
- [ ] Normalize weights (student)
- [ ] Normalize weights (teacher)
- [ ] Total weight display accurate
- [ ] Benefit/Cost badge colors correct

### Feature Test Example
```php
public function test_admin_can_create_criteria()
{
    $admin = User::factory()->admin()->create();
    
    $this->actingAs($admin)
        ->post(route('criteria.store'), [
            'code' => 'C1',
            'name' => 'Nilai Akademik',
            'type' => 'benefit',
            'weight' => 0.40,
            'for' => 'student',
            'description' => 'Rata-rata nilai ujian'
        ])
        ->assertRedirect(route('criteria.index'))
        ->assertSessionHas('success');
    
    $this->assertDatabaseHas('criteria', [
        'code' => 'C1',
        'weight' => 0.40
    ]);
}
```

---

## Future Enhancements

### Potential Features
1. **Criteria Templates**: Pre-defined sets (akademik, sikap, kinerja)
2. **Import/Export**: Backup criteria as JSON/Excel
3. **Criteria History**: Track changes over time
4. **Weight Suggestions**: AI-based weight recommendations
5. **Criteria Grouping**: Sub-categories within student/teacher
6. **Soft Delete**: Archive criteria instead of hard delete
7. **Criteria Versioning**: Different criteria sets per academic year
8. **Visual Weight Editor**: Drag sliders to adjust weights
9. **Criteria Impact Analysis**: Show how weight changes affect rankings
10. **Criteria Dependencies**: Auto-adjust related criteria

---

**Created**: November 2025  
**Version**: 1.0  
**Module**: Criteria Management (SAW Method)
