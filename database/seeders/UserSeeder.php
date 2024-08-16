<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userCount = (int) $this->command->ask('How many users do you want to create?', 20);

        $user = User::factory()->defaultUser()->create();
        $user->assignRole('admin');

        User::factory()->count($userCount)->create();
    }
}
