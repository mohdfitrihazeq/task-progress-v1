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

        \App\Models\Company::factory()->create([
            'id' => '1',
            'company_name' => 'default',
        ]);

        \App\Models\User::factory()->create([
            'user_name' => 'admin',
            'role_name' => 'SSA',
            'company_id' => '1',
        ]);
    }
}
