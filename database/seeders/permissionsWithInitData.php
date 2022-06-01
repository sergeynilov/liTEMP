<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \App\Models\User;


class permissionsWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*  admin - under admin area can do everything,
            manager - under admin area can crud of photos, set nominations
            user - access only for personal area  */
        $appAdminPermission = Permission::create(['name' => PERMISSION_APP_ADMIN, 'guard_name' => 'web']);
        $appManagerPermission = Permission::create(['name' => PERMISSION_APP_MANAGER, 'guard_name' => 'web']);
    }
}
