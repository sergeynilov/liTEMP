<?php

namespace Database\Seeders;

use App\Models\PhotoCompilation;
use Illuminate\Database\Seeder;

class photoCompilationsWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $photoCompilations = PhotoCompilation::factory()->count(35)->create([
        ]);
    }
}
