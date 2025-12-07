<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $classId;
    protected $grade;
    protected $status;

    public function __construct($classId = null, $grade = null, $status = 'active')
    {
        $this->classId = $classId;
        $this->grade = $grade;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Student::with(['class']);

        if ($this->classId) {
            $query->where('class_id', $this->classId);
        }

        if ($this->grade) {
            $query->whereHas('class', function($q) {
                $q->where('grade', $this->grade);
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->orderBy('class_id')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Kelas',
            'Tingkat',
            'Alamat',
            'No. HP',
            'Email',
            'Status'
        ];
    }

    public function map($student): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $student->nis,
            $student->name,
            $student->gender === 'L' ? 'Laki-laki' : 'Perempuan',
            $student->place_of_birth ?? '-',
            $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') : '-',
            $student->class->name ?? '-',
            $student->class ? 'Kelas ' . $student->class->grade : '-',
            $student->address ?? '-',
            $student->phone ?? '-',
            $student->email ?? '-',
            ucfirst($student->status)
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
        return 'Data Siswa';
    }
}
