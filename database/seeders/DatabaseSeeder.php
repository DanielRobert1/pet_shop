<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->admin()->create([
            'first_name' => 'Daniel',
            'last_name' => 'Aigbe',
            'email' => 'daniel4life1@gmail.com',
        ]);
    }
}
