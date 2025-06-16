<?php

use App\Models\Category;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


test('it should get all tasks', function () {
    $tasks = Task::factory()->count(5)->create();

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
    $tasks = $response->decodeResponseJson();

    $this->assertEquals(5, count($tasks['data']));
});

test('it should get tasks filtered by priority', function () {
    Task::factory()->count(2)->create([
        'priority' => 'high'
    ]);

    Task::factory()->count(4)->create([
        'priority' => 'medium'
    ]);

    $response = $this->get('api/tasks?priority=medium');

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

    $tasks = $response->decodeResponseJson();

    $this->assertEquals(4, count($tasks['data']));
});

test('it should get paginated tasks', function () {
    $tasks = Task::factory()->count(25)->create();

    $response = $this->get('api/tasks?per_page=10');

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
        ],
        'meta' => [
            'current_page',
            'from',
            'last_page',
            'links',
            'per_page',
            'to',
            'total'
        ]
    ]);

    $tasks = $response->decodeResponseJson();

    $this->assertEquals(10, count($tasks['data']));
    $this->assertEquals(10, $tasks['meta']['per_page']);
    $this->assertEquals(25, $tasks['meta']['total']);
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

test('it should store a new task without categories', function () {
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

test('it should store a new task with categories', function () {
    $categories = Category::factory()->count(5)->create();
    $twoCategoryIds = $categories->random(2)->pluck('id')->toArray();

    $payload = [
        "title" => "my new task",
        "description" => "to make this task you should use laravel, vue and inertia",
        "priority" => "high",
        "due_date" => "2024-10-13",
        "is_completed" => false,
        "category_ids" => $twoCategoryIds
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
    $this->assertEquals(2, count($task['categories']));
});
