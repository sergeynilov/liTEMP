<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Actions\Fortify\CreateNewUser;

class usersWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app(CreateNewUser::class)->create([
            'id'         => 1,
            'name'       => 'Admin',
            'email'      => 'admin@site.com',
            'password'   => '11111111',
            'status'     => 'A',
        ], true, [PERMISSION_APP_ADMIN]);

        app(CreateNewUser::class)->create([
            'id'         => 2,
            'name'       => 'Manager',
            'email'      => 'manager@site.com',
            'password'   => '11111111',
            'status'     => 'A',
        ], true, [PERMISSION_APP_MANAGER]);


        app(CreateNewUser::class)->create([
            'id'         => 3,
            'name'       => 'John Doe',
            'email'      => 'john_doe@site.com',
            'password'   => '11111111',
            'status'     => 'A',
        ], true, []);

        app(CreateNewUser::class)->create([
            'id'         => 4,
            'name'       => 'Jane Doe',
            'email'      => 'jane_doe@site.com',
            'password'   => '11111111',
            'status'     => 'A',
        ], true, []);


    }
}
