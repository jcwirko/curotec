<?php

use App\Factories\TaskFactory;
use App\Models\Task;

/*
* WE SHOULD ADD TEST TO COVER ALL UNIT TEST SUCK AS FACTORIES, RULES, PATTERNS, ETC.
* I JUST ADDED ONE CASE AS AN EXAMPLE
*/


test('it should get a task instance', function () {
    $taskFactory = new TaskFactory();

    $data = [
        "title" => "my new task",
        "description" => "to make this task you should use laravel, vue and inertia",
        "priority" => "high",
        "due_date" => "2024-10-13",
        "is_completed" => false,
    ];

    $taskInstance = $taskFactory->getInstance($data);

    $this->assertInstanceOf(Task::class, $taskInstance);
});
