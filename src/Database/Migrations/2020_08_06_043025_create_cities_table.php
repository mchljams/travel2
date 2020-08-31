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
            $table->id();
            $table->string('city')->nullable();
            $table->string('city_ascii')->nullable();
            $table->string('state_id')->nullable();
            $table->string('state_name')->nullable();
            $table->integer('county_fips')->nullable();
            $table->string('county_name')->nullable();
            $table->string('county_fips_all')->nullable();
            $table->string('county_name_all')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->integer('population')->nullable();
            $table->smallInteger('density')->nullable();
            $table->string('source')->nullable();
            $table->boolean('military')->nullable();
            $table->boolean('incorporated')->nullable();
            $table->string('timezone')->nullable();
            $table->tinyInteger('ranking')->nullable();
            $table->string('zips')->nullable();
            $table->bigInteger('simple_maps_id')->nullable();
            $table->timestamps();
        });
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
