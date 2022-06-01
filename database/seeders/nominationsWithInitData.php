<?php

namespace Database\Seeders;

use App\Models\Nomination;
use Illuminate\Database\Seeder;

class nominationsWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nominations =
            Nomination::factory()
            ->count(15)->
                sequence(fn ($sequence) => ['ordering' => $sequence->index])->create([
        ]);

    }
}
