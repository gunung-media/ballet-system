<?php

namespace App\Repositories\Course;

use App\Models\Course\ClassSchedule;
use Illuminate\Database\Eloquent\Collection;

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
        return $this->classSchedule->find($id);
    }

    public function getSchedulesByClass(int $classId): Collection
    {
        return $this->classSchedule->where('class_id', $classId)->get();
    }
}
