<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_profile', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');

            $table->string('phone',200)->nullable();
            $table->string('website',200)->nullable();
            $table->string('instagram',200)->nullable();
            $table->string('facebook',200)->nullable();

            $table->string('twitter',200)->nullable();
            $table->string('px500',200)->nullable();
            $table->string('linkendin',200)->nullable();

            $table->string('unslplash',200)->nullable();
            $table->string('telegram',200)->nullable();
            $table->string('facebook_messenger',200)->nullable();
            $table->string('viber',200)->nullable();
            $table->string('whatsapp',200)->nullable();


            $table->string('youtube',200)->nullable();
            $table->string('vk',200)->nullable();

            $table->integer('hour_rate',)->unsigned()->nullable();
            $table->smallInteger('started_year',)->unsigned()->nullable();

            $table->smallInteger('city_id')->unsigned()->nullable();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');

            $table->boolean('send_message_copy_from_administration')->default(false);
            $table->boolean('notify_about_messages_from_other_users')->default(false);
            $table->boolean('getting_nomination')->default(false);
            $table->boolean('new_comments_below_photo')->default(false);
            $table->boolean('new_comments_on_thread_on_forum')->default(false);
            $table->boolean('new_comments_on_tracked_topic_in_forum')->default(false);
            $table->boolean('new_photos_on_tracked_photographer_page')->default(false);
            $table->boolean('selection_of_photos_from_editorial_board_in_week')->default(false);
            $table->boolean('receive_emails_about_new_events_and_offers')->default(false);
            $table->boolean('notify_me_of_new_messages_by_email')->default(false);



            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        \Artisan::call('db:seed', array('--class' => 'userProfilesWithInitData'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_profile');
    }
}
