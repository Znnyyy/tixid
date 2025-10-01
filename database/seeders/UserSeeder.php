<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('adminID'),
        ]);

        User::create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'role' => 'staff',
            'password' => Hash::make('staffID'),
        ]);
    }
}
