<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaypointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waypoints', function (Blueprint $table) {


            $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

            $table->bigIncrements('id');
            $table->string('name');


            if ('sqlite' === $driver) {
                $table->unsignedBigInteger('city_id')->default('');
            } else {
                $table->unsignedBigInteger('city_id');
            }

            $table->date('arrival');
            $table->date('departure');

            if ('sqlite' === $driver) {
                $table->unsignedBigInteger('itinerary_id')->default('');
            } else {
                $table->unsignedBigInteger('itinerary_id');
            }

            if ('sqlite' === $driver) {
                $table->unsignedBigInteger('user_id')->default('');
            } else {
                $table->unsignedBigInteger('user_id');
            }

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('itinerary_id')->references('id')->on('itineraries');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waypoints');
    }
}
