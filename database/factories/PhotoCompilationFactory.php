<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\PhotoCompilation;
use App\Models\Compilation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoCompilationFactory extends Factory
{
    protected $model = PhotoCompilation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'photo_id' => $this->faker->randomElement(Photo::all())['id'],
            'compilation_id' => $this->faker->randomElement(Compilation::all())['id'],
        ];

    }

}
