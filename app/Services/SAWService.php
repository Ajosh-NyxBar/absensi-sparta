<?php

namespace App\Services;

use App\Models\Criteria;
use Illuminate\Support\Collection;

class SAWService
{
    /**
     * Calculate SAW scores for students
     * 
     * @param Collection $students Collection of students with their scores
     * @param string $type 'student' or 'teacher'
     * @return Collection
     */
    public function calculate(Collection $data, string $type = 'student'): Collection
    {
        // Get criteria based on type
        $criteria = Criteria::where('for', $type)->get();

        if ($criteria->isEmpty() || $data->isEmpty()) {
            return $data;
        }

        // Step 1: Build decision matrix
        $matrix = $this->buildDecisionMatrix($data, $criteria, $type);

        // Step 2: Normalize the matrix
        $normalizedMatrix = $this->normalizeMatrix($matrix, $criteria);

        // Step 3: Calculate SAW scores
        $sawScores = $this->calculateSAWScores($normalizedMatrix, $criteria);

        // Step 4: Rank the alternatives
        $rankedData = $this->rankAlternatives($data, $sawScores);

        return $rankedData;
    }

    /**
     * Build decision matrix from data
     */
    protected function buildDecisionMatrix(Collection $data, Collection $criteria, string $type): array
    {
        $matrix = [];

        foreach ($data as $index => $item) {
            $matrix[$index] = [];
            
            if ($type === 'student') {
                // For students: academic_score, attendance_score, behavior_score, skill_score
                $matrix[$index] = [
                    'C1' => $item->academic_score ?? 0,      // Nilai Akademik
                    'C2' => $item->attendance_score ?? 0,    // Kehadiran
                    'C3' => $item->behavior_score ?? 0,      // Sikap
                    'C4' => $item->skill_score ?? 0,         // Keterampilan
                ];
            } else {
                // For teachers: attendance_score, teaching_quality, student_achievement, discipline_score
                $matrix[$index] = [
                    'K1' => $item->attendance_score ?? 0,      // Kehadiran
                    'K2' => $item->teaching_quality ?? 0,      // Kualitas Mengajar
                    'K3' => $item->student_achievement ?? 0,   // Prestasi Siswa
                    'K4' => $item->discipline_score ?? 0,      // Kedisiplinan
                ];
            }
        }

        return $matrix;
    }

    /**
     * Normalize matrix using SAW method
     */
    protected function normalizeMatrix(array $matrix, Collection $criteria): array
    {
        $normalized = [];

        foreach ($criteria as $criterion) {
            $criterionCode = $criterion->code;
            $values = array_column($matrix, $criterionCode);

            if (empty($values)) {
                foreach ($matrix as $index => $row) {
                    $normalized[$index][$criterionCode] = 0;
                }
                continue;
            }

            if ($criterion->type === 'benefit') {
                // For benefit criteria: r_ij = x_ij / max(x_ij)
                $maxValue = max($values);
                if ($maxValue > 0) {
                    foreach ($matrix as $index => $row) {
                        $normalized[$index][$criterionCode] = $row[$criterionCode] / $maxValue;
                    }
                } else {
                    foreach ($matrix as $index => $row) {
                        $normalized[$index][$criterionCode] = 0;
                    }
                }
            } else {
                // For cost criteria: r_ij = min(x_ij) / x_ij
                $minValue = min($values);
                if ($minValue > 0) {
                    foreach ($matrix as $index => $row) {
                        if ($row[$criterionCode] > 0) {
                            $normalized[$index][$criterionCode] = $minValue / $row[$criterionCode];
                        } else {
                            $normalized[$index][$criterionCode] = 0;
                        }
                    }
                } else {
                    foreach ($matrix as $index => $row) {
                        $normalized[$index][$criterionCode] = 1;
                    }
                }
            }
        }

        return $normalized;
    }

    /**
     * Calculate SAW scores
     */
    protected function calculateSAWScores(array $normalizedMatrix, Collection $criteria): array
    {
        $sawScores = [];

        foreach ($normalizedMatrix as $index => $row) {
            $score = 0;
            foreach ($criteria as $criterion) {
                $score += $row[$criterion->code] * $criterion->weight;
            }
            $sawScores[$index] = round($score, 4);
        }

        return $sawScores;
    }

    /**
     * Rank alternatives based on SAW scores
     */
    protected function rankAlternatives(Collection $data, array $sawScores): Collection
    {
        // Add SAW scores to data
        foreach ($data as $index => $item) {
            $item->saw_score = $sawScores[$index];
        }

        // Sort by SAW score (descending)
        $sortedData = $data->sortByDesc('saw_score')->values();

        // Assign ranks
        foreach ($sortedData as $index => $item) {
            $item->rank = $index + 1;
        }

        return $sortedData;
    }

    /**
     * Get detailed SAW calculation steps for transparency
     */
    public function getCalculationDetails(Collection $data, string $type = 'student'): array
    {
        $criteria = Criteria::where('for', $type)->get();
        
        // Build matrix based on assessment data (already calculated)
        $matrix = [];
        $normalizedMatrix = [];
        
        foreach ($data as $index => $item) {
            if ($type === 'student') {
                $matrix[$index] = [
                    'C1' => $item->academic_score ?? 0,
                    'C2' => $item->attendance_score ?? 0,
                    'C3' => $item->behavior_score ?? 0,
                    'C4' => $item->skill_score ?? 0,
                ];
            } else {
                $matrix[$index] = [
                    'K1' => $item->attendance_score ?? 0,
                    'K2' => $item->teaching_quality ?? 0,
                    'K3' => $item->student_achievement ?? 0,
                    'K4' => $item->discipline_score ?? 0,
                ];
            }
        }
        
        // Normalize the matrix
        $normalizedMatrix = $this->normalizeMatrix($matrix, $criteria);
        $sawScores = $this->calculateSAWScores($normalizedMatrix, $criteria);

        return [
            'criteria' => $criteria,
            'matrix' => $matrix,
            'normalized' => $normalizedMatrix,
            'saw_scores' => $sawScores,
            'weights' => $criteria->pluck('weight', 'code')->toArray(),
        ];
    }
}
