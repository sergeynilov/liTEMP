<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PhotoFactory extends Factory
{
    protected $model = Photo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name_word= 'Фотография ' . $this->faker->word . ' ' . rand(1,500) .' '. $this->faker->word;
        $slugValue = Str::slug($name_word);//.'-'.now();

        $r= rand(1,4);
        return [
            'owner_id' => $this->faker->randomElement(User::all())['id'],
            'name' => $name_word,
            'slug' => $slugValue,
            'active' => ( $r == 1 ? false : true ),
            'published_at' => ( $r == 1 ? null : $this->faker->dateTimeBetween('-10 days', 'now', config('app.timezone') ) )
        ];

    }

}
