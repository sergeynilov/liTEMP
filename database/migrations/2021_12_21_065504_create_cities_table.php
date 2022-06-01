<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('cities', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();

            $table->string('address',100);
            $table->string('postal_code',10)->nullable();
            $table->string('country',50);
            $table->string('federal_district',20);
            $table->string('region_type',10);
            $table->string('region',50);
            $table->string('area_type',10)->nullable();
            $table->string('area',50)->nullable();
            $table->string('city_type',10)->nullable();
            $table->string('city',50)->nullable();
            $table->string('settlement_type',10)->nullable();
            $table->string('settlement',50)->nullable();
            $table->string('kladr_id',20);
            $table->string('fias_id',50);

            $table->tinyInteger('fias_level')->unsigned();
            $table->tinyInteger('capital_marker')->unsigned();
            $table->string('okato',15);
            $table->string('oktmo',15);
            $table->smallInteger('tax_office')->unsigned();
            $table->string('timezone',50);
            $table->decimal('geo_lat',16,7);
            $table->decimal('geo_lon',16,7);
            $table->integer('population')->unsigned();
            $table->smallInteger('foundation_year');

            $table->timestamp('created_at')->useCurrent();
        });

        \Artisan::call('db:seed', array('--class' => 'CitiesTableSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
