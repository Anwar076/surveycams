<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'department' => 'Management',
            'is_active' => true,
        ]);

        \App\Models\User::create([
            'name' => 'John Employee',
            'email' => 'employee@example.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'department' => 'Operations',
            'is_active' => true,
        ]);

        \App\Models\User::create([
            'name' => 'Jane Worker',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'role' => 'employee',
            'department' => 'Cleaning',
            'is_active' => true,
        ]);
    }
}
