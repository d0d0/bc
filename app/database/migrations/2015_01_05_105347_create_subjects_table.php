<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('subjects', function($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('year');
            $table->integer('session');
            $table->integer('teacher')->unsigned();
            $table->foreign('teacher')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('subjects');
    }

}
