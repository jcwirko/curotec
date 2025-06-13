<?php

namespace App\Factories;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskFactory
{
    public function getInstance(array $data)
    {
        $taskInstance = new Task($data);

        Log::info("Task instance created");

        return $taskInstance;
    }
}
