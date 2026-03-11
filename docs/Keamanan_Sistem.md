# Analisis Keamanan Sistem

## Sistem Informasi Absensi Guru & Penilaian Siswa — SMPN 4 Purwakarta

---

## 1. Ringkasan Keamanan

Sistem dirancang dengan pendekatan **Defense in Depth** (pertahanan berlapis), di mana setiap lapisan memiliki mekanisme keamanan tersendiri sehingga jika satu lapisan ditembus, lapisan berikutnya tetap melindungi sistem.

| Layer | Mekanisme | Deskripsi |
|-------|-----------|-----------|
| **Jaringan** | HTTPS (production) | Enkripsi data in-transit antara browser dan server |
| **Aplikasi** | CSRF Token | Mencegah Cross-Site Request Forgery |
| **Autentikasi** | Session + Bcrypt | Login berbasis session dengan hash password |
| **Otorisasi** | RBAC Middleware | Role-Based Access Control per route group |
| **Data** | AES-256-CBC | Enkripsi payload QR Code |
| **Input** | Laravel Validation | Sanitasi dan validasi setiap input pengguna |
| **Database** | Eloquent ORM | Parameterized query mencegah SQL Injection |
| **Output** | Blade Escaping | Template escaping mencegah XSS |

---

## 2. Autentikasi (Authentication)

### 2.1 Mekanisme Login

Sistem menggunakan **session-based authentication** bawaan Laravel:

1. User mengirim email + password melalui form login
2. `AuthController::login()` memvalidasi input:
   ```php
   $request->validate([
       'email' => 'required|email',
       'password' => 'required',
   ]);
   ```
3. `Auth::attempt()` membandingkan password input dengan hash Bcrypt di database
4. Jika valid, Laravel membuat session baru dan menyimpan session ID di cookie terenkripsi
5. Setiap request berikutnya, middleware `auth` memverifikasi session

### 2.2 Password Hashing

- **Algoritma**: Bcrypt (default Laravel)
- **Cost Factor**: 12 rounds (configurable di `config/hashing.php`)
- **Implementasi**: `Hash::make($password)` saat create/update user
- **Verifikasi**: `Hash::check($plain, $hashed)` secara internal oleh `Auth::attempt()`

**Kenapa Bcrypt?**
- Bcrypt dirancang khusus untuk hashing password (bukan seperti MD5/SHA yang dirancang untuk kecepatan)
- Cost factor membuat brute force sangat lambat (~100ms per percobaan vs microsecond untuk MD5)
- Setiap hash memiliki salt unik yang disimpan bersama hash, mencegah rainbow table attack
- Output format: `$2y$12$<salt+hash>` (60 karakter)

### 2.3 Proteksi Brute Force

- Laravel memiliki **rate limiting** bawaan pada route login
- Setelah beberapa kali gagal login dari IP yang sama, akan terjadi throttling
- Session invalidation otomatis setelah periode idle (default: 120 menit, configurable di `config/session.php`)

---

## 3. Otorisasi (Authorization) — RBAC

### 3.1 Role-Based Access Control

Sistem menerapkan RBAC melalui custom middleware `CheckRole`:

```php
// app/Http/Middleware/CheckRole.php
public function handle(Request $request, Closure $next, ...$roles): Response
{
    if (!$request->user()) {
        return redirect()->route('login');
    }
    $userRole = $request->user()->role->name ?? null;
    if (!in_array($userRole, $roles)) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
    return $next($request);
}
```

### 3.2 Matriks Akses per Role

| Fitur | Admin | Guru | Kepala Sekolah | Kiosk Presensi |
|-------|:-----:|:----:|:--------------:|:--------------:|
| Dashboard | ✅ | ✅ | ✅ | ✅ |
| Kelola User | ✅ | ❌ | ❌ | ❌ |
| Kelola Guru | ✅ | ❌ | ❌ | ❌ |
| Kelola Siswa | ✅ | ❌ | ❌ | ❌ |
| Kelola Kelas | ✅ | ❌ | ❌ | ❌ |
| Kelola Mapel | ✅ | ❌ | ❌ | ❌ |
| Kelola Tahun Ajaran | ✅ | ❌ | ❌ | ❌ |
| Penugasan Guru-Mapel | ✅ | ❌ | ❌ | ❌ |
| Presensi QR Code | ✅ | ✅ | ❌ | ❌ |
| Input Nilai | ✅ | ✅ | ❌ | ❌ |
| Perhitungan SAW | ✅ | ❌ | ✅ | ❌ |
| Rapor Siswa | ✅ | ❌ | ✅ | ❌ |
| Laporan & Export | ✅ | ❌ | ❌ | ❌ |
| Pengaturan Sistem | ✅ | ❌ | ❌ | ❌ |
| Kriteria SAW | ✅ | ❌ | ❌ | ❌ |
| Kehadiran Kelas | ✅ | ❌ | ❌ | ❌ |
| Tampilan Kiosk | ❌ | ❌ | ❌ | ✅ |

### 3.3 Middleware Chain

Setiap request melewati middleware chain secara berurutan:
1. **EncryptCookies** — Enkripsi/dekripsi cookie
2. **StartSession** — Memulai/melanjutkan session
3. **VerifyCsrfToken** — Validasi CSRF token (POST/PUT/DELETE)
4. **Authenticate** — Cek user sudah login
5. **CheckRole** — Cek role user sesuai dengan yang dibutuhkan route

---

## 4. Proteksi CSRF (Cross-Site Request Forgery)

### 4.1 Mekanisme

- Setiap session memiliki CSRF token unik 40 karakter
- Token disematkan di setiap form menggunakan directive `@csrf` pada Blade template
- Middleware `VerifyCsrfToken` memvalidasi token pada setiap request POST/PUT/DELETE
- Jika token tidak valid atau tidak ada, server mengembalikan HTTP 419 (Page Expired)

### 4.2 Implementasi

```html
<!-- Blade Template -->
<form method="POST" action="/attendance/check-in">
    @csrf    {{-- Menghasilkan <input type="hidden" name="_token" value="..."> --}}
    <!-- field lainnya -->
</form>
```

Untuk AJAX request, CSRF token diambil dari meta tag:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```
```javascript
// JavaScript (Alpine.js / Fetch)
headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
```

---

## 5. Enkripsi QR Code (AES-256-CBC)

### 5.1 Algoritma dan Konfigurasi

| Parameter | Nilai |
|-----------|-------|
| **Algoritma** | AES-256-CBC (Advanced Encryption Standard) |
| **Panjang Key** | 256-bit (32 byte) |
| **Mode** | CBC (Cipher Block Chaining) |
| **Key Source** | `APP_KEY` di file `.env` (di-generate oleh `php artisan key:generate`) |
| **IV** | Random 16-byte, di-generate setiap enkripsi |
| **MAC** | HMAC-SHA256 untuk integritas data |

### 5.2 Struktur Payload QR

Sebelum enkripsi, payload berupa JSON:
```json
{
    "teacher_id": 5,
    "timestamp": 1709020800,
    "type": "attendance",
    "school_lat": -6.5465236,
    "school_lng": 107.4414175
}
```

Setelah `Crypt::encryptString()`, output berupa base64-encoded string yang berisi: `IV + Ciphertext + MAC`.

### 5.3 Mekanisme Anti-Pemalsuan

1. **Time-based expiry**: Timestamp dalam payload dibandingkan dengan waktu saat scan. Jika selisih > 600 detik (10 menit), QR ditolak → mencegah **replay attack**
2. **Enkripsi**: Tanpa APP_KEY, payload tidak bisa di-dekripsi → mencegah **forgery**
3. **MAC verification**: Ciphertext yang dimodifikasi akan gagal MAC check → mencegah **tampering**
4. **Unique IV**: Setiap kali QR di-generate, ciphertext berbeda meskipun data sama → mencegah **known-plaintext attack**

---

## 6. Validasi Geolokasi (Haversine Formula)

### 6.1 Tujuan

Memastikan guru berada di dalam radius sekolah saat melakukan presensi, mencegah presensi dari lokasi remote (titip absen).

### 6.2 Implementasi Haversine

```php
function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371000; // radius bumi dalam meter
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2)
        + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
        * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $R * $c; // jarak dalam meter
}
```

### 6.3 Parameter

| Parameter | Nilai |
|-----------|-------|
| **Koordinat Sekolah** | Latitude: -6.5465236, Longitude: 107.4414175 |
| **Radius Toleransi** | 100 meter |
| **Akurasi GPS** | Menggunakan `navigator.geolocation.getCurrentPosition()` dengan `enableHighAccuracy: true` |

### 6.4 Edge Case

- Jika GPS tidak tersedia (browser tidak mendukung/izin ditolak): presensi ditolak
- Jika akurasi GPS terlalu rendah (> 50m): warning ditampilkan tetapi tetap diproses
- Jarak dihitung saat check-in dan check-out, keduanya tercatat di database (latitude_in, longitude_in, latitude_out, longitude_out)

---

## 7. Proteksi SQL Injection

### 7.1 Eloquent ORM (Parameterized Query)

Semua interaksi database menggunakan Eloquent ORM yang secara otomatis menggunakan **prepared statement**:

```php
// ✅ AMAN — Eloquent secara otomatis parameterize
$teacher = Teacher::where('nip', $request->nip)->first();
$students = Student::where('class_id', $classId)->get();

// ✅ AMAN — Query builder juga parameterized
$attendance = Attendance::where('attendable_type', 'App\Models\Teacher')
    ->where('attendable_id', $teacherId)
    ->where('date', $today)
    ->first();
```

### 7.2 Mass Assignment Protection

Model mendefinisikan `$fillable` untuk mencegah mass assignment attack:

```php
class User extends Authenticatable {
    protected $fillable = ['name', 'email', 'password', 'role_id', 'profile_photo'];
    // Hanya kolom di atas yang bisa di-assign via create() / update()
    // Kolom lain (id, timestamps) otomatis dilindungi
}
```

---

## 8. Proteksi XSS (Cross-Site Scripting)

### 8.1 Output Escaping

Blade template menggunakan `{{ }}` yang secara otomatis memanggil `htmlspecialchars()`:

```blade
{{-- ✅ AMAN — output ter-escape --}}
<p>{{ $student->name }}</p>

{{-- ❌ TIDAK AMAN — output tidak ter-escape (hanya digunakan untuk HTML yang trusted/generated server) --}}
{!! $trustedHtml !!}
```

### 8.2 Validasi Input

Setiap input divalidasi tipe datanya sebelum disimpan:
- String: `'required|string|max:255'`
- Email: `'required|email|unique:users'`
- Numeric: `'required|numeric|min:0|max:100'`
- File: `'nullable|image|mimes:jpeg,png,jpg|max:2048'`

---

## 9. Keamanan Session

| Konfigurasi | Nilai | Keterangan |
|-------------|-------|------------|
| **Driver** | `file` | Session disimpan di server (storage/framework/sessions/) |
| **Lifetime** | 120 menit | Session expired setelah 2 jam idle |
| **Encrypt** | `false` | Cookie session dienkripsi oleh EncryptCookies middleware |
| **HTTP Only** | `true` | Cookie tidak bisa diakses JavaScript (mencegah XSS steal session) |
| **Same Site** | `lax` | Cookie hanya dikirim untuk navigasi top-level (mencegah CSRF dari cross-origin) |
| **Secure** | `false` (dev) / `true` (prod) | Cookie hanya dikirim via HTTPS di production |

---

## 10. Ringkasan OWASP Top 10 Coverage

| No | Risiko OWASP | Status | Mekanisme |
|----|-------------|--------|-----------|
| A01 | Broken Access Control | ✅ Ditangani | RBAC middleware (CheckRole), route group middleware |
| A02 | Cryptographic Failures | ✅ Ditangani | AES-256-CBC untuk QR, Bcrypt untuk password, HTTPS (production) |
| A03 | Injection | ✅ Ditangani | Eloquent ORM (parameterized query), input validation |
| A04 | Insecure Design | ✅ Ditangani | Security-by-design: RBAC, encrypted QR, geolocation validation |
| A05 | Security Misconfiguration | ✅ Ditangani | APP_DEBUG=false di production, APP_KEY unique per instalasi |
| A06 | Vulnerable Components | ✅ Ditangani | Dependency managed via Composer, update reguler |
| A07 | Auth Failures | ✅ Ditangani | Bcrypt hashing, session management, rate limiting |
| A08 | Software Integrity | ✅ Ditangani | Composer lock file, MAC pada ciphertext QR |
| A09 | Logging & Monitoring | ⚠️ Partial | Laravel Log (storage/logs/), perlu integrasi monitoring eksternal |
| A10 | SSRF | ✅ N/A | Sistem tidak melakukan HTTP request ke URL dari user input |

---

## 11. Rekomendasi Keamanan Tambahan (Production)

1. **Aktifkan HTTPS** — Gunakan SSL/TLS certificate (Let's Encrypt) untuk seluruh traffic
2. **Set APP_DEBUG=false** — Tidak menampilkan error detail ke user di production
3. **Ganti password default** — Segera ganti akun seeder setelah deployment
4. **Backup reguler** — Aktifkan fitur backup otomatis melalui pengaturan sistem
5. **Update dependency** — Jalankan `composer update` secara berkala untuk patch keamanan
6. **Rate limiting** — Konfigurasi rate limit untuk API endpoint sensitif
7. **Content Security Policy** — Tambahkan CSP header untuk mencegah resource injection
8. **Logging** — Integrasikan dengan monitoring tool (Sentry, Bugsnag) untuk deteksi anomali
