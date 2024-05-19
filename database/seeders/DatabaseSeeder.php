<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Year;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test User',
            'email' => 'd@example.com',
            'description' => 'Licensed English Teacher',
            'password' => 'd',
            'type' => '2',
            'category' => 'Full Time',
            'rate' => 10000,
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 't@example.com',
            'password' => 't',
            'type' => '1'
        ]);

        Categories::create([
            'type' => 'Part Time'
        ]);

        Categories::create([
            'type' => 'Full Time'
        ]);

        Year::create([
            'user_id' => '1',
            'year' => '2'
        ]);
    }
}
