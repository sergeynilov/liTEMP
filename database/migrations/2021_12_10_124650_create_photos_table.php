<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('owner_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');

            $table->string('name', 100);
            $table->string('slug', 105);

            $table->boolean('active')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->boolean('shown_on_homepage')->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->index(['active', 'published_at'], 'photos_active_published_at_index');
            $table->index(['owner_id', 'name'], 'photos_owner_id_name_index');
        });
        \Artisan::call('db:seed', array('--class' => 'photosWithInitData'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
