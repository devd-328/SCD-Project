<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
<<<<<<< HEAD

        // Create admin user
        $this->call([
            \Database\Seeders\AdminUserSeeder::class,
        ]);
=======
>>>>>>> b1ee59a59cecc1750eaa6a3df0b0c673f4bbfa4e
    }
}
