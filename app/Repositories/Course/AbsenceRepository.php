<?php

namespace App\Repositories\Course;

use App\Enums\AbsenceStateEnum;
use App\Models\Course\Absence;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AbsenceRepository
{
    public function __construct(
        protected Absence $model,
        protected StudentRepository $studentRepository,
    ) {}

    public function getAbsences(): Collection
    {
        $query = $this->model
            ->with(['schedule.class', 'students', 'teacher'])
            ->get()
            ->map(function ($absence) {
                $students = $this->studentRepository->getStudentsByClass($absence->schedule->class_id);
                $absence['all_students'] = $students;
                $absence['attended_student'] = $absence->students->filter(fn($student) => $student->state == AbsenceStateEnum::hadir)->count();
                $absence['not_attended_student'] = $students->count() - $absence['attended_student'];

                return $absence;
            });

        return $query;
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
