<?php

namespace App\Repositories\Course;

use App\Enums\DayEnum;
use App\Models\Course\ClassSchedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ClassScheduleRepository
{
    public function __construct(
        protected ClassSchedule $classSchedule,
    ) {
    }
    /**
     * @return Collection<int,ClassSchedule>
     */
    public function getAll(): Collection
    {
        return $this->classSchedule->all();
    }

    public function getById(int $id): ClassSchedule |null
    {
        return $this->classSchedule->with('class')->find($id);
    }

    public function getSchedulesByClass(int $classId): Collection
    {
        return $this->classSchedule->where('class_id', $classId)->get();
    }

    public function getScheduleByClassAndDay(int $classId, mixed $day): Model|ClassSchedule|null
    {
        return $this->classSchedule->where('class_id', $classId)->where('day', $day)->first();
    }
}
