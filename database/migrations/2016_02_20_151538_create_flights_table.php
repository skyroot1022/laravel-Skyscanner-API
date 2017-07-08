<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('quote_id');
            $table->integer('price');
            $table->timestamp('dateFrom');
            $table->timestamp('dateTo');

            $table->string('from');
            $table->string('from_id');
            $table->string('to');
            $table->string('to_id');

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
        Schema::drop('flights');
    }
}
