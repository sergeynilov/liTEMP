<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\PhotoNomination;
use App\Models\Nomination;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoNominationFactory extends Factory
{
    protected $model = PhotoNomination::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'photo_id' => $this->faker->randomElement(Photo::all())['id'],
            'nomination_id' => $this->faker->randomElement(Nomination::all())['id'],
        ];

    }

}
