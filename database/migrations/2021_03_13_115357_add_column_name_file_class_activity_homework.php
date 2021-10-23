<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNameFileClassActivityHomework extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_activity_homework', function (Blueprint $table) {
            $table->string('file_name')->nullable();
            $table->char('state',1)->default('R')->comment('R=registrado,T=terminado,C=calificado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_activity_homework', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('file_name');
        });
    }
}
