<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class userProfilesWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users= User::get();
        foreach( $users as $nextUser ) {
            $userProfile = UserProfile::factory()->create([
                'user_id' => $nextUser->id,
            ]);
        }
    }
}
