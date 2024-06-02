<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'last_name' => 'Admin', // Add this line
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'user_type' => 1, // Superadmin
            ],
            [
                'name' => 'Admin',
                'last_name' => 'Admin', // Add this line
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'user_type' => 2, // Admin
            ],
            [
                'name' => 'User',
                'last_name' => 'User', // Add this line
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'user_type' => 3, // User
            ],
        ]);
    }
}
