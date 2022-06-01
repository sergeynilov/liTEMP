<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominationsTable extends Migration
{
    public function up()
    {
        Schema::create('nominations', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();

            $table->string('title', 50)->unique();
            $table->string('slug', 55)->index();
            $table->smallInteger('ordering')->unsigned();
            $table->string('color', 10);


            $table->boolean('active')->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->index(['active'], 'nominations_active_index');
        });
        \Artisan::call('db:seed', array('--class' => 'nominationsWithInitData'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nominations');
    }
}
