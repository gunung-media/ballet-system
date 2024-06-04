<?php

namespace App\Repositories\Course;

use App\Models\Course\Student;
use App\Models\Course\StudentModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class StudentRepository
{
    public function __construct(
        protected Student $student,

    ) {
    }

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
        return $this->student->find($identifier);
    }

    /**
     * @param array<int,mixed> $data
     */
    public function insert(array $data): Student
    {
        // Extract and validate photo
        $photo = $data['photo'];
        if (!is_null($photo) && !($photo instanceof UploadedFile)) {
            throw new InvalidArgumentException('Photo must be an uploaded file');
        }

        if (!is_null($photo)) {
            unset($data['photo']);
        }

        $student = $this->student->create($data);

        // Store photo if provided
        if (!is_null($photo)) {
            $fileName = uniqid('student_') . '.' . $photo->getClientOriginalExtension();
            $path = Storage::putFileAs('public/students', $photo, $fileName);

            // Update student model with photo path
            $student->photo = $path;
            $student->save();
        }

        return $student;
    }

    /**
     * @param array<int,mixed> $data
     */
    public function update(mixed $identifier, array $data): bool
    {
        $model = $this->getById($identifier);
        return $model->update($data);
    }

    public function delete(mixed $identifier): bool
    {
        $model = $this->getById($identifier);
        if ($model === null) return false;
        return $model->delete();
    }
}
