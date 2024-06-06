<?php

namespace App\Repositories\Course;

use App\Models\Course\Teacher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class TeacherRepository
{
    public function __construct(
        protected Teacher $teacher,

    ) {
    }

    /**
     * @return Collection<int,TeacherModel>
     */
    public function getAll(): Collection
    {
        return $this->teacher->all();
    }

    public function getById(mixed $identifier): Teacher | null
    {
        if ($identifier instanceof Teacher) return $identifier;
        return $this->teacher->find($identifier);
    }

    /**
     * @param array<int,mixed> $data
     */
    public function insert(array $data): Teacher
    {
        // Extract and validate photo
        $photo = $data['photo'];
        if (!is_null($photo) && !($photo instanceof UploadedFile)) {
            throw new InvalidArgumentException('Photo must be an uploaded file');
        }

        if (!is_null($photo)) {
            unset($data['photo']);
        }

        $teacher = $this->teacher->create($data);

        if (!is_null($photo)) {
            $fileName = uniqid('teacher_') . '.' . $photo->getClientOriginalExtension();
            $path = Storage::putFileAs('public/teachers', $photo, $fileName);

            $teacher->photo = $path;
            $teacher->save();
        }

        return $teacher;
    }

    /**
     * @param array<int,mixed> $data
     */
    public function update(mixed $identifier, array $data): bool
    {
        $model = $this->getById($identifier);

        if (isset($data['photo']) && !is_string($data['photo'])) {
            $photo = $data['photo'];
            $fileName = uniqid('teacher_') . '.' . $photo->getClientOriginalExtension();
            $path = Storage::putFileAs('public/teachers', $photo, $fileName);

            if ($model->photo) {
                Storage::disk('public')->delete($model->photo);
            }

            $data['photo'] = $path;
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
