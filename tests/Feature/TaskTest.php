<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

    public function test_ifATaskCanBeCreated(): void
    {
        $taskData = [
            'title' => 'Foo',
            'description' => 'bar',
        ];

        $response = $this->postJson(route('tasks.new'), $taskData);
        $response->assertStatus(201);

        $created = $response->getData();
        $this->assertDatabaseHas('tasks', $taskData);
        $this->assertEquals($taskData['title'], $created->title);
        $this->assertEquals($taskData['description'], $created->description);
    }
}
