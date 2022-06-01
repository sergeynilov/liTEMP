<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->references('id')->on('photos')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->smallInteger('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('CASCADE');

            $table->timestamp('created_at')->useCurrent();
            $table->index(['photo_id', 'tag_id'], 'photo_tags_photo_id_tag_id_index');
        });
        \Artisan::call('db:seed', array('--class' => 'photoTagsWithInitData'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_tags');
    }
}
