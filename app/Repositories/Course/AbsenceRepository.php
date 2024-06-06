<?php

namespace App\Repositories\Course;

use App\Models\Course\Absence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AbsenceRepository
{
    public function __construct(
        protected Absence $model
    ) {
    }

    public function getAbsence(mixed $scheduleId, mixed $date): Model|Builder|null
    {
        $query = $this->model->query();

        return $query->where('class_schedule_id', $scheduleId)->where('date', $date)->first();
    }

    public function insert(array $data): Model|Absence
    {
        return $this->model->create($data);
    }
}
