<?php

namespace App\Repositories;

use App\Dto\Task\TaskInput;
use App\Models\Task;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository
{
    public function create(User $user, TaskInput $task): Task
    {
        return Task::create(array_merge($task->toArray(), ['user_id' => $user->id]));
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

    public function findAllByUser(User $user): LengthAwarePaginator
    {
        return Task::where('user_id', $user->id)
            ->paginate(6);
    }
}