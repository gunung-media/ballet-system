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

    public function getById(int $id): ClassModel | null
    {
        return $this->classModel->find($id);
    }
}
