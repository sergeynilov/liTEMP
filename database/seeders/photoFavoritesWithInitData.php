<?php

namespace Database\Seeders;

use App\Models\PhotoFavorite;
use Illuminate\Database\Seeder;

class photoFavoritesWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $photoFavorites = PhotoFavorite::factory()->count(600)->create([]);

    }
}
