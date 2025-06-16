<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;

class TaskRepository extends BaseRepository
{
    const RELATIONS = ['categories'];

    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    public function getAllPaginated(int $perPage, array $filters = [])
    {
        return $this->model->with(self::RELATIONS)
            ->category($filters['category_id'] ?? null)
            ->priority($filters['priority'] ?? null)
            ->isCompleted($filters['is_completed'] ?? null)
            ->paginate($perPage);
    }


    public function saveWithCategories(Task $task, array $categoryIds = [])
    {
        $task->save();

        if (!empty($categoryIds)) {
            $task->categories()->sync($categoryIds);
        }

        return $task->load(self::RELATIONS);
    }
}
