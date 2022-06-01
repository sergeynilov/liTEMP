<?php

namespace Database\Factories;

use App\Models\Camera;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CameraFactory extends Factory
{
    protected $model = Camera::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name_word= 'Camera ' . $this->faker->unique()->word;
        $slugValue = Str::slug($name_word);

        return [
            'name' => $name_word,
            'slug' => $slugValue,
            'active' => true,
        ];
    }

}
