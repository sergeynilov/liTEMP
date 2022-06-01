<?php

namespace Database\Factories;

use App\Models\CameraModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CameraModelFactory extends Factory
{
    protected $model = CameraModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name_word= 'Model ' . $this->faker->unique()->word;
        $slugValue = Str::slug($name_word);

        return [
            'name' => $name_word,
            'slug' => $slugValue,
            'active' => true,
        ];
    }

}
