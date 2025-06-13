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

    public function saveWithCategories(Task $task, array $categoryIds = [])
    {
        $task->save();

        if (!empty($categoryIds)) {
            $task->categories()->sync($categoryIds);
        }

        return $task->load(self::RELATIONS);
    }
}
