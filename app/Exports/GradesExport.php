<?php

namespace App\Exports;

use App\Models\Grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GradesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $classId;
    protected $semester;
    protected $academicYear;

    public function __construct($classId = null, $semester = null, $academicYear = null)
    {
        $this->classId = $classId;
        $this->semester = $semester;
        $this->academicYear = $academicYear;
    }

    public function collection()
    {
        $query = Grade::with(['student', 'subject']);

        if ($this->classId) {
            $query->whereHas('student', function($q) {
                $q->where('class_id', $this->classId);
            });
        }

        if ($this->semester) {
            $query->where('semester', $this->semester);
        }

        if ($this->academicYear) {
            $query->where('academic_year', $this->academicYear);
        }

        return $query->orderBy('academic_year', 'desc')
            ->orderBy('semester', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Siswa',
            'Mata Pelajaran',
            'Tahun Ajaran',
            'Semester',
            'Tugas',
            'UTS',
            'UAS',
            'Nilai Akhir',
            'Predikat'
        ];
    }

    public function map($grade): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $grade->student->nis ?? '-',
            $grade->student->name ?? '-',
            $grade->subject->name ?? '-',
            $grade->academic_year,
            $grade->semester,
            $grade->assignment_grade ?? 0,
            $grade->midterm_grade ?? 0,
            $grade->final_exam_grade ?? 0,
            $grade->final_grade ?? 0,
            $this->getGradeLetter($grade->final_grade)
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
        return 'Laporan Nilai';
    }

    private function getGradeLetter($finalGrade)
    {
        if ($finalGrade >= 90) return 'A';
        if ($finalGrade >= 80) return 'B';
        if ($finalGrade >= 70) return 'C';
        if ($finalGrade >= 60) return 'D';
        return 'E';
    }
}
