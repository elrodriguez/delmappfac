<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumFileClassActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_activities', function (Blueprint $table) {
            $table->string('url_file')->nullable();
            $table->string('name_file')->nullable();
            $table->string('extension')->nullable();
            $table->string('size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_activities', function (Blueprint $table) {
            $table->dropColumn('size');
            $table->dropColumn('extension');
            $table->dropColumn('name_file');
            $table->dropColumn('url_file');
        });
    }
}
