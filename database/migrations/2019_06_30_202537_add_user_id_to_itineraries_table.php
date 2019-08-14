<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToItinerariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itineraries', function (Blueprint $table) {


            $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

            if ('sqlite' === $driver) {
                $table->unsignedBigInteger('user_id')->default('');
            } else {
                $table->unsignedBigInteger('user_id');
            }

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
        Schema::table('itineraries', function (Blueprint $table) {

            $table->dropColumn('user_id');

            $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

            if ('sqlite' !== $driver) {

                $table->dropForeign(['user_id']);
            }
        });
    }
}
