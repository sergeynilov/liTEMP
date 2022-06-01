<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoNominationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_nominations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->references('id')->on('photos')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->smallInteger('nomination_id')->unsigned();
            $table->foreign('nomination_id')->references('id')->on('nominations')->onDelete('CASCADE');

            $table->timestamp('created_at')->useCurrent();
            $table->index(['photo_id', 'nomination_id'], 'photo_nominations_photo_id_nomination_id_index');
        });
        \Artisan::call('db:seed', array('--class' => 'photoNominationsWithInitData'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_nominations');
    }
}
