<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->references('id')->on('photos')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');

            $table->timestamp('created_at')->useCurrent();
            $table->index(['photo_id', 'user_id'], 'photo_favorites_photo_id_user_id_index');
        });
        \Artisan::call('db:seed', array('--class' => 'photoFavoritesWithInitData'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_favorites');
    }
}
