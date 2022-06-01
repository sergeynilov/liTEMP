<?php

namespace Database\Seeders;

use App\Models\PhotoLike;
use Illuminate\Database\Seeder;

class photoLikesWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $photoLikes = PhotoLike::factory()->count(800)->create([]);
    }
}
