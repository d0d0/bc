<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileTypeColumnTaskFilesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('task_files', function(Blueprint $table) {
            $table->boolean('header');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('task_files', function(Blueprint $table) {
            $table->dropColumn('header');
        });
    }

}
