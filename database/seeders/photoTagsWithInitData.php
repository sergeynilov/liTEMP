<?php

namespace Database\Seeders;

use App\Models\PhotoTag;
use Illuminate\Database\Seeder;

class photoTagsWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $photoTags = PhotoTag::factory()->count(900)->create([
        ]);


    }
}
