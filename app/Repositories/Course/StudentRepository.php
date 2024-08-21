<?php

namespace App\Repositories\Course;

use App\Enums\AbsenceStateEnum;
use App\Models\Course\ClassModel;
use App\Models\Course\Student;
use App\Models\Course\StudentModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class StudentRepository
{
    public function __construct(
        protected Student $student,
        protected ClassModel $classModel,
    ) {}

    /**
     * @return Collection<int,StudentModel>
     */
    public function getAll(): Collection
    {
        return $this->student->all();
    }

    public function getById(mixed $identifier): Student | null
    {
        if ($identifier instanceof Student) return $identifier;
        return $this->student->with('classes')->find($identifier);
    }

    public function getStudentsByScheduleId(mixed $scheduleId): Collection
    {
        $class = $this->classModel->whereHas('schedules', function ($query) use ($scheduleId) {
            $query->where('id', $scheduleId);
        })->first();

        if ($class) {
            return $class->students;
        }

        return collect();
    }

    public function getStudentsByClass(mixed $classId): Collection
    {
        return $this->student
            ->whereHas('classes', function ($query) use ($classId) {
                $query->where('classes.id', $classId);
            })
            ->get();
    }

    public function getStudentAbsence(mixed $studentId, int $classId, int $year): array
    {
        $student = $this->getById($studentId);


        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::parse("$year-$month-01");
            $startDateOfMonth = $startDate->copy()->startOfMonth();
            $endDateOfMonth = $startDate->copy()->endOfMonth();
            $monthTotalDays = $startDateOfMonth->daysInMonth;
            $absences  = $student->studentAbsences()
                ->whereHas('absence', fn($query) => $query->whereBetween('date', [$startDateOfMonth, $endDateOfMonth]))
                ->whereHas('absence.schedule', fn($query) => $query->where('class_id', $classId))
                ->get();

            $sum = 0;
            foreach ($absences as $absence) {
                if ($absence->state === AbsenceStateEnum::hadir) {
                    $sum += 1;
                }
            }

            // Percentage
            // $data[] = number_format($sum / $monthTotalDays * 100) . "%";
            $data[] = number_format($sum);
        }

        return $data;
    }

    /**
     * @param array<int,mixed> $data
     */
    public function insert(array $data): Student
    {
        $photo = $data['photo'];
        if (!is_null($photo) && !($photo instanceof UploadedFile)) {
            throw new InvalidArgumentException('Photo must be an uploaded file');
        }

        if (!is_null($photo)) {
            unset($data['photo']);
        }

        $student = $this->student->create($data);

        if (!is_null($photo)) {
            $fileName = uniqid('student_') . '.' . $photo->getClientOriginalExtension();
            $path = Storage::putFileAs('public/students', $photo, $fileName);

            // Update student model with photo path
            $student->photo = $path;
            $student->save();
        }

        if (isset($data['classes']) && is_array($data['classes'])) {
            $student->classes()->attach($data['classes']);
        }

        return $student;
    }

    /**
     * @param array<int,mixed> $data
     */
    public function update(mixed $identifier, array $data): bool
    {
        $model = $this->getById($identifier);
        if (isset($data['photo']) && !is_string($data['photo'])) {
            $photo = $data['photo'];
            $fileName = uniqid('student_') . '.' . $photo->getClientOriginalExtension();
            $path = Storage::putFileAs('public/students', $photo, $fileName);

            if ($model->photo) {
                Storage::disk('public')->delete($model->photo);
            }

            $data['photo'] = $path;
        }

        if (isset($data['classes']) && is_array($data['classes'])) {
            $model->classes()->sync($data['classes']);
        }

        return $model->update($data);
    }

    public function delete(mixed $identifier): bool
    {
        $model = $this->getById($identifier);
        if ($model === null) return false;
        return $model->delete();
    }
}
