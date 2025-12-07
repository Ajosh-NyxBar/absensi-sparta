<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Nilai</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        .header h2 { margin: 5px 0; color: #667eea; }
        .header p { margin: 3px 0; color: #666; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table thead th {
            background-color: #667eea;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        table tbody td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
        }
        table tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMPN 4 PURWAKARTA</h2>
        <p>Laporan Nilai Siswa</p>
        @if($class)
            <p>Kelas: {{ $class->name }}</p>
        @endif
        @if($academicYear)
            <p>Tahun Ajaran: {{ $academicYear }}</p>
        @endif
        @if($semester)
            <p>Semester: {{ $semester }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="10%">NIS</th>
                <th width="18%">Nama Siswa</th>
                <th width="20%">Mata Pelajaran</th>
                <th width="10%">TA</th>
                <th width="6%">Sem</th>
                <th width="7%">Tugas</th>
                <th width="7%">UTS</th>
                <th width="7%">UAS</th>
                <th width="7%">Akhir</th>
                <th width="4%">Pred</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grades as $index => $grade)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $grade->student->nis ?? '-' }}</td>
                <td>{{ $grade->student->name ?? '-' }}</td>
                <td>{{ $grade->subject->name ?? '-' }}</td>
                <td>{{ $grade->academic_year }}</td>
                <td>{{ $grade->semester }}</td>
                <td style="text-align: center;">{{ $grade->assignment_grade ?? 0 }}</td>
                <td style="text-align: center;">{{ $grade->midterm_grade ?? 0 }}</td>
                <td style="text-align: center;">{{ $grade->final_exam_grade ?? 0 }}</td>
                <td style="text-align: center;"><strong>{{ $grade->final_grade ?? 0 }}</strong></td>
                <td style="text-align: center;">
                    @php
                        $letter = 'E';
                        if($grade->final_grade >= 90) $letter = 'A';
                        elseif($grade->final_grade >= 80) $letter = 'B';
                        elseif($grade->final_grade >= 70) $letter = 'C';
                        elseif($grade->final_grade >= 60) $letter = 'D';
                    @endphp
                    {{ $letter }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align: center; padding: 20px;">Tidak ada data nilai</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>Total Data: {{ $grades->count() }}</p>
    </div>
</body>
</html>
