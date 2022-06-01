<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\NominationPhotoCover;
use App\Models\PhotoNomination;
use Illuminate\Database\Eloquent\Factories\Factory;

class NominationPhotoCoverFactory extends Factory
{
    protected $model = NominationPhotoCover::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'photo_id' => $this->faker->randomElement(PhotoNomination::all())['photo_id'],
            'nomination_id' => $this->faker->randomElement(PhotoNomination::all())['nomination_id'],
        ];

    }

}
