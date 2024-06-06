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
        return $this->student->with('classes')->find($identifier);
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
