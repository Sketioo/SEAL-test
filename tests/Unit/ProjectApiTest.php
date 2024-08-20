<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProjectApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the database if needed
        Artisan::call('migrate');
    }

    /** @test */
    public function test_can_create_a_project()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/projects', [
            'name' => 'New Project',
            'description' => 'Project Description',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['id', 'name', 'description'],
            ]);
    }

    /** @test */
    public function test_can_read_a_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson("/projects/{$project->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['id', 'name', 'description'],
            ]);
    }

    /** @test */
    public function test_can_update_a_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->putJson("/projects/{$project->id}", [
            'name' => 'Updated Project Name',
            'description' => 'Updated Description',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Project updated successfully',
            ]);
    }

    /** @test */
    public function test_can_delete_a_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/projects/{$project->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Project deleted successfully',
            ]);
    }
}
