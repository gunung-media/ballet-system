<?php

namespace App\Repositories;

use App\Models\EmployeeAbsence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeAbsenceRepository
{
    public function __construct(
        protected EmployeeAbsence $employeeAbsence
    ) {}

    public function getAbsences()
    {
        return $this->employeeAbsence
            ->select('date', DB::raw('SUM(CASE WHEN state = "Hadir" THEN 1 ELSE 0 END) as total'))
            ->groupBy('date')
            ->get();
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

    public function getAbsence(mixed $employeeId, mixed $date): Model|Builder|null
    {
        $query = $this->employeeAbsence->query();

        return $query->where('employee_id', $employeeId)->where('date', $date)->first();
    }

    public function insert(array $data)
    {
        $attributes = [
            'employee_id' => $data['employee_id'],
            'date' => $data['date']
        ];
        return $this->employeeAbsence->updateOrCreate($attributes, $data);
    }
}
