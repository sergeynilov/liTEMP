<?php

namespace Database\Seeders;

use App\Models\CameraLense;
use Illuminate\Database\Seeder;

class cameraLensesWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cameraLenses = CameraLense::factory()->count(30)->create([
        ]);

    }
}
