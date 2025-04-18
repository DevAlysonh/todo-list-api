<?php

namespace App\Http\Controllers;

use App\Dto\Task\TaskInput;
use App\Http\Requests\Task\NewTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\TaskListResource;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) { }

    public function index()
    {
        $tasks = $this->taskService->findAllByUser(Auth::user());
        return response()->json(new TaskListResource($tasks));
    }

    public function store(NewTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->new(
            TaskInput::fromArray($request->validated())
        );

        return response()->json(new TaskResource($task), Response::HTTP_CREATED);
    }

    public function show(Task $task)
    {
        if (!auth()->user()->can('view', $task)) {
            throw new UnauthorizedException();
        }

        return response()->json(new TaskResource($task), Response::HTTP_OK);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        if (!auth()->user()->can('update', $task)) {
            throw new UnauthorizedException();
        }

        $updated = $this->taskService->update(
            $task,
            TaskInput::fromArray($request->validated())
        );

        return response()->json(new TaskResource($updated), Response::HTTP_OK);
    }

    public function destroy(Task $task): JsonResponse
    {
        if (!auth()->user()->can('delete', $task)) {
            throw new UnauthorizedException();
        }

        $this->taskService->delete($task);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function markDone(Task $task): JsonResponse
    {
        if (!auth()->user()->can('update', $task)) {
            throw new UnauthorizedException();
        }

        $updated = $this->taskService->setDone($task);
        return response()->json(new TaskResource($updated), Response::HTTP_OK);
    }
}
