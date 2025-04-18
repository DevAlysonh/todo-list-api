<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'tasks' => $this->items(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage()
        ];
    }
}
