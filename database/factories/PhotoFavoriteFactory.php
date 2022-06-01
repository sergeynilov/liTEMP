<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\PhotoFavorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFavoriteFactory extends Factory
{
    protected $model = PhotoFavorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'photo_id' => $this->faker->randomElement(Photo::all())['id'],
            'user_id' => $this->faker->randomElement(User::all())['id'],
        ];

    }

}
