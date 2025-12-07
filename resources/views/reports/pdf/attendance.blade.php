<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Presensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
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
            margin-top: 20px;
        }
        table thead th {
            background-color: #667eea;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        table tbody td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success { background: #22c55e; color: white; }
        .badge-warning { background: #fbbf24; color: #000; }
        .badge-danger { background: #ef4444; color: white; }
        .badge-info { background: #3b82f6; color: white; }
        .badge-secondary { background: #9ca3af; color: white; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMPN 4 PURWAKARTA</h2>
        <p>Laporan Presensi</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
        @if($type)
            <p>Jenis: {{ $type === 'teacher' ? 'Guru' : 'Siswa' }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="25%">Nama</th>
                <th width="10%">Jenis</th>
                <th width="10%">Check In</th>
                <th width="10%">Check Out</th>
                <th width="13%">Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $attendance)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                <td>{{ $attendance->attendable->name ?? '-' }}</td>
                <td>
                    @if($attendance->attendable_type === 'App\Models\Teacher')
                        Guru
                    @else
                        Siswa
                    @endif
                </td>
                <td>{{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }}</td>
                <td>{{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}</td>
                <td>
                    @if($attendance->status === 'present')
                        <span class="badge badge-success">Hadir</span>
                    @elseif($attendance->status === 'late')
                        <span class="badge badge-warning">Terlambat</span>
                    @elseif($attendance->status === 'sick')
                        <span class="badge badge-info">Sakit</span>
                    @elseif($attendance->status === 'permission')
                        <span class="badge badge-secondary">Izin</span>
                    @else
                        <span class="badge badge-danger">Alpha</span>
                    @endif
                </td>
                <td>{{ $attendance->notes ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data presensi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>Total Data: {{ $attendances->count() }}</p>
    </div>
</body>
</html>
