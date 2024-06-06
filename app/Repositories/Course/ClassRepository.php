<?php

namespace App\Repositories\Course;

use App\Models\Course\ClassModel;
use Illuminate\Database\Eloquent\Collection;

class ClassRepository
{
    public function __construct(
        protected ClassModel $classModel,
        protected ClassScheduleRepository $classScheduleRepository,
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

    public function getForCalendar(int $threshold = 5): Collection| array
    {
        $lowerBound = now()->subMonths($threshold);
        $upperBound = now()->addMonths($threshold);
        $currentDate = $lowerBound->copy();

        $data = [];
        while ($currentDate->lessThanOrEqualTo($upperBound)) {
            $day = $currentDate->dayName;
            $classHasDay = $this->getByDay($day);

            if ($classHasDay->isNotEmpty()) {
                $data[] = $classHasDay->mapWithKeys(
                    fn ($data) => [
                        'id' => $this->classScheduleRepository->getScheduleByClassAndDay($data->id, $day)->id,
                        'title' => $data->name,
                        'start' => $currentDate->format('Y-m-d'),
                        'end' => $currentDate->format('Y-m-d'),
                    ]
                )->toArray();
            }

            $currentDate->addDay();
        }

        return $data;
    }

    public function getById(mixed $identifier): ClassModel | null
    {
        if ($identifier instanceof ClassModel) return $identifier;
        return $this->classModel->with('schedules')->find($identifier);
    }

    public function getByDay(string $day): Collection|array
    {
        return $this
            ->classModel
            ->active()
            ->whereHas('schedules', function ($query) use ($day) {
                $query->where('day', $day);
            })
            ->get();
    }

    public function getBySchedule($scheduleId)
    {
        $schedule = $this->classScheduleRepository->getById($scheduleId);

        if ($schedule) {
            return $schedule->class;
        }

        return null;
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

        $scheduleData = $data['schedule'] ?? null;
        if (!is_null($scheduleData)) {
            unset($data['schedule']);
        }

        $modelUpdated = $model->update($data);

        if (!is_null($scheduleData)) {
            $uniqueSchedules = collect($scheduleData)->unique('day')->toArray();
            $modelUpdated = $model->update($data);
            $model->schedules()->delete();
            $model->schedules()->createMany($uniqueSchedules);
        }

        return $modelUpdated;
    }

    public function delete(mixed $identifier): bool
    {
        $model = $this->getById($identifier);
        if ($model === null) return false;
        return $model->delete();
    }
}
