<?php

namespace App\Dto\Task;

class TaskInput
{
    protected string $title;
    protected ?string $description;

    public function __construct(string $title, ?string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

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