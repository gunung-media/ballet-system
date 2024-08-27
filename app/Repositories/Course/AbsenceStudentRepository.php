<?php

namespace App\Repositories\Course;

use App\Models\Course\AbsenceStudent;

class AbsenceStudentRepository
{
    public function __construct(
        protected AbsenceStudent $model
    ) {}

    public function createOrUpdate(array $data): AbsenceStudent
    {
        $attributes = [
            'absence_id' => $data['absence_id'],
            'student_id' => $data['student_id']
        ];

        $existingRecord = $this->model->where($attributes)->first();

        if ($existingRecord) {
            throw new \Exception('Student has already been marked absent.');
        }

        return $this->model->updateOrCreate($attributes, $data);
    }
}
