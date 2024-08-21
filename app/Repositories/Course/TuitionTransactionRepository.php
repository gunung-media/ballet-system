<?php

namespace App\Repositories\Course;

use App\Models\TuitionTransaction;
use Illuminate\Database\Eloquent\Collection;

class TuitionTransactionRepository
{
    public function __construct(
        protected TuitionTransaction $model,
    ) {}

    /**
     * @return Collection<int,TuitionTransaction>
     */
    public function getAll(): Collection
    {
        $query = $this->model->with('student');
        return $query->get();
    }


    public function getById(mixed $identifier): TuitionTransaction | null
    {
        if ($identifier instanceof TuitionTransaction) return $identifier;
        return $this->model->with('student')->find($identifier);
    }

    /**
     * @param array<int,mixed> $data
     */
    public function insert(array $data): TuitionTransaction
    {
        if ($data['student_id'] === "Lainnya") $data['student_id'] = null;
        $model =  $this->model->create($data);
        return $model;
    }

    /**
     * @param array<int,mixed> $data
     */
    public function update(mixed $identifier, array $data): bool
    {
        if ($data['student_id'] === "Lainnya") $data['student_id'] = null;
        $model = $this->getById($identifier);
        $modelUpdated = $model->update($data);
        return $modelUpdated;
    }

    public function delete(mixed $identifier): bool
    {
        $model = $this->getById($identifier);
        if ($model === null) return false;
        return $model->delete();
    }
}
