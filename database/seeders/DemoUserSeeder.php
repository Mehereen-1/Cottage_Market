<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo users if they don't exist
        $demoUsers = [
            [
                'name' => 'Admin User',
                'email' => 'admin@demo.com',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'Demo Seller',
                'email' => 'seller@demo.com',
                'password' => Hash::make('password'),
                'role' => 'student'
            ],
            [
                'name' => 'Demo Buyer',
                'email' => 'buyer@demo.com',
                'password' => Hash::make('password'),
                'role' => 'guest'
            ]
        ];

        foreach ($demoUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Demo users created successfully!');
    }
}
