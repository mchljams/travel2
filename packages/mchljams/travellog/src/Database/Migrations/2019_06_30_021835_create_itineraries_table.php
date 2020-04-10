<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItinerariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itineraries', function (Blueprint $table) {

            $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

            $table->bigIncrements('id');
            $table->string('name');
            if ('sqlite' === $driver) {
                $table->unsignedBigInteger('user_id')->default('');
            } else {
                $table->unsignedBigInteger('user_id');
            }
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itineraries');
    }
}
