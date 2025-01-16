<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['username' => 'Superadmin', 'email' => 'superadmin@gmail.com', 'password' => bcrypt('password'), 'id_role' => 1, 'nama_lengkap' => 'Superadmin', 'alamat' => 'Jl. Superadmin'],
            ['username' => 'User', 'email' => 'user@gmail.com', 'password' => bcrypt('password'), 'id_role' => 2, 'nama_lengkap' => 'User', 'alamat' => 'Jl. User'],
        ];

        foreach ($users as $user) {
            Users::create($user);
        }
    }
}
