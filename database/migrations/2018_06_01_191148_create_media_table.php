<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('size');
            $table->string('type');
            $table->string('extension');
            $table->string('color');
            $table->string('alt')->nullable();
            $table->string('title')->nullable();
            $table->string('resolution_x')->nullable();
            $table->string('resolution_y')->nullable();
            $table->string('duration')->nullable();
            $table->string('path')->nullable();
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
        Schema::dropIfExists('media');
    }
}
