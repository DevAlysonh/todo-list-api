<?php

namespace App\Dto\Task;

class TaskInput
{
    public function __construct(
        protected string $title,
        protected ?string $description
    ) { }

    public static function fromArray(array $data): self
    {
        return new self($data['title'], $data['description'] ?? null);
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description ?: null
        ];
    }
}