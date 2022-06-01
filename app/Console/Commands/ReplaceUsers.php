<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator;
use Illuminate\Container\Container;

class ReplaceUsers extends Command
{
    /**     php artisan  command:ReplaceUsers
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ReplaceUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User
            ::orderBy('id', 'asc')
            ->get();
        $faker = \Faker\Factory::create();
        foreach ($users as $nextUser) {
            if( in_array($nextUser->name, ['Admin', 'Manager', 'John Doe', 'Jane Doe']) ) continue;
            $nextUser->name= $faker->name();
            $nextUser->email = $faker->unique()->safeEmail();
            $nextUser->save();

            $userProfile = UserProfile
                ::getByUserId($nextUser->id)
                ->first();
            if(!empty($userProfile)) {
                $userProfile->phone= $faker->phoneNumber();
                $userProfile->website = $faker->unique()->url();
                $userProfile->instagram = '';
                $userProfile->facebook = '';
                $userProfile->twitter = '';
                $userProfile->linkendin = '';
                $userProfile->unslplash = '';
                $userProfile->telegram = '';
                $userProfile->facebook_messenger = '';
                $userProfile->viber = '';
                $userProfile->whatsapp = '';
                $userProfile->youtube = '';
                $userProfile->vk = '';

                $userProfile->city_id = $faker->randomElement(City::all())['id'];

                $userProfile->save();
            }

        }

        return 0;
    }
}
