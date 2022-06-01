<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompilationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('compilations', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('title', 50)->unique();
            $table->string('slug', 55)->index();

            $table->smallInteger('ordering')->unsigned();
            $table->boolean('active')->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->index(['active'], 'compilations_active_index');
        });
        \Artisan::call('db:seed', array('--class' => 'compilationsWithInitData'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compilations');
    }
}
