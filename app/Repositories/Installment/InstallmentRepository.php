<?php

namespace App\Repositories\Installment;

use App\Models\Installment\Installment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class InstallmentRepository
{
    public function __construct(
        protected Installment $model,
    ) {}

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): Model|Collection|Installment|array
    {
        return $this->model->with('payments')
            ->findOrFail($id);
    }

    public function insert(array $data): Model|Installment
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $installment = $this->find($id);
        $installment->update($data);
        return $installment;
    }

    public function delete(int $id)
    {
        $installment = $this->find($id);
        return $installment->delete();
    }
}
