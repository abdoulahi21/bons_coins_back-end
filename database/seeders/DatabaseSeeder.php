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
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'full_name' => 'Abdou lahi DIALLO',
            'email' => 'admin@gmail.com',
            'phone' => '777777777',
            'address' => 'Dakar',
            'password' => bcrypt('passer123'),
            'role' => 'admin',

        ]);
    }
}
