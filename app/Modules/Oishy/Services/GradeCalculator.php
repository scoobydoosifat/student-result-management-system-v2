<?php

namespace App\Modules\Oishy\Services;

class GradeCalculator
{
    public function calculate(int $mid, int $final, int $assignment, int $attendance): array
    {
        $total = $mid + $final + $assignment + $attendance;

        if ($total >= 80) return ['A+', 4.00];
        if ($total >= 75) return ['A', 3.75];
        if ($total >= 70) return ['A-', 3.50];
        if ($total >= 65) return ['B+', 3.25];
        if ($total >= 60) return ['B', 3.00];
        if ($total >= 55) return ['B-', 2.75];
        if ($total >= 50) return ['C+', 2.50];
        if ($total >= 45) return ['C', 2.25];
        if ($total >= 40) return ['D', 2.00];

        return ['F', 0.00];
    }
}
