<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCameraModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camera_models', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->string('name', 100)->unique();
            $table->string('slug', 105)->index();

            $table->boolean('active')->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->index(['active'], 'camera_models_active_index');
        });
        \Artisan::call('db:seed', array('--class' => 'cameraModelsWithInitData'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('camera_models');
    }
}
