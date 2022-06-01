<?php

namespace Database\Factories;

use App\Models\Nomination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NominationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nomination::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title_word= 'Номинация '.$this->faker->unique()->word;
        $slugValue = Str::slug($title_word);

        return [
            'title' => ucwords($slugValue),
            'slug' => $slugValue,
            'active' => true,
            'color' => $this->faker->hexcolor(),
        ];
    }

}
