<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Project::count() === 0) {
            $this->call(Project::class);
        }

        $count = $this->command->ask('How many tasks do you want to create?', 50);

        Task::factory()->count($count)->create();
    }
}
