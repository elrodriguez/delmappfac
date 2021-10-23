<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnYearTeacherCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_courses', function (Blueprint $table) {
            $table->string('academic_season_id',4)->nullable();
            $table->foreign('academic_season_id','teacher_courses_academic_season_id_fk')->references('id')->on('academic_seasons')->onDelete('cascade');
        });
        Schema::table('cadastres', function (Blueprint $table) {
            $table->string('academic_season_id',4)->nullable();
            $table->foreign('academic_season_id','cadastres_academic_season_id_fk')->references('id')->on('academic_seasons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_courses', function (Blueprint $table) {
            $table->dropForeign('teacher_courses_academic_season_id_fk');
            $table->dropColumn('academic_season_id');
        });
        Schema::table('cadastres', function (Blueprint $table) {
            $table->dropForeign('cadastres_academic_season_id_fk');
            $table->dropColumn('academic_season_id');
        });
    }
}
