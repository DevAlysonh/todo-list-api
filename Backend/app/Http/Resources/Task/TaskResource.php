<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'is_done' => (bool) $this->is_done,
            'description' => $this->description ?? '',
            'created_at' => $this->created_at?->toDateTimeString()
        ];
    }
}
