<?php

namespace Database\Factories;

use App\Models\CameraLense;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CameraLenseFactory extends Factory
{
    protected $model = CameraLense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name_word= 'Lense ' . $this->faker->unique()->word;
        $slugValue = Str::slug($name_word);

        return [
            'name' => $name_word,
            'slug' => $slugValue,
            'active' => true,
        ];
    }

}
