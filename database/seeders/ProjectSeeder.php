<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectCount = (int) $this->command->ask('How many projects do you want to create?', 10);

        Project::factory()->count($projectCount)->create();
    }
}
