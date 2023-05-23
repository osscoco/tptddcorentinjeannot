<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamp('dateLimit');

            $table->unsignedBigInteger('genderId');
            $table->foreign('genderId')->references('id')->on('genders');

            $table->unsignedBigInteger('rightId');
            $table->foreign('rightId')->references('id')->on('rights');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

;
