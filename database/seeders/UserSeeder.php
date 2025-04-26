<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name' => 'supervisor',
            'email' => 'supervisor@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('supervisor');

        $user = User::create([
            'name' => 'moderator',
            'email' => 'moderator@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('moderator');

        $user = User::create([
            'name' => 'student1',
            'email' => 'student1@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('student');
    }
}
