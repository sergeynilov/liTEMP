<?php

namespace Database\Seeders;

use App\Models\NominationPhotoCover;
use Illuminate\Database\Seeder;

class nominationPhotoCoversWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nominationPhotoCovers = NominationPhotoCover::factory()->count(40)->create([
        ]);

    }
}
