<?php

namespace App\Http\Controllers;

use App\Dto\Task\TaskInput;
use App\Http\Requests\Task\NewTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $service
    ) { }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(NewTaskRequest $request)
    {
        $task = $this->service->new(
            TaskInput::fromArray($request->validated())
        );

        return response()->json(new TaskResource($task), Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
