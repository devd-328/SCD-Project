<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@example.com';

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $user->name ?: 'Admin';
        $user->password = Hash::make('password');
        $user->is_admin = true;
        $user->save();

        $this->command->info("Admin user created/updated: {$email} (password: password)");
    }
}
