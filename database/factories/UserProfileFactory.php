<?php

namespace Database\Factories;

use App\Models\UserProfile;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserProfileFactory extends Factory
{
    protected $model = UserProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $current_year =  now()->year;
        $started_year_minus = (int)(config('app.started_year_minus', 80));

        return [
            'phone' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'instagram' => $this->faker->url,
            'facebook' => $this->faker->url,
            'twitter' => $this->faker->url,
            'px500' => $this->faker->url,
            'linkendin' => $this->faker->url,

            'unslplash' => $this->faker->url,
            'telegram' => $this->faker->url,
            'facebook_messenger' => $this->faker->url,
            'viber' => $this->faker->url,
            'whatsapp' => $this->faker->url,

            'youtube' => $this->faker->url,
            'vk' => $this->faker->url,
            'hour_rate' => $this->faker->numberBetween( 10, 90) * 10 ,
            'started_year' => $this->faker->numberBetween( $current_year-$started_year_minus, $current_year) ,
            'city_id' => $this->faker->randomElement(City::all())['id'],
            'send_message_copy_from_administration' => rand(0,1),
            'notify_about_messages_from_other_users' => rand(0,1),
            'getting_nomination' => rand(0,1),
            'new_comments_below_photo' => rand(0,1),
            'new_comments_on_thread_on_forum' => rand(0,1),
            'new_comments_on_tracked_topic_in_forum' => rand(0,1),
            'selection_of_photos_from_editorial_board_in_week' => rand(0,1),
            'receive_emails_about_new_events_and_offers' => rand(0,1),
            'notify_me_of_new_messages_by_email' => rand(0,1),
        ];

    }

}
