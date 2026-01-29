<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Intern
        $intern = User::create([
            'name' => 'Intern User',
            'email' => 'intern@example.com',
            'password' => Hash::make('password'),
            'role' => 'intern',
            'required_hours' => 500,
        ]);

        // Create some tasks
        $task1 = Task::create([
            'title' => 'Documentation Review',
            'description' => 'Review the onboarding documentation.',
            'hours' => 10,
            'created_by' => $admin->id,
        ]);

        $task2 = Task::create([
            'title' => 'Basic PHP Tutorial',
            'description' => 'Complete the basic PHP tutorial.',
            'hours' => 20,
            'created_by' => $admin->id,
        ]);

        // Assign tasks to intern
        $intern->tasks()->attach([
            $task1->id => ['status' => 'pending'],
            $task2->id => ['status' => 'pending'],
        ]);
    }
}
