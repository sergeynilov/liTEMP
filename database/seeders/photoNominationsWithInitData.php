<?php

namespace Database\Seeders;

use App\Models\PhotoNomination;
use Illuminate\Database\Seeder;

class photoNominationsWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('photo_nominations')->insert(array(
            0 =>
                array(
                    'id'            => 61,
                    'photo_id'      => 2,
                    'nomination_id' => 15,
                    'created_at'    => '2022-01-24 08:05:11',
                ),
            1 =>
                array(
                    'id'            => 140,
                    'photo_id'      => 3,
                    'nomination_id' => 9,
                    'created_at'    => '2022-01-24 08:05:12',
                ),
            2 =>
                array(
                    'id'            => 150,
                    'photo_id'      => 2,
                    'nomination_id' => 15,
                    'created_at'    => '2022-01-24 08:05:13',
                ),
            3 =>
                array(
                    'id'            => 181,
                    'photo_id'      => 3,
                    'nomination_id' => 10,
                    'created_at'    => '2022-01-24 08:05:13',
                ),
            4 =>
                array(
                    'id'            => 237,
                    'photo_id'      => 3,
                    'nomination_id' => 12,
                    'created_at'    => '2022-01-24 08:05:14',
                ),
        ));

        $photoNominations = PhotoNomination::factory()->count(240)->create([
        ]);


        \DB::table('nominations')->insert(array(
            array(
                'id'       => 16,
                'title'    => 'Тестируем картинки',
                'slug'     => 'тестируем-картинки',
                'ordering' => 16,
                'color'    => '#ff021b',
                'active'   => 1,
            )
        ));
        ///////////////////* CREATE TABLE `nominations` (
        //  `id` smallint unsigned NOT NULL AUTO_INCREMENT,
        //  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
        //  `slug` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
        //  `ordering` smallint unsigned NOT NULL,
        //  `color` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
        //  `active` tinyint(1) NOT NULL DEFAULT '0',
        //  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //  `updated_at` timestamp NULL DEFAULT NULL,
        //  PRIMARY KEY (`id`), */
        \DB::table('photo_nominations')->insert(array(
            array(
                'photo_id'      => 1,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:11',
            ),
            array(
                'photo_id'      => 2,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:12',
            ),
            array(
                'photo_id'      => 3,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:13',
            ),
            array(
                'photo_id'      => 4,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:13',
            ),


            array(
                'photo_id'      => 5,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:14',
            ),

            array(
                'photo_id'      => 6,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:14',
            ),

            array(
                'photo_id'      => 7,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:14',
            ),

            array(
                'photo_id'      => 8,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:14',
            ),

            array(
                'photo_id'      => 9,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:14',
            ),

            array(
                'photo_id'      => 10,
                'nomination_id' => 16,
                'created_at'    => '2022-01-24 08:05:14',
            ),

        ));

    }
}
