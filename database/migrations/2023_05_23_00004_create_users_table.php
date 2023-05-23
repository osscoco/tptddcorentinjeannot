<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('firstname');
            $table->string('lastname');
            $table->timestamp('dateOfBirth');

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
};
