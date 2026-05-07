<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account
        User::factory()->create([
            'name' => 'John Dave',
            'email' => 'johndave@admin.com',
            'role' => 'admin',
        ]);

        // Staff account
        User::factory()->create([
            'name' => 'Bruce Bilar',
            'email' => 'bruce@willis',
            'role' => 'staff',
        ]);

        // Regular user account
        User::factory()->create([
            'name' => 'Denzel Aliwate',
            'email' => 'denzel@denzel',
            'role' => 'user',
        ]);

        // Seed 20 sample customers for pagination testing
        Customer::factory(20)->create();
    }
}
