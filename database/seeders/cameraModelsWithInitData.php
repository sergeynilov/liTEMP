<?php

namespace Database\Seeders;

use App\Models\CameraModel;
use Illuminate\Database\Seeder;

class cameraModelsWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cameraModels = CameraModel::factory()->count(30)->create([
        ]);

    }
}
