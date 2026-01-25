<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'User',
                'email'    => 'user@example.com',
                'password' => 'user2026',
                'role'     => 'user',
            ],
            [
                'name'     => 'Kasir',
                'email'    => 'kasir@example.com',
                'password' => 'kasir2026',
                'role'     => 'kasir',
            ],
            [
                'name'     => 'Admin',
                'email'    => 'admin@example.com',
                'password' => 'admin2026',
                'role'     => 'admin',
            ],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make($data['password']),
                    'role'     => $data['role'],
                ]
            );
        }
    }
}
