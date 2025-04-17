<?php

namespace App\Repositories;

use App\Dto\Task\TaskInput;
use App\Models\Task;

class TaskRepository
{
    public function create(TaskInput $task): Task
    {
        return Task::create($task->toArray());
    }
}