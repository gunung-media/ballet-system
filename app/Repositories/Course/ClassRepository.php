<?php

namespace App\Repositories\Course;

use App\Models\Course\ClassModel;
use Illuminate\Database\Eloquent\Collection;

class ClassRepository
{
    public function __construct(
        protected ClassModel $classModel,

    ) {
    }

    /**
     * @return Collection<int,ClassModel>
     */
    public function getAll(): Collection
    {
        return $this->classModel->all();
    }

    public function getById(mixed $identifier): ClassModel | null
    {
        if ($identifier instanceof ClassModel) return  $identifier;
        return $this->classModel->find($identifier);
    }

    /**
     * @param array<int,mixed> $data
     */
    public function insert(array $data): ClassModel
    {
        return $this->classModel->create($data);
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
