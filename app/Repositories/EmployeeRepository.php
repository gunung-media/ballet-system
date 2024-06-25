<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class EmployeeRepository
{
    public function __construct(
        protected Employee $employee
    ) {
    }
    /**
     * @return Collection<int,Employee>
     */
    public function getAll(): Collection
    {
        return $this->employee
            ->all();
    }

    public function getById(int $id): Model|Employee|null
    {
        return $this->employee
            ->findOrFail($id);
    }

    public function insert(array $data): Model|Employee
    {
        $photo = $data['photo'];
        if (!is_null($photo) && !($photo instanceof UploadedFile)) {
            throw new InvalidArgumentException('Photo must be an uploaded file');
        }

        if (!is_null($photo)) {
            unset($data['photo']);
        }

        $employee = $this->employee->create($data);

        if (!is_null($photo)) {
            $fileName = uniqid('employee_') . '.' . $photo->getClientOriginalExtension();
            $path = Storage::putFileAs('public/employees', $photo, $fileName);

            $employee->photo = $path;
            $employee->save();
        }

        return $employee;
    }

    public function update(mixed $identifier, array $data): bool
    {
        $model = $this->getById($identifier);
        if (isset($data['photo']) && !is_string($data['photo'])) {
            $photo = $data['photo'];
            $fileName = uniqid('employee_') . '.' . $photo->getClientOriginalExtension();
            $path = Storage::putFileAs('public/employees', $photo, $fileName);

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
