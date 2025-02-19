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
        $images = glob(public_path('dummy_images/profile/*.*'));
        $destinationPath = public_path('images/profile');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $users = [
            ['username' => 'Superadmin', 'email' => 'superadmin@gmail.com', 'password' => bcrypt('password'), 'id_role' => 1, 'nama_lengkap' => 'Superadmin', 'alamat' => 'Jl. Superadmin', 'accepted' => true],
            ['username' => 'User', 'email' => 'user@gmail.com', 'password' => bcrypt('password'), 'id_role' => 2, 'nama_lengkap' => 'User', 'alamat' => 'Jl. User', 'accepted' => true],
        ];

        foreach ($users as $user) {
            $createdUser = Users::create($user);

            $userImagePath = $destinationPath . '/' . $createdUser->id;
            if (!file_exists($userImagePath)) {
                mkdir($userImagePath, 0777, true);
            }

            if (!empty($images)) {
                $image = $images[array_rand($images)];
                $extension = pathinfo($image, PATHINFO_EXTENSION);
                $imageName = time() . '-' . rand(100, 999). '.' . $extension;
                if ($imageName !== 'Thumbs.db') {
                    copy($image, $userImagePath . '/' . $imageName);

                    $createdUser->update(['foto_profil' => 'images/profile/' . $createdUser->id . '/' . $imageName]);
                }
            }
        }
    }
}
