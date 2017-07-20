<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGooglesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('googles', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('email')->nullable();
          $table->string('image');
          $table->string('password', 60)->nullable();
          $table->string('provider')->nullable();
          $table->string('provider_id')->nullable();
          $table->rememberToken();
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
        Schema::dropIfExists('googles');
    }
}