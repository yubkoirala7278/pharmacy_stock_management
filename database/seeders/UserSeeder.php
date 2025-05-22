<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Dr. John Carter',
                'email' => 'john.carter@pharmacy.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emma Wilson',
                'email' => 'emma.wilson@pharmacy.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'pharmacist',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@pharmacy.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'role' => 'pharmacist',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sarah Davis',
                'email' => 'sarah.davis@pharmacy.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Lee',
                'email' => 'david.lee@pharmacy.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laura Martinez',
                'email' => 'laura.martinez@pharmacy.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'James Thompson',
                'email' => 'james.thompson@pharmacy.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'pharmacist',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emily Clark',
                'email' => 'emily.clark@pharmacy.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Robert Harris',
                'email' => 'robert.harris@pharmacy.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sophia Lewis',
                'email' => 'sophia.lewis@pharmacy.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
