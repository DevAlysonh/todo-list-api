<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
        ]);

        User::factory(2)->create();

        foreach (User::all() as $user) {
            Task::factory(18)->state(['user_id' => $user->id])->create();
        }
    }
}
