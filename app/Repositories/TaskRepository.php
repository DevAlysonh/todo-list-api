<?php

namespace App\Repositories;

use App\Dto\Task\TaskDone;
use App\Dto\Task\TaskInput;
use App\Models\Task;

class TaskRepository
{
    public function create(TaskInput $task): Task
    {
        return Task::create($task->toArray());
    }

    public function update(Task $task, TaskInput $new): bool
    {
        return $task->update($new->toArray());
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    public function setDone(Task $task): bool
    {
        return $task->update(['is_done' => true]);
    }
}