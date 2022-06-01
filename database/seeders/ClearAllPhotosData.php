<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClearAllPhotosData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('photos')->delete();
        \DB::table('nominations')->delete();
        \DB::table('tags')->delete();

    }
}
