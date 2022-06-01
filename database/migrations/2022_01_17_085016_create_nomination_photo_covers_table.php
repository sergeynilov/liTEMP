<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominationPhotoCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomination_photo_covers', function (Blueprint $table) {
            $table->id();

            $table->smallInteger('nomination_id')->unsigned();
            $table->foreign('nomination_id')->references('id')->on('nominations')->onDelete('CASCADE');

            $table->foreignId('photo_id')->references('id')->on('photos')->onUpdate('RESTRICT')->onDelete('CASCADE');

            $table->timestamp('created_at')->useCurrent();
            $table->index(['photo_id', 'nomination_id'], 'nomination_photo_covers_photo_id_nomination_id_index');
        });
        \Artisan::call('db:seed', array('--class' => 'nominationPhotoCoversWithInitData'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nomination_photo_covers');
    }
}
