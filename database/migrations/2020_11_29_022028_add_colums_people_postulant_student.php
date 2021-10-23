<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsPeoplePostulantStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('id_person')->nullable();
            $table->foreign('id_person','students_id_person_foreign')->references('id')->on('people')->onDelete('cascade');
        });
        Schema::table('postulants', function (Blueprint $table) {
            $table->unsignedBigInteger('id_person')->nullable();
            $table->foreign('id_person','postulants_id_person_foreign')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postulants', function (Blueprint $table) {
            $table->dropForeign('postulants_id_person_foreign');
        });
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign('students_id_person_foreign');
        });
    }
}
