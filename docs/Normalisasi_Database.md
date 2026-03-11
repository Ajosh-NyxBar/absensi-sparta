# Analisis Normalisasi Database

## Sistem Informasi Absensi Guru & Penilaian Siswa — SMPN 4 Purwakarta

---

## 1. Pendahuluan

Normalisasi database adalah proses sistematis untuk mengorganisasi kolom dan tabel agar meminimalkan redundansi data dan mencegah anomali (insert, update, delete anomaly). Dokumen ini membuktikan bahwa seluruh 18 tabel dalam sistem telah memenuhi **Bentuk Normal ke-3 (3NF)**.

---

## 2. Aturan Normalisasi

| Normal Form | Aturan | Penjelasan |
|-------------|--------|------------|
| **1NF** | Setiap kolom bernilai atomik, tidak ada repeating group | Satu sel = satu nilai, tidak ada array/list dalam satu kolom |
| **2NF** | Memenuhi 1NF + tidak ada partial dependency | Atribut non-key bergantung penuh pada seluruh primary key (bukan sebagian) |
| **3NF** | Memenuhi 2NF + tidak ada transitive dependency | Atribut non-key tidak bergantung pada atribut non-key lainnya |

---

## 3. Analisis Per Tabel

### 3.1 Tabel `users`

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| name | - | Bergantung langsung pada id ✅ |
| email | UNIQUE | Bergantung langsung pada id ✅ |
| role_id | FK | Foreign key ke tabel roles (bukan role_name!) ✅ |
| password | - | Bergantung langsung pada id ✅ |
| profile_photo | - | Bergantung langsung pada id ✅ |

**Analisis:**
- ✅ **1NF**: Semua kolom bernilai atomik (tidak ada kolom berisi daftar role atau data gabungan)
- ✅ **2NF**: PK adalah `id` (single column) → tidak mungkin ada partial dependency
- ✅ **3NF**: Data role (nama role, deskripsi) disimpan di tabel `roles`, bukan di tabel `users`. Kolom `role_id` hanya menyimpan referensi (FK). Ini menghindari transitive dependency: `id → role_id → role_name`

**Jika TIDAK dinormalisasi (buruk):**
```
users: id, name, email, password, role_name, role_description
```
Masalah: Jika nama role berubah dari "Guru" → "Tenaga Pengajar", harus update di SETIAP baris user yang memiliki role tersebut (update anomaly).

---

### 3.2 Tabel `roles`

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| name | - | Bergantung langsung pada id ✅ |
| description | - | Bergantung langsung pada id ✅ |

**Analisis:**
- ✅ **1NF**: Kolom name menyimpan satu nilai (tidak ada daftar permission dalam kolom)
- ✅ **2NF**: PK single column
- ✅ **3NF**: Tidak ada transitive dependency

---

### 3.3 Tabel `teachers`

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| user_id | FK → users | Relasi ke akun login ✅ |
| nip | UNIQUE | Bergantung langsung pada id ✅ |
| name | - | Nama guru (bergantung pada id) ✅ |
| gender, phone, address, ... | - | Data personal guru ✅ |

**Analisis:**
- ✅ **1NF**: Semua kolom atomik. `gender` menggunakan ENUM (L/P), bukan "Laki-laki, Perempuan"
- ✅ **2NF**: PK single column → tidak ada partial dependency
- ✅ **3NF**: Data akun login (email, password) tidak disimpan di tabel teachers, melainkan di tabel `users` melalui FK `user_id`. Ini menghindari: `teacher.id → teacher.user_id → user.email` (transitive dependency jika email disimpan di tabel teachers)

**Pemisahan teachers ↔ users:**  
Dipisahkan karena tidak semua user adalah guru (ada Admin, Kepala Sekolah, Kiosk). Relasi 1:1 (`users.id ← teachers.user_id`) memungkinkan guru memiliki akun login sekaligus data profil lengkap.

---

### 3.4 Tabel `students`

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| class_id | FK → classes | Kelas siswa ✅ |
| nisn, nis | UNIQUE | Identifier unik siswa ✅ |
| name, gender, ... | - | Data personal siswa ✅ |

**Analisis:**
- ✅ **1NF**: Setiap kolom atomik. Nama kelas (VII-A) tidak disimpan langsung di students, melainkan melalui FK `class_id`
- ✅ **2NF**: PK single column
- ✅ **3NF**: Data kelas (nama, grade, capacity) disimpan di tabel `classes`, bukan duplikasi di setiap baris siswa

**Jika TIDAK dinormalisasi:**
```
students: id, nisn, name, class_name, class_grade, class_capacity
```
Masalah: Jika nama kelas berubah dari "VII-A" → "7-A", harus update di 30+ baris siswa (update anomaly). Jika kelas baru dibuat tapi belum ada siswa, data kelas tidak bisa disimpan (insert anomaly).

---

### 3.5 Tabel `attendances` (Polymorphic)

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| attendable_type | Morphic | Model class (Teacher/Student) |
| attendable_id | Morphic | ID model terkait |
| date | - | Tanggal kehadiran |
| check_in, check_out | - | Waktu masuk/pulang |
| status | - | Status kehadiran |
| latitude_in, longitude_in | - | Koordinat check-in |
| latitude_out, longitude_out | - | Koordinat check-out |
| qr_code | - | QR payload yang di-scan |

**Analisis:**
- ✅ **1NF**: Setiap field atomik. Koordinat dipisah menjadi latitude & longitude, bukan string "lat,lng"
- ✅ **2NF**: PK single column (`id`)
- ✅ **3NF**: Data guru/siswa tidak diduplikasi di tabel kehadiran. Hanya menyimpan referensi (`attendable_type` + `attendable_id`)

**Keunggulan Polymorphic vs Dua Tabel:**
```
❌ Buruk: teacher_attendances + student_attendances (kolom identik, duplikasi struktur)
✅ Baik: attendances (polymorphic, satu tabel untuk keduanya)
```

---

### 3.6 Tabel `grades`

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| student_id | FK → students | Siswa yang dinilai |
| subject_id | FK → subjects | Mata pelajaran |
| teacher_id | FK → teachers | Guru penilai |
| semester, academic_year | - | Periode |
| daily_test, midterm_exam, final_exam | - | Komponen nilai |
| final_grade | - | Nilai akhir (calculated) |
| behavior_score, skill_score | - | Nilai tambahan |

**Analisis:**
- ✅ **1NF**: Setiap komponen nilai disimpan terpisah (daily_test, midterm_exam, final_exam), bukan JSON
- ✅ **2NF**: PK single column
- ✅ **3NF**: Data siswa, mapel, dan guru tidak diduplikasi. Menggunakan FK ke tabel masing-masing
- ✅ **Unique constraint**: `UNIQUE(student_id, subject_id, semester, academic_year)` → mencegah duplikasi nilai

**Catatan `final_grade`:** Kolom ini merupakan **derived attribute** (dihitung dari daily_test, midterm_exam, final_exam). Penyimpanan di database valid untuk alasan performa (menghindari kalkulasi berulang) dan historical accuracy (formula bisa berubah tanpa mempengaruhi data lama).

---

### 3.7 Tabel `teacher_subjects` (Pivot Table)

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| teacher_id | FK → teachers | Guru |
| subject_id | FK → subjects | Mata pelajaran |
| class_id | FK → classes | Kelas |
| academic_year | - | Tahun ajaran |

**Analisis:**
- ✅ Implementasi relasi **many-to-many** antara teachers, subjects, dan classes
- ✅ Menghindari penyimpanan daftar mapel di kolom guru (melanggar 1NF)
- ✅ Setiap baris merepresentasikan satu penugasan spesifik

**Jika TIDAK dinormalisasi:**
```
teachers: id, name, subjects_taught ("Matematika, IPA, Bahasa Indonesia")
```
Masalah: Melanggar 1NF (kolom berisi list). Sulit untuk query "guru yang mengajar Matematika" dan tidak bisa menyimpan informasi kelas per penugasan.

---

### 3.8 Tabel `criteria`

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| code | UNIQUE | Kode kriteria (C1, K1, dst.) |
| name | - | Nama kriteria |
| type | - | benefit/cost |
| weight | - | Bobot desimal |
| for | - | student/teacher |

**Analisis:**
- ✅ **1NF–3NF**: Setiap kriteria satu baris. Tipe dan bobot melekat langsung pada kriteria, bukan entitas lain (tidak ada transitive dependency)

---

### 3.9 Tabel `student_assessments`

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| student_id | FK → students | Siswa |
| class_id | FK → classes | Kelas |
| semester, academic_year | - | Periode |
| academic_score, attendance_score, behavior_score, skill_score | - | Skor per kriteria |
| saw_score | - | Nilai preferensi SAW |
| rank | - | Ranking |

**Analisis:**
- ✅ **3NF**: Data siswa dan kelas tidak diduplikasi. Penyimpanan skor per kriteria terpisah (bukan JSON), memungkinkan query analitik
- ✅ **Unique**: `UNIQUE(student_id, semester, academic_year)` → satu siswa satu hasil SAW per periode

---

### 3.10 Tabel `settings` (Key-Value Store)

| Kolom | Tipe Key | Keterangan |
|-------|----------|------------|
| **id** | PK | Primary key |
| key | UNIQUE | Kunci setting |
| value | - | Nilai setting |
| type, group | - | Metadata |

**Analisis:**  
Ini merupakan **EAV (Entity-Attribute-Value) pattern**, bukan tabel relasional tradisional. Dipilih karena:
- Jumlah setting bisa bertambah tanpa alter tabel
- Setting bersifat heterogen (string, number, boolean, file path, JSON)
- Caching efisien menggunakan satu key

---

## 4. Diagram Ketergantungan Fungsional (FD)

### Tabel users
```
id → name, email, role_id, password, profile_photo
```
- Tidak ada partial dependency (PK = single column)
- Tidak ada transitive dependency (role_id hanya FK, bukan data role itu sendiri)

### Tabel grades
```
id → student_id, subject_id, teacher_id, semester, academic_year,
     daily_test, midterm_exam, final_exam, final_grade,
     behavior_score, skill_score, notes
```
- `{student_id, subject_id, semester, academic_year}` → candidate key (unique constraint)
- `final_grade` tergantung pada `{daily_test, midterm_exam, final_exam}` → **derived attribute** (acceptable)

### Tabel attendances
```
id → attendable_type, attendable_id, date, check_in, check_out,
     status, latitude_in, longitude_in, latitude_out, longitude_out,
     qr_code, notes
```
- `{attendable_type, attendable_id, date}` → candidate key (satu entity satu kehadiran per hari)

---

## 5. Ringkasan Hasil Normalisasi

| No | Tabel | 1NF | 2NF | 3NF | Catatan |
|----|-------|:---:|:---:|:---:|---------|
| 1 | users | ✅ | ✅ | ✅ | FK role_id menghindari transitive dependency |
| 2 | roles | ✅ | ✅ | ✅ | Tabel lookup sederhana |
| 3 | teachers | ✅ | ✅ | ✅ | FK user_id, data akun di users |
| 4 | students | ✅ | ✅ | ✅ | FK class_id, data kelas di classes |
| 5 | classes | ✅ | ✅ | ✅ | Atribut langsung pada PK |
| 6 | subjects | ✅ | ✅ | ✅ | Tabel lookup sederhana |
| 7 | teacher_subjects | ✅ | ✅ | ✅ | Pivot table many-to-many |
| 8 | attendances | ✅ | ✅ | ✅ | Polymorphic, data entity via FK |
| 9 | grades | ✅ | ✅ | ✅ | FK ke students, subjects, teachers + unique constraint |
| 10 | criteria | ✅ | ✅ | ✅ | Tabel definisi SAW |
| 11 | student_assessments | ✅ | ✅ | ✅ | FK ke students, classes |
| 12 | teacher_assessments | ✅ | ✅ | ✅ | FK ke teachers |
| 13 | academic_years | ✅ | ✅ | ✅ | Unique(year, semester) |
| 14 | settings | ✅ | ✅ | ✅ | EAV pattern, key unik |
| 15 | notifications | ✅ | ✅ | ✅ | FK user_id (nullable untuk broadcast) |
| 16 | cache | ✅ | ✅ | ✅ | Laravel system table |
| 17 | jobs | ✅ | ✅ | ✅ | Laravel system table |
| 18 | sessions | ✅ | ✅ | ✅ | Laravel system table |

**Kesimpulan:** Seluruh 18 tabel dalam database sistem telah memenuhi **Bentuk Normal ke-3 (3NF)**. Tidak ditemukan partial dependency maupun transitive dependency. Redundansi data diminimalkan melalui pemisahan entitas ke tabel terpisah dan penggunaan foreign key, polymorphic relationship, serta pivot table.
