<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_code' => 'SADM', 'role_name' => 'Superadmin'],
            ['role_code' => 'USR', 'role_name' => 'User'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
