<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Presensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            color: #667eea;
        }
        .header p {
            margin: 3px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table thead th {
            background-color: #667eea;
            color: white;
            padding: 8px 5px;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
        }
        table tbody td {
            padding: 6px 5px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        table tbody td.left {
            text-align: left;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef9c3; color: #854d0e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-secondary { background: #f3f4f6; color: #374151; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .section-title {
            margin-top: 25px;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMPN 4 PURWAKARTA</h2>
        <p>Rekap Laporan Presensi</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
        @if($type)
            <p>Jenis: {{ $type === 'teacher' ? 'Guru' : 'Siswa' }}</p>
        @endif
    </div>

    @php
        $teachers = $summaries->where('attendable_type', 'App\Models\Teacher')->sortBy(fn($s) => $s->attendable->name ?? '');
        $students = $summaries->where('attendable_type', 'App\Models\Student')->sortBy(fn($s) => $s->attendable->name ?? '');

        // Hitung total statistik guru
        $totalTeacherDays = $teachers->sum('total_days');
        $totalTeacherPresent = $teachers->sum('present') + $teachers->sum('late');
        $totalTeacherSick = $teachers->sum('sick');
        $totalTeacherPermission = $teachers->sum('permission');
        $totalTeacherAbsent = $teachers->sum('absent');
        $totalTeacherNotPresent = $totalTeacherSick + $totalTeacherPermission + $totalTeacherAbsent;
        $pctTeacher = $totalTeacherDays > 0 ? round(($totalTeacherPresent / $totalTeacherDays) * 100, 2) : 0;

        // Hitung total statistik siswa
        $totalStudentDays = $students->sum('total_days');
        $totalStudentPresent = $students->sum('present') + $students->sum('late');
        $totalStudentSick = $students->sum('sick');
        $totalStudentPermission = $students->sum('permission');
        $totalStudentAbsent = $students->sum('absent');
        $totalStudentNotPresent = $totalStudentSick + $totalStudentPermission + $totalStudentAbsent;
        $pctStudent = $totalStudentDays > 0 ? round(($totalStudentPresent / $totalStudentDays) * 100, 2) : 0;
    @endphp

    @if($teachers->isNotEmpty())
    <div style="background: #f0f4ff; border: 2px solid #667eea; border-radius: 8px; padding: 12px 15px; margin-bottom: 15px; margin-top: 10px;">
        <table style="width: 100%; border: none; margin: 0;">
            <tr>
                <td style="border: none; padding: 5px; text-align: center; width: 25%;">
                    <div style="font-size: 24px; font-weight: bold; color: #667eea;">{{ $pctTeacher }}%</div>
                    <div style="font-size: 9px; color: #666;">Tingkat Kehadiran Guru</div>
                </td>
                <td style="border: none; padding: 5px; text-align: center; width: 15%;">
                    <div style="font-size: 16px; font-weight: bold; color: #166534;">{{ $totalTeacherPresent }}</div>
                    <div style="font-size: 9px; color: #666;">Total Hadir</div>
                </td>
                <td style="border: none; padding: 5px; text-align: center; width: 15%;">
                    <div style="font-size: 16px; font-weight: bold; color: #991b1b;">{{ $totalTeacherNotPresent }}</div>
                    <div style="font-size: 9px; color: #666;">Total Tidak Hadir</div>
                </td>
                <td style="border: none; padding: 5px; text-align: center; width: 15%;">
                    <div style="font-size: 12px; color: #1e40af;">Sakit: {{ $totalTeacherSick }}</div>
                    <div style="font-size: 12px; color: #854d0e;">Izin: {{ $totalTeacherPermission }}</div>
                    <div style="font-size: 12px; color: #991b1b;">Alpha: {{ $totalTeacherAbsent }}</div>
                </td>
                <td style="border: none; padding: 5px; text-align: center; width: 15%;">
                    <div style="font-size: 14px; font-weight: bold; color: #333;">{{ $teachers->count() }}</div>
                    <div style="font-size: 9px; color: #666;">Jumlah Guru</div>
                </td>
            </tr>
        </table>
    </div>

    <p class="section-title">Rekap Presensi Guru</p>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Guru</th>
                <th width="8%">Total Hari</th>
                <th width="8%">Hadir</th>
                <th width="10%">Terlambat</th>
                <th width="8%">Sakit</th>
                <th width="8%">Izin</th>
                <th width="8%">Alpha</th>
                <th width="15%">% Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $index => $row)
            @php
                $hadir = $row->present + $row->late;
                $pct = $row->total_days > 0 ? round(($hadir / $row->total_days) * 100, 1) : 0;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="left">{{ $row->attendable->name ?? '-' }}</td>
                <td>{{ $row->total_days }}</td>
                <td><span class="badge badge-success">{{ $row->present }}</span></td>
                <td><span class="badge badge-warning">{{ $row->late }}</span></td>
                <td><span class="badge badge-info">{{ $row->sick }}</span></td>
                <td><span class="badge badge-secondary">{{ $row->permission }}</span></td>
                <td><span class="badge badge-danger">{{ $row->absent }}</span></td>
                <td>{{ $pct }}%</td>
            </tr>
            @endforeach
            <tr style="background-color: #f0f4ff; font-weight: bold;">
                <td colspan="2" class="left" style="font-weight: bold;">TOTAL / RATA-RATA</td>
                <td>{{ $totalTeacherDays }}</td>
                <td>{{ $teachers->sum('present') }}</td>
                <td>{{ $teachers->sum('late') }}</td>
                <td>{{ $totalTeacherSick }}</td>
                <td>{{ $totalTeacherPermission }}</td>
                <td>{{ $totalTeacherAbsent }}</td>
                <td style="font-weight: bold; color: #667eea;">{{ $pctTeacher }}%</td>
            </tr>
        </tbody>
    </table>
    @endif

    @if($students->isNotEmpty())
    <div style="background: #f0fdf4; border: 2px solid #22c55e; border-radius: 8px; padding: 12px 15px; margin-bottom: 15px; margin-top: 25px;">
        <table style="width: 100%; border: none; margin: 0;">
            <tr>
                <td style="border: none; padding: 5px; text-align: center; width: 25%;">
                    <div style="font-size: 24px; font-weight: bold; color: #22c55e;">{{ $pctStudent }}%</div>
                    <div style="font-size: 9px; color: #666;">Tingkat Kehadiran Siswa</div>
                </td>
                <td style="border: none; padding: 5px; text-align: center; width: 15%;">
                    <div style="font-size: 16px; font-weight: bold; color: #166534;">{{ $totalStudentPresent }}</div>
                    <div style="font-size: 9px; color: #666;">Total Hadir</div>
                </td>
                <td style="border: none; padding: 5px; text-align: center; width: 15%;">
                    <div style="font-size: 16px; font-weight: bold; color: #991b1b;">{{ $totalStudentNotPresent }}</div>
                    <div style="font-size: 9px; color: #666;">Total Tidak Hadir</div>
                </td>
                <td style="border: none; padding: 5px; text-align: center; width: 15%;">
                    <div style="font-size: 12px; color: #1e40af;">Sakit: {{ $totalStudentSick }}</div>
                    <div style="font-size: 12px; color: #854d0e;">Izin: {{ $totalStudentPermission }}</div>
                    <div style="font-size: 12px; color: #991b1b;">Alpha: {{ $totalStudentAbsent }}</div>
                </td>
                <td style="border: none; padding: 5px; text-align: center; width: 15%;">
                    <div style="font-size: 14px; font-weight: bold; color: #333;">{{ $students->count() }}</div>
                    <div style="font-size: 9px; color: #666;">Jumlah Siswa</div>
                </td>
            </tr>
        </table>
    </div>

    <p class="section-title">Rekap Presensi Siswa</p>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Siswa</th>
                <th width="8%">Total Hari</th>
                <th width="8%">Hadir</th>
                <th width="10%">Terlambat</th>
                <th width="8%">Sakit</th>
                <th width="8%">Izin</th>
                <th width="8%">Alpha</th>
                <th width="15%">% Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $row)
            @php
                $hadir = $row->present + $row->late;
                $pct = $row->total_days > 0 ? round(($hadir / $row->total_days) * 100, 1) : 0;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="left">{{ $row->attendable->name ?? '-' }}</td>
                <td>{{ $row->total_days }}</td>
                <td><span class="badge badge-success">{{ $row->present }}</span></td>
                <td><span class="badge badge-warning">{{ $row->late }}</span></td>
                <td><span class="badge badge-info">{{ $row->sick }}</span></td>
                <td><span class="badge badge-secondary">{{ $row->permission }}</span></td>
                <td><span class="badge badge-danger">{{ $row->absent }}</span></td>
                <td>{{ $pct }}%</td>
            </tr>
            @endforeach
            <tr style="background-color: #f0fdf4; font-weight: bold;">
                <td colspan="2" class="left" style="font-weight: bold;">TOTAL / RATA-RATA</td>
                <td>{{ $totalStudentDays }}</td>
                <td>{{ $students->sum('present') }}</td>
                <td>{{ $students->sum('late') }}</td>
                <td>{{ $totalStudentSick }}</td>
                <td>{{ $totalStudentPermission }}</td>
                <td>{{ $totalStudentAbsent }}</td>
                <td style="font-weight: bold; color: #22c55e;">{{ $pctStudent }}%</td>
            </tr>
        </tbody>
    </table>
    @endif

    @if($summaries->isEmpty())
    <p style="text-align: center; padding: 40px; color: #999;">Tidak ada data presensi pada periode ini.</p>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>Total: {{ $teachers->count() }} guru, {{ $students->count() }} siswa</p>
        @if($teachers->isNotEmpty())
        <p>Tingkat Kehadiran Guru: <strong>{{ $pctTeacher }}%</strong></p>
        @endif
        @if($students->isNotEmpty())
        <p>Tingkat Kehadiran Siswa: <strong>{{ $pctStudent }}%</strong></p>
        @endif
    </div>
</body>
</html>
