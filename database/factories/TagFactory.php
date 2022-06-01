<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title_word= $this->faker->unique()->word;
        $slugValue = Str::slug($title_word);

        return [
            'title' => ucwords($title_word),
            'slug' => $slugValue,
            'active' => true,
        ];
    }

}
