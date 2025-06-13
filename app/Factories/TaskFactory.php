<?php

namespace App\Factories;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskFactory
{
    public function getInstance(array $data)
    {
        if (isset($data['categories_ids'])) {
            unset($data['categories_ids']);
        }

        $taskInstance = new Task($data);

        Log::info("Task instance created");

        return $taskInstance;
    }
}
