<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => 'upwork2025',
            ]);

        User::factory()
            ->count(3)
            ->create();

        $this->call([
            LocationSeeder::class,
            SkillSeeder::class,
        ]);
    }
}
