<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTimeExam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_activities', function (Blueprint $table) {
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->time('duration')->default('00:45:00');
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
            $table->dropColumn('duration');
            $table->dropColumn('date_end');
            $table->dropColumn('date_start');
        });
    }
}
