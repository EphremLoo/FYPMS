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
            'mmu_id' => '1111111111',
            'email' => 'admin@example.com',
            'status' => User::STATUS_ACTIVE,
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('admin');

        $id = 1161105601;
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => 'supervisor' . $i,
                'mmu_id' => $id,
                'email' => 'supervisor' . $i . '@example.com',
                'status' => User::STATUS_ACTIVE,
                'password' => Hash::make('12345678'),
            ]);
            $user->assignRole('supervisor');
            $id++;
        }

        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => 'moderator' . $i,
                'mmu_id' => $id,
                'email' => 'moderator' . $i . '@example.com',
                'status' => User::STATUS_ACTIVE,
                'password' => Hash::make('12345678'),
            ]);
            $user->assignRole('moderator');
            $id++;
        }

        $id = 1151105600;
        for ($i = 0; $i < 50; $i++) {
            $user = User::create([
                'name' => 'student' . $i,
                'mmu_id' => $id,
                'email' => 'student' . $i . '@example.com',
                'status' => User::STATUS_ACTIVE,
                'password' => Hash::make('12345678'),
            ]);
            $user->assignRole('student');
            $id++;
        }
    }
}
