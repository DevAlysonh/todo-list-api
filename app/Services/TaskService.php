<?php

namespace App\Services;

use App\Dto\Task\TaskInput;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(
        protected TaskRepository $taskRepo
    ) { }

    public function new(TaskInput $task): Task
    {
        return $this->taskRepo->create($task);
    }
}