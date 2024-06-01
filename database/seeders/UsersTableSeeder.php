<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'last_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('123456789'), // Remember to use a secure password in production
            'user_type' => 1, // Superadmin
        ]);

        User::create([
            'name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456789'), // Remember to use a secure password in production
            'user_type' => 2, // Admin
        ]);

        User::create([
            'name' => 'Regular User',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('123456789'), // Remember to use a secure password in production
            'user_type' => 3, // User
        ]);
    }
}

