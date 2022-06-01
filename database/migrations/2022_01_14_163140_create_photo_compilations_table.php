<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoCompilationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_compilations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')->references('id')->on('photos')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->smallInteger('compilation_id')->unsigned();
            $table->foreign('compilation_id')->references('id')->on('compilations')->onDelete('CASCADE');

            $table->timestamp('created_at')->useCurrent();
            $table->index(['photo_id', 'compilation_id'], 'photo_compilations_photo_id_compilation_id_index');
        });
        \Artisan::call('db:seed', array('--class' => 'photoCompilationsWithInitData'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_compilations');
    }
}
