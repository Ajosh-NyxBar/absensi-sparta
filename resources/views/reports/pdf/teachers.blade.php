<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Guru</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
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
            padding: 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
        }
        table tbody td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        table tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMPN 4 PURWAKARTA</h2>
        <p>Laporan Data Guru</p>
        <p>Tanggal Cetak: {{ now()->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">NIP</th>
                <th width="18%">Nama</th>
                <th width="6%">L/P</th>
                <th width="12%">Tempat Lahir</th>
                <th width="10%">Tgl Lahir</th>
                <th width="15%">Alamat</th>
                <th width="10%">No. HP</th>
                <th width="8%">Pendidikan</th>
                <th width="5%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $index => $teacher)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $teacher->nip ?? '-' }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->gender }}</td>
                <td>{{ $teacher->place_of_birth ?? '-' }}</td>
                <td>{{ $teacher->date_of_birth ? \Carbon\Carbon::parse($teacher->date_of_birth)->format('d/m/Y') : '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($teacher->address ?? '-', 25) }}</td>
                <td>{{ $teacher->phone ?? '-' }}</td>
                <td>{{ $teacher->education ?? '-' }}</td>
                <td>{{ $teacher->user ? 'Aktif' : 'Non-Aktif' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 20px;">Tidak ada data guru</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>Total Data: {{ $teachers->count() }}</p>
    </div>
</body>
</html>
