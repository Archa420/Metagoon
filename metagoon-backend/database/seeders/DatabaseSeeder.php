<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 👑 Built-in Admin Account
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'firstname' => 'Admin',
                'lastname' => 'User',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'gender' => null,
                'age' => null,
                'company_name' => null,
                'company_number' => null,
                'company_address' => null,
            ]
        );
    }
}
