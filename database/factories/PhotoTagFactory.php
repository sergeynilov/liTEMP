<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\PhotoTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoTagFactory extends Factory
{
    protected $model = PhotoTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'photo_id' => $this->faker->randomElement(Photo::all())['id'],
            'tag_id' => $this->faker->randomElement(Tag::all())['id'],
        ];

    }

}
