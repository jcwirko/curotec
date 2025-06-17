<?php

use App\Models\Task;

/*
* WE SHOULD ADD TEST TO COVER ALL FORM REQUEST VALIDATIONS
* I JUST ADDED SOME EXAMPLES.
*/

test('it fails when required fields are missing on task creation', function () {
    $response = $this->postJson('api/tasks', []);

    $response->assertStatus(422);

    $response->assertJson([
        'message' => 'Validation failed',
        'errors' => [
            "title" => [
                "The title field is required."
            ]
        ],
    ]);
});

test('it fails with invalid priority on task creation', function () {
    $response = $this->postJson('api/tasks', [
        'title' => 'my task',
        'priority' => 'wrong'
    ]);

    $response->assertStatus(422);

    $response->assertJson([
        'message' => 'Validation failed',
        'errors' => [
            "priority" => [
                "The selected priority is invalid."
            ]
        ],
    ]);
});
