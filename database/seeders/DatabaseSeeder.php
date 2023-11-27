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
            'company_name' => 'default',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\Role::factory()->create([
            'role_name' => 'Master Super Admin - MSA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\User::factory()->create([
            'user_name' => 'admin',
            'role_name' => 'Master Super Admin - MSA',
            'company_id' => '1',
        ]);
    }
}
