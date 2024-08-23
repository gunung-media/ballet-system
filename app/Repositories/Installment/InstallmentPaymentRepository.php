<?php

namespace App\Repositories\Installment;

use App\Models\Installment\InstallmentPayment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class InstallmentPaymentRepository
{
    public function __construct(
        protected InstallmentPayment $model,
    ) {}

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): Model|Collection|InstallmentPayment|array
    {
        return $this->model->findOrFail($id);
    }

    public function insert(array $data): Model|InstallmentPayment
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Model|Collection|InstallmentPayment|array
    {
        $payment = $this->find($id);
        $payment->update($data);
        return $payment;
    }

    public function delete(int $id): ?bool
    {
        $payment = $this->find($id);
        return $payment->delete();
    }

    public function findByInstallment(int $installmentId): Collection|array
    {
        return $this->model->with('student')->where('installment_id', $installmentId)->get();
    }
}
