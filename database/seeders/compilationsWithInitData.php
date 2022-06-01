<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class compilationsWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('compilations')->delete();

        \DB::table('compilations')->insert(array(
            array(
                'id'       => 1,
                'title'    => 'Подборка недели',
                'slug'     => 'подборка-недели',
                'ordering' => 1,
                'active'   => 1,
            ),

            array(
                'id'       => 2,
                'title'    => 'Лучшие фото месяца',
                'slug'     => 'лучшие-фото-месяца',
                'ordering' => 2,
                'active'   => 1,
            ),

            array(
                'id'       => 3,
                'title'    => 'Лучшие фото сезона',
                'slug'    => 'лучшие-фото-сезона',
                'ordering' => 3,
                'active'   => false,
            ),

            array(
                'id'       => 4,
                'title'    => 'Лучшие свадебные фото',
                'slug'    => 'лучшие-свадебные-фото',
                'ordering' => 4,
                'active'   => 1,
            ),

            array(
                'id'       => 5,
                'title'    => 'Подборка животных',
                'slug'    => 'подборка-животных',
                'ordering' => 5,
                'active'   => 1,
            ),

            array(
                'id'       => 6,
                'title'    => 'Подборка с природы',
                'slug'    => 'подборка-с-природы',
                'ordering' => 6,
                'active'   => 1,
            ),


        ));

    }
}
