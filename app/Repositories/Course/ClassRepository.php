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
        $query = $this->classModel->with('schedules');
        return $query->get();
    }

    public function getForCalendar(int $threshold = 1)
    {
        $lowerBound = now()->subMonths($threshold);
        $upperBound = now()->addMonths($threshold);
        $currentDate = $lowerBound->copy();

        $data = [];
        while ($currentDate->lessThanOrEqualTo($upperBound)) {
            echo $currentDate->dayName . "\n";

            $currentDate->addDay();
        }

        $datas = $this->getAll();
        return $datas->mapWithKeys(
            fn ($data) =>
            $data->schedules->map(
                fn ($schedule) => [
                    'id' => $data->id,
                    'title' => $data->name,
                    'start' => now()->format('Y-m-d'),
                    'end' => now()->format('Y-m-d'),
                ]
            )
        );
    }

    public function getById(mixed $identifier): ClassModel | null
    {
        if ($identifier instanceof ClassModel) return $identifier;
        return $this->classModel->find($identifier);
    }

    /**
     * @param array<int,mixed> $data
     */
    public function insert(array $data): ClassModel
    {
        $scheduleData = $data['schedule'];
        if (!is_null($scheduleData)) unset($data['schedule']);
        $classModel =  $this->classModel->create($data);
        if (!is_null($scheduleData)) {
            $classModel->schedules()->createMany($scheduleData);
        }
        return $classModel;
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
