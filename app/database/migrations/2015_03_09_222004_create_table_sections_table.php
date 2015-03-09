<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSectionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sections', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('block_id')->unsigned();
            $table->foreign('block_id')->references('id')->on('blocks');
            $table->string('name');
            $table->integer('points')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('sections');
    }

}
