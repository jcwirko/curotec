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
        'success' => false,
        'message' => [
            'error' => 'Validation failed',
            'details' => [
                'title' => ['The title field is required.'],
            ],
        ],
        'data' => [],
    ]);
});

test('it fails with invalid priority on task creation', function () {
    $response = $this->postJson('api/tasks', [
        'title' => 'my task',
        'priority' => 'wrong'
    ]);

    $response->assertStatus(422);

    $response->assertJson([
        'success' => false,
        'message' => [
            'error' => 'Validation failed',
            'details' => [
                'priority' => ['The selected priority is invalid.'],
            ],
        ],
        'data' => [],
    ]);
});
