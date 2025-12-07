<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeachersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function collection()
    {
        return Teacher::with(['user', 'teacherSubjects.subject', 'teacherSubjects.class'])
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIP',
            'Nama',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'No. HP',
            'Email',
            'Pendidikan',
            'Jumlah Mata Pelajaran',
            'Status Akun'
        ];
    }

    public function map($teacher): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $teacher->nip ?? '-',
            $teacher->name,
            $teacher->gender === 'L' ? 'Laki-laki' : 'Perempuan',
            $teacher->place_of_birth ?? '-',
            $teacher->date_of_birth ? \Carbon\Carbon::parse($teacher->date_of_birth)->format('d/m/Y') : '-',
            $teacher->address ?? '-',
            $teacher->phone ?? '-',
            $teacher->email ?? '-',
            $teacher->education ?? '-',
            $teacher->teacherSubjects->count(),
            $teacher->user ? 'Aktif' : 'Tidak Aktif'
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
        return 'Data Guru';
    }
}
