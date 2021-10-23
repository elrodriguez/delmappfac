<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsTablesCadastre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academic_charges', function (Blueprint $table) {
            $table->unsignedBigInteger('curricula_id')->nullable();
            $table->foreign('curricula_id','academic_charges_curricula_id_fk')->references('id')->on('curriculas');
        });
        Schema::table('cadastres', function (Blueprint $table) {
            $table->unsignedBigInteger('curricula_id')->nullable();
            $table->foreign('curricula_id','cadastres_curricula_id_fk')->references('id')->on('curriculas');
        });
        Schema::table('teacher_courses', function (Blueprint $table) {
            $table->boolean('state')->default(true);
            $table->unsignedBigInteger('curricula_id')->nullable();
            $table->foreign('curricula_id','teacher_courses_curricula_id_fk')->references('id')->on('curriculas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academic_charges', function (Blueprint $table) {
            $table->dropForeign('academic_charges_curricula_id_fk');
            $table->dropColumn('curricula_id');
        });
        Schema::table('cadastres', function (Blueprint $table) {
            $table->dropForeign('cadastres_curricula_id_fk');
            $table->dropColumn('curricula_id');
        });
        Schema::table('teacher_courses', function (Blueprint $table) {
            $table->dropForeign('teacher_courses_curricula_id_fk');
            $table->dropColumn('curricula_id');
        });
    }
}
