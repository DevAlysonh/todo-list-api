<?php

namespace App\Http\Controllers;

use App\Dto\Task\TaskDone;
use App\Dto\Task\TaskInput;
use App\Http\Requests\Task\MarkTaskAsDoneRequest;
use App\Http\Requests\Task\NewTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\TaskListResource;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) { }

    public function index()
    {
        return response()->json(new TaskListResource(Task::paginate(6)));
    }

    public function store(NewTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->new(
            TaskInput::fromArray($request->validated())
        );

        return response()->json(new TaskResource($task), Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        //
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $updated = $this->taskService->update(
            $task,
            TaskInput::fromArray($request->validated())
        );

        return response()->json(new TaskResource($updated), Response::HTTP_OK);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->taskService->delete($task);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function markDone(Task $task): JsonResponse
    {
        $updated = $this->taskService->setDone($task);

        return response()->json(new TaskResource($updated), Response::HTTP_OK);
    }
}
