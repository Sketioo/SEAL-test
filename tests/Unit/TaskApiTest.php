<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the database if needed
        Artisan::call('migrate');
    }

    /** @test */
    public function test_can_create_a_task()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/tasks', [
            'title' => 'New Task',
            'description' => 'Task Description',
            'status' => 'pending',
            'due_date' => now()->addDays(5)->toDateString(),
            'project_id' => $project->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['id', 'title', 'description', 'status', 'due_date', 'project_id'],
            ]);
    }

    /** @test */
    public function test_can_read_a_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['id', 'title', 'description', 'status', 'due_date', 'project_id'],
            ]);
    }

    /** @test */
    public function test_can_update_a_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Task Title',
            'description' => 'Updated Description',
            'status' => 'completed',
            'due_date' => now()->addDays(10)->toDateString(),
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Task updated successfully',
            ]);
    }

    /** @test */
    public function test_can_delete_a_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Task deleted successfully',
            ]);
    }
}
