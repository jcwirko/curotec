<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Factories\TaskFactory;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    private TaskRepository $taskRepository;
    private TaskFactory $taskFactory;

    public function __construct(TaskRepository $taskRepository, TaskFactory $taskFactory)
    {
        $this->taskRepository = $taskRepository;
        $this->taskFactory = $taskFactory;
    }

    /**
     * index
     *
     * @return void
     */
    public function index(): JsonResponse
    {
        //$rowsPerPage = request()->has('per_page') ? request()->get('per_page') : config('app.pagination.per_page');
        $tasks = $this->taskRepository->all();

        return TaskResource::collection($tasks)->response();
    }

    /**
     * store
     *
     * @param  TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request): JsonResponse
    {
        $taskInstance = $this->taskFactory->getInstance($request->all());
        $task = $this->taskRepository->save($taskInstance);

        return (new TaskResource($task))->response()->setStatusCode(201);
    }

    /**
     * show
     *
     * @param  int $taskId
     * @return JsonResponse
     */
    public function show(int $taskId): JsonResponse
    {
        $task = $this->taskRepository->get($taskId);

        return (new TaskResource($task))->response();
    }

    /**
     * update
     *
     * @param  TaskRequest $request
     * @param  int $taskId
     * @return JsonResponse
     */
    public function update(TaskRequest $request, int $taskId): JsonResponse
    {
        $task = $this->taskRepository->get($taskId);
        $task->fill($request->all());
        $updatedTask = $this->taskRepository->save($task);

        return (new TaskResource($updatedTask))->response();
    }
}
