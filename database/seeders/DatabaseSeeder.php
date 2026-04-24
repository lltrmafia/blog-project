<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🔹 ADMIN
        $adminData = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123123'),
        ];

        $admin = User::firstOrCreate(
            ['email' => $adminData['email']],
            $adminData
        );

        $adminRole = Role::firstOrCreate([
            'title' => RoleEnum::ADMIN->value
        ]);

        $admin->roles()->sync([$adminRole->id]);

        // 🔹 MANAGER
        $managerData = [
            'name' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('123123123'),
        ];

        $manager = User::firstOrCreate(
            ['email' => $managerData['email']],
            $managerData
        );

        $managerRole = Role::firstOrCreate([
            'title' => RoleEnum::MANAGER->value
        ]);

        $manager->roles()->sync([$managerRole->id]);
    }
}
