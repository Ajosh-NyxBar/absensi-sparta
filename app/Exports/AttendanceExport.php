<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $startDate;
    protected $endDate;
    protected $type;

    public function __construct($startDate = null, $endDate = null, $type = null)
    {
        $this->startDate = $startDate ?? Carbon::now()->startOfMonth();
        $this->endDate = $endDate ?? Carbon::now()->endOfMonth();
        $this->type = $type;
    }

    public function collection()
    {
        $query = Attendance::with('attendable')
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        if ($this->type) {
            $model = $this->type === 'teacher' ? 'App\Models\Teacher' : 'App\Models\Student';
            $query->where('attendable_type', $model);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama',
            'Jenis',
            'Check In',
            'Check Out',
            'Status',
            'Keterangan'
        ];
    }

    public function map($attendance): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            Carbon::parse($attendance->date)->format('d/m/Y'),
            $attendance->attendable->name ?? '-',
            $attendance->attendable_type === 'App\Models\Teacher' ? 'Guru' : 'Siswa',
            $attendance->check_in ? Carbon::parse($attendance->check_in)->format('H:i') : '-',
            $attendance->check_out ? Carbon::parse($attendance->check_out)->format('H:i') : '-',
            $this->getStatusLabel($attendance->status),
            $attendance->notes ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '667eea']
                ]
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Presensi';
    }

    private function getStatusLabel($status)
    {
        return match($status) {
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'sick' => 'Sakit',
            'permission' => 'Izin',
            'absent' => 'Alpha',
            default => ucfirst($status)
        };
    }
}
