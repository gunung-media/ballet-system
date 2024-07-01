<?php

namespace App\Repositories;

use App\Models\EmployeeAbsence;

class EmployeeAbsenceRepository
{
    public function __construct(
        protected EmployeeAbsence $employeeAbsence
    ) {
    }

    public function getForCalendars(int $threshold = 5): array
    {
        $lowerBound = now()->subMonths($threshold);
        $upperBound = now()->addMonths($threshold);
        $currentDate = $lowerBound->copy();

        $data = [];

        while ($currentDate->lessThanOrEqualTo($upperBound)) {
            $data[] = [
                'title' => $currentDate->dayName,
                'start' => $currentDate->format('Y-m-d 00:00:00'),
                'end' => $currentDate->format('Y-m-d 23:59:59'),
            ];
            $currentDate->addDay();
        }
        return $data;
    }
}
