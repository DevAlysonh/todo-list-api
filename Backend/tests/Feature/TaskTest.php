<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;
    protected $token;
    protected User $user;

    public function setup(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = auth('api')->login($this->user);
    }

    public function test_ifATaskCanBeCreated(): void
    {
        $taskData = [
            'title' => 'Foo',
            'description' => 'bar',
        ];

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->postJson(route('tasks.new'), $taskData);
        $response->assertStatus(201);

        $created = $response->getData();
        $this->assertDatabaseHas('tasks', $taskData);
        $this->assertEquals($taskData['title'], $created->title);
        $this->assertEquals($taskData['description'], $created->description);
    }

    public function test_ifATaskCanBeUpdated(): void
    {
        $task = Task::factory()->create([
            'title' => 'Old Title',
            'description' => 'Old Description',
            'user_id' => $this->user->id
        ]);

        $updatedData = [
            'title' => 'New Title',
            'description' => 'New Description',
        ];

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->patchJson(route('tasks.update', $task->id), $updatedData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', $updatedData);
        $this->assertEquals($updatedData['title'], $response->getData()->title);
        $this->assertEquals($updatedData['description'], $response->getData()->description);
    }

    public function test_ifATaskCanBeMarkedAsCompleted(): void
    {
        $task = Task::factory()
            ->state(['user_id' => $this->user->id])
            ->create();

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->patchJson(route('tasks.mark.done', $task->id));
        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_done' => true,
        ]);

        $this->assertTrue($response->getData()->is_done);
    }

    public function test_ifATaskCanBeDeleted(): void
    {
        $task = Task::factory()->state(['user_id' => $this->user->id])->create();

        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->deleteJson(route('tasks.delete', $task->id));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
    public function test_userCannotUpdateTaskHeDoesNotOwn(): void
    {
        $anotherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $anotherUser->id]);
    
        $updateData = [
            'title' => 'Hacked Title',
            'description' => 'Hacked Description',
        ];
    
        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->patchJson(route('tasks.update', $task->id), $updateData);
    
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertEquals($response->getData()->error, 'Você não tem permissão para executar esta ação.');
    }

    public function test_userCannotViewTaskHeDoesNotOwn(): void
    {
        $anotherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $anotherUser->id]);
    
        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->getJson(route('tasks.show', $task->id));
    
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertEquals($response->getData()->error, 'Você não tem permissão para executar esta ação.');
    }
    
    public function test_userCannotDeleteTaskHeDoesNotOwn(): void
    {
        $anotherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $anotherUser->id]);
    
        $response = $this->withHeader('Authorization', "Bearer $this->token")
            ->deleteJson(route('tasks.delete', $task->id));
    
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertEquals($response->getData()->error, 'Você não tem permissão para executar esta ação.');
    }
}
