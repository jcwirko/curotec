<?php

use App\Models\Task;
use Carbon\Carbon;

test('it should get all tasks', function () {
    Task::factory()->count(5)->create();

    $response = $this->get('api/tasks');

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'data' => [
            '*' => [
                "id",
                "title",
                "description",
                "priority",
                "due_date",
                "is_completed",
                "created_at",
                "updated_at"
            ]
        ]
    ]);

    $tasks = $response->decodeResponseJson()['data'];

    $this->assertEquals(5, count($tasks));
});

test('it should get a tasks', function () {
    $newTask = Task::factory()->create();

    $response = $this->get("api/tasks/{$newTask->id}");

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'data' => [
            "id",
            "title",
            "description",
            "priority",
            "due_date",
            "is_completed",
            "created_at",
            "updated_at"
        ]
    ]);

    $task = $response->decodeResponseJson()['data'];

    $this->assertEquals($newTask->id, $task['id']);
    $this->assertEquals($newTask->title, $task['title']);
    $this->assertEquals($newTask->description, $task['description']);
    $this->assertEquals($newTask->priority, $task['priority']);
    $this->assertEquals($newTask->due_date?->toJSON(), $task['due_date']);
    $this->assertEquals($newTask->is_completed, $task['is_completed']);
    $this->assertEquals($newTask->created_at->toJSON(), $task['created_at']);
    $this->assertEquals($newTask->updated_at->toJSON(), $task['updated_at']);
});

test('it should store a new task', function () {
    $payload = [
        "title" => "my new task",
        "description" => "to make this task you should use laravel, vue and inertia",
        "priority" => "high",
        "due_date" => "2024-10-13",
        "is_completed" => false,
    ];

    $response = $this->post("api/tasks", $payload);

    $response->assertStatus(201);

    $response->assertJsonStructure([
        'data' => [
            "id",
            "title",
            "description",
            "priority",
            "due_date",
            "is_completed",
            "created_at",
            "updated_at"
        ]
    ]);

    $task = $response->decodeResponseJson()['data'];

    $this->assertEquals($payload['title'], $task['title']);
    $this->assertEquals($payload['description'], $task['description']);
    $this->assertEquals($payload['priority'], $task['priority']);
    $this->assertTrue(
        Carbon::parse($payload['due_date'])->isSameDay(Carbon::parse($task['due_date']))
    );
    $this->assertEquals($payload['is_completed'], $task['is_completed']);
});
