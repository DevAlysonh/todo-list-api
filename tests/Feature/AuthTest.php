<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Alyson Nunes',
            'email' => 'alyson@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
                ->assertJsonStructure([
                    'token',
                    'user' => ['id', 'name', 'email'],
                ]);

        $this->assertDatabaseHas('users', ['email' => 'alyson@example.com']);
    }

    public function test_user_can_login_and_receive_token()
    {
        $user = User::factory()->create([
            'email' => 'alyson@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    'token',
                    'expires_in',
                ]);
    }

    public function test_user_can_access_protected_route_with_token()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
                        ->getJson('/api/whoami');

        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonFragment(['email' => $user->email]);
    }

    public function test_user_can_refresh_token()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
                        ->postJson('/api/refresh');

        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure([
                    'token',
                    'expires_in',
                ]);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
                        ->postJson('/api/logout');

        $response->assertStatus(Response::HTTP_OK)
                ->assertExactJson([
                    'message' => 'Successfully logged out',
                ]);
    }
}
