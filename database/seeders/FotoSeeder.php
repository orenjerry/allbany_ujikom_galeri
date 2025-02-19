<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $album = [
            ['id_user' => 2, 'nama_album' => 'mantap'],
            ['id_user' => 2, 'nama_album' => 'keren'],
        ];

        foreach ($album as $alb) {
            Album::create($alb, ['timestamps' => true]);
        }

        $images = glob(public_path('dummy_images/posts/*.*'));

        $destinationPath = public_path('images/post');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        foreach ($images as $image) {
            $imageName = basename($image);
            if ($imageName === 'Thumbs.db') {
                continue;
            }
            $album = Album::inRandomOrder()->first();
            copy($image, $destinationPath . '/' . $imageName);
            Foto::create([
                'id_user' => 2,
                'id_album' => $album->id,
                'lokasi_file' => 'images/post/' . $imageName,
                'judul_foto' => pathinfo($image, PATHINFO_FILENAME),
                'deskripsi_foto' => 'Ini adalah foto ' . pathinfo($image, PATHINFO_FILENAME),
            ]);
        }
    }
}
