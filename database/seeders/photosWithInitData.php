<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Photo;
use Illuminate\Database\Seeder;

class photosWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        \DB::table('photos')->delete();

        \DB::table('photos')->insert(array(
            0 =>
                array(
                    'id'                => 1,
                    'owner_id'          => 1,
                    'name'              => 'Фотография quae',
                    'slug'              => 'fotografiya-quae',
                    'active'            => 1,
                    'published_at'      => '2021-12-27 23:19:04',
                    'shown_on_homepage' => false,
                    'created_at'        => '2021-12-30 16:08:11',
                    'updated_at'        => null,
                ),
            1 =>
                array(
                    'id'                => 2,
                    'owner_id'          => 1,
                    'name'              => 'Фотография repudiandae',
                    'slug'              => 'fotografiya-repudiandae',
                    'active'            => 1,
                    'published_at'      => '2021-12-28 13:46:34',
                    'shown_on_homepage' => true,
                    'created_at'        => '2021-12-30 16:08:11',
                    'updated_at'        => null,
                ),
            2 =>
                array(
                    'id'                => 3,
                    'owner_id'          => 1,
                    'name'              => 'Фотография numquam',
                    'slug'              => 'fotografiya-numquam',
                    'active'            => 1,
                    'published_at'      => '2021-12-24 09:53:48',
                    'shown_on_homepage' => true,
                    'created_at'        => '2021-12-30 16:08:12',
                    'updated_at'        => null,
                ),
            3 =>
                array(
                    'id'                => 4,
                    'owner_id'          => 4,
                    'name'              => 'Фотография eaque',
                    'slug'              => 'fotografiya-eaque',
                    'active'            => 1,
                    'published_at'      => '2021-12-27 04:10:30',
                    'shown_on_homepage' => false,
                    'created_at'        => '2021-12-30 16:08:12',
                    'updated_at'        => null,
                ),
            4 =>
                array(
                    'id'                => 5,
                    'owner_id'          => 1,
                    'name'              => 'Фотография veniam',
                    'slug'              => 'fotografiya-veniam',
                    'active'            => 0,
                    'published_at'      => null,
                    'shown_on_homepage' => false,
                    'created_at'        => '2021-12-30 16:08:12',
                    'updated_at'        => null,
                ),
            5 =>
                array(
                    'id'                => 6,
                    'owner_id'          => 1,
                    'name'              => 'Фотография nemo',
                    'slug'              => 'fotografiya-nemo',
                    'active'            => 1,
                    'published_at'      => '2021-12-24 08:42:30',
                    'shown_on_homepage' => false,
                    'created_at'        => '2021-12-30 16:08:12',
                    'updated_at'        => null,
                ),
            6 =>
                array(
                    'id'                => 7,
                    'owner_id'          => 3,
                    'name'              => 'Фотография ullam',
                    'slug'              => 'fotografiya-ullam',
                    'active'            => 0,
                    'published_at'      => null,
                    'shown_on_homepage' => false,
                    'created_at'        => '2021-12-30 16:08:13',
                    'updated_at'        => null,
                ),
            7 =>
                array(
                    'id'                => 8,
                    'owner_id'          => 4,
                    'name'              => 'Фотография nisi',
                    'slug'              => 'fotografiya-nisi',
                    'active'            => 1,
                    'published_at'      => '2021-12-28 05:21:04',
                    'shown_on_homepage' => false,
                    'created_at'        => '2021-12-30 16:08:13',
                    'updated_at'        => null,
                ),
            8 =>
                array(
                    'id'                => 9,
                    'owner_id'          => 3,
                    'name'              => 'Фотография iste',
                    'slug'              => 'fotografiya-iste',
                    'active'            => 1,
                    'published_at'      => '2021-12-27 13:06:16',
                    'shown_on_homepage' => false,
                    'created_at'        => '2021-12-30 16:08:13',
                    'updated_at'        => null,
                ),
            9 =>
                array(
                    'id'                => 10,
                    'owner_id'          => 1,
                    'name'              => 'Фотография laborum',
                    'slug'              => 'fotografiya-laborum',
                    'active'            => 0,
                    'published_at'      => null,
                    'shown_on_homepage' => false,
                    'created_at'        => '2021-12-30 16:08:13',
                    'updated_at'        => null,
                ),
        ));


//        return;
        \DB::table('media')->delete();
        \DB::table('media')->insert(array(
            0 =>
                array(
                    'id'                    => 1,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 1,
                    'uuid'                  => '26592405-676e-4a8a-bacf-2635e385791e',
                    'collection_name'       => 'photo',
                    'name'                  => 'b22de6791bca17184093c285e1c4b4b5',
                    'file_name'             => 'img-13.jpg',
                    'mime_type'             => 'image/jpg',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 1805,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 1,
                    'created_at'            => '2021-12-30 16:08:11',
                    'updated_at'            => '2021-12-30 16:08:11',
                ),
            1 =>
                array(
                    'id'                    => 2,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 2,
                    'uuid'                  => '507c9fdc-0985-4f5f-9860-f5ee528c7cb8',
                    'collection_name'       => 'photo',
                    'name'                  => 'd8a70c6f04dcc146b88aadae813a964b',
                    'file_name'             => 'img-22.jpg',
                    'mime_type'             => 'image/png',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 1613,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 2,
                    'created_at'            => '2021-12-30 16:08:12',
                    'updated_at'            => '2021-12-30 16:08:12',
                ),
            2 =>
                array(
                    'id'                    => 3,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 3,
                    'uuid'                  => '0a23bee1-3478-4f18-a296-30b61a36be68',
                    'collection_name'       => 'photo',
                    'name'                  => '66b18e1683926a0f0af63881080f69a6',
                    'file_name'             => 'bg-1.jpg',
                    'mime_type'             => 'image/png',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 1529,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 3,
                    'created_at'            => '2021-12-30 16:08:12',
                    'updated_at'            => '2021-12-30 16:08:12',
                ),
            3 =>
                array(
                    'id'                    => 4,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 4,
                    'uuid'                  => 'f5370907-3e85-45d6-963d-f4a8d53544ed',
                    'collection_name'       => 'photo',
                    'name'                  => 'ca140d78b67d45f0ef0ce585cd571c77',
                    'file_name'             => 'ca140d78b67d45f0ef0ce585cd571c77.png',
                    'mime_type'             => 'image/png',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 1830,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 4,
                    'created_at'            => '2021-12-30 16:08:12',
                    'updated_at'            => '2021-12-30 16:08:12',
                ),
            4 =>
                array(
                    'id'                    => 5,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 5,
                    'uuid'                  => 'a461934d-f31c-40af-a2b3-8f3ddccd4a02',
                    'collection_name'       => 'photo',
                    'name'                  => 'd1db9886f3c5f9b3d3345e278d7f36ee',
                    'file_name'             => 'd1db9886f3c5f9b3d3345e278d7f36ee.png',
                    'mime_type'             => 'image/png',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 1640,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 5,
                    'created_at'            => '2021-12-30 16:08:12',
                    'updated_at'            => '2021-12-30 16:08:12',
                ),
            5 =>
                array(
                    'id'                    => 6,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 6,
                    'uuid'                  => '2136af1e-89a1-4f9a-8446-def0e1cdebb6',
                    'collection_name'       => 'photo',
                    'name'                  => '2080c473273335b8d3c610dbad3aad5e',
                    'file_name'             => 'img-12.jpg',
                    'mime_type'             => 'image/png',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 1720,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 6,
                    'created_at'            => '2021-12-30 16:08:13',
                    'updated_at'            => '2021-12-30 16:08:13',
                ),
            6 =>
                array(
                    'id'                    => 7,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 7,
                    'uuid'                  => '5b9f138c-73bd-4f6a-bc0c-a0297bcae105',
                    'collection_name'       => 'photo',
                    'name'                  => '84d3086c417d2cbab0945b10644c9fd0',
                    'file_name'             => '84d3086c417d2cbab0945b10644c9fd0.png',
                    'mime_type'             => 'image/png',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 1665,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 7,
                    'created_at'            => '2021-12-30 16:08:13',
                    'updated_at'            => '2021-12-30 16:08:13',
                ),
            7 =>
                array(
                    'id'                    => 8,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 8,
                    'uuid'                  => '6a8837ba-a9c4-4dce-a654-34c8b99aa993',
                    'collection_name'       => 'photo',
                    'name'                  => '93a4e9520e42d6207f9f2bda5061881a',
                    'file_name'             => 'img-15.jpg',
                    'mime_type'             => 'image/png',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 1560,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 8,
                    'created_at'            => '2021-12-30 16:08:13',
                    'updated_at'            => '2021-12-30 16:08:13',
                ),
            8 =>
                array(
                    'id'                    => 9,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 9,
                    'uuid'                  => 'ada815e0-06ba-48e6-8aec-60e9b1e1f0c1',
                    'collection_name'       => 'photo',
                    'name'                  => 'f79d134258e169a4fc1000d1098b0505',
                    'file_name'             => 'nom-ico1.png',
                    'mime_type'             => 'image/png',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 1838,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 9,
                    'created_at'            => '2021-12-30 16:08:13',
                    'updated_at'            => '2021-12-30 16:08:13',
                ),
            9 =>
                array(
                    'id'                    => 10,
                    'model_type'            => 'App\\Models\\Photo',
                    'model_id'              => 10,
                    'uuid'                  => 'd82e7986-ae7a-4af9-80fc-e97e94957f55',
                    'collection_name'       => 'photo',
                    'name'                  => 'efb79b138b3b66ec893c2eaae9e25725',
                    'file_name'             => 'efb79b138b3b66ec893c2eaae9e25725.png',
                    'mime_type'             => 'image/png',
                    'disk'                  => 'public',
                    'conversions_disk'      => 'public',
                    'size'                  => 2267,
                    'manipulations'         => '[]',
                    'custom_properties'     => '[]',
                    'generated_conversions' => '[]',
                    'responsive_images'     => '[]',
                    'order_column'          => 10,
                    'created_at'            => '2021-12-30 16:08:14',
                    'updated_at'            => '2021-12-30 16:08:14',
                ),


            array(
                'id'                    => 11,
                'model_type'            => 'App\\Models\\User',
                'model_id'              => 1,
                'uuid'                  => '2fb4fa16-cbdc-4902-bdf5-d7e6d738d91f',
                'collection_name'       => 'avatar',
                'name'                  => 'b22de6791bca17184093c285e1c4b4b5',
                'file_name'             => 'avatar_1.jpg',
                'mime_type'             => 'image/jpg',
                'disk'                  => 'public',
                'conversions_disk'      => 'public',
                'size'                  => 14305,
                'manipulations'         => '[]',
                'custom_properties'     => '[]',
                'generated_conversions' => '[]',
                'responsive_images'     => '[]',
                'order_column'          => 1,
                'created_at'            => '2021-12-30 16:08:11',
                'updated_at'            => '2021-12-30 16:08:11',
            ),
            array(
                'id'                    => 12,
                'model_type'            => 'App\\Models\\User',
                'model_id'              => 2,
                'uuid'                  => '2fb4fa16-cbdc-4752-bdf5-d7e6d738d85f',
                'collection_name'       => 'avatar',
                'name'                  => 'b22de6791bca17184093c285e1c4b4b5',
                'file_name'             => 'avatar_2.jpg',
                'mime_type'             => 'image/jpg',
                'disk'                  => 'public',
                'conversions_disk'      => 'public',
                'size'                  => 14305,
                'manipulations'         => '[]',
                'custom_properties'     => '[]',
                'generated_conversions' => '[]',
                'responsive_images'     => '[]',
                'order_column'          => 1,
                'created_at'            => '2021-12-30 16:08:11',
                'updated_at'            => '2021-12-30 16:08:11',
            ),

            array(
                'id'                    => 13,
                'model_type'            => 'App\\Models\\User',
                'model_id'              => 3,
                'uuid'                  => '8fb4fa16-cbdc-4722-bdf5-d7e6d738d85f',
                'collection_name'       => 'avatar',
                'name'                  => 'b82de6791bca17184193c285e1c4b4b5',
                'file_name'             => 'avatar_3.jpg',
                'mime_type'             => 'image/jpg',
                'disk'                  => 'public',
                'conversions_disk'      => 'public',
                'size'                  => 6105,
                'manipulations'         => '[]',
                'custom_properties'     => '[]',
                'generated_conversions' => '[]',
                'responsive_images'     => '[]',
                'order_column'          => 1,
                'created_at'            => '2021-12-30 16:08:11',
                'updated_at'            => '2021-12-30 16:08:11',
            ),

            array(
                'id'                    => 14,
                'model_type'            => 'App\\Models\\User',
                'model_id'              => 4,
                'uuid'                  => '8fb4fa93-cbdc-4722-bdf5-d7e6d738d03f',
                'collection_name'       => 'avatar',
                'name'                  => 'b82de6291bca17184543c285e1c4b1b5',
                'file_name'             => 'avatar_4.jpg',
                'mime_type'             => 'image/jpg',
                'disk'                  => 'public',
                'conversions_disk'      => 'public',
                'size'                  => 5605,
                'manipulations'         => '[]',
                'custom_properties'     => '[]',
                'generated_conversions' => '[]',
                'responsive_images'     => '[]',
                'order_column'          => 1,
                'created_at'            => '2021-12-30 16:08:11',
                'updated_at'            => '2021-12-30 16:08:11',
            ),

        ));


        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 300; $i++) {
            $photo = Photo::factory()->count(1)->create([]);
            if ( ! empty($photo[0])) {
//                             \Log::info(  varDump($photo[0], ' -1 $photo[0]::') );
                try {
                    $photo[0]->addMedia($faker->image())->toMediaCollection('photo');
                } catch (Exception $lException) {
                    \Log::info(  varDump($lException, ' -1 photosWithInitData $lException::') );
                }


            }
        }

    }
}
