<?php

namespace App\Services;

use App\Dto\Task\TaskInput;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function __construct(
        protected TaskRepository $taskRepo
    ) { }

    public function new(TaskInput $task): Task
    {
        return $this->taskRepo->create(Auth::user(), $task);
    }

    public function update(Task $task, TaskInput $new): Task
    {
        $this->taskRepo->update($task, $new);
        return $task->refresh();
    }

    public function delete(Task $task): bool
    {
        return $this->taskRepo->delete($task);
    }

    public function setDone(Task $task): Task
    {
        $this->taskRepo->setDone($task);
        return $task->refresh();
    }

    public function findAllByUser(User $user): LengthAwarePaginator
    {
        return $this->taskRepo->findAllByUser($user);
    }
}