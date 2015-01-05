<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolutionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('solutions', function($table) {
            $table->increments('id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('solutions');
    }

}
